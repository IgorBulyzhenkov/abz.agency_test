<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class UsersController extends Controller
{
    public function index($id = null): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        if (!is_null($id)) {

            if(!is_numeric($id)){
                return response([
                    "success"       =>  false,
                    "message"       => "The user with the requested id does not exist",
                    "fails"         => [
                        "userId"    => [
                            "The user must be an integer."
                        ]
                    ]
                ], 400);
            }

            $user = User::query()
                ->where('id', '=', $id)
                ->first();

            if(!$user){
                return response([
                    "success" =>  false,
                    "message" => "User not found"
                ], 404);
            }

            $user = [
                'id' => $user->id,
                'name' => $user->name,
                'position_id' => $user->position_id,
                'position' => $user->position->name,
                'email' => $user->email,
                'phone' => $user->phone,
                "registration_timestamp" => $user->created_at,
                "photo" =>  $user->photo,
            ];

            return response([
                'status'    => true,
                'user'      => $user
            ], 200);
        }

        $users          = User::paginate(6);
        $currentPage    = $users->currentPage();

        $nextUrl    = $users->nextPageUrl() ? $users->nextPageUrl() : null;
        $prevUrl    = $users->previousPageUrl() ? $users->previousPageUrl() : null;

        $arrUsers   = [];

        foreach ($users as $user) {
            $arrUsers[] = [
                'id'            => $user->id,
                'photo'         => $user->photo,
                'name'          => $user->name,
                'position_id'   => $user->position_id,
                'position'      => $user->position->name,
                'email'         => $user->email,
                'phone'         => $user->phone
            ];
        }

        $response = [
            'success'       => true,
            'total_pages'   => $users->lastPage(),
            'total_users'   => $users->total(),
            'count'         => $users->count(),
            'page'          => $currentPage,
            'links'         => [
                'next_url'  => $nextUrl,
                'prev_url'  => $prevUrl,
            ],
            "users"         => $arrUsers
        ];

        return response($response);
    }

    public function store(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $validator = Validator::make(
            $request->all(), [
                'token' => ['required', 'string'],
            ]
        );

        $token = TokenController::checkToken($request->input("token"));

        if ($validator->fails() || $token) {
            return response()->json([
                'status'    => false,
                "message"   => "The token expired."
            ], 401, [
                'Content-Type' => 'application/json'
            ]);
        }

        $validator = Validator::make(
            $request->all(), [
                'email' => ['unique:users'],
                'phone' => ['unique:users'],
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                "message"   => "User with this phone or email already exist"
            ], 409, [
                'Content-Type' => 'application/json'
            ]);
        }

        $validator = Validator::make(
            $request->all(), [
                'photo' => ['mimes:jpeg,jpg', 'image', 'required', 'max:5000'],
                'email' => [
                    'required',
                    'email',
                    'max:100',
                    'min:6',
                    'string',
                    'regex:/^(?:[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\]$/'
                ],
                'name'      => ['required', 'max:60', 'min:2', 'string'],
                'position'  => ['required', 'integer'],
                'phone'     => [
                    'required',
                    'regex:/^[\+]{0,1}380([0-9]{9})$/'
                ],
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                "message"   => "Validation failed",
                'fails'     => $validator
                    ->errors()
                    ->getMessages()
            ], 422, [
                'Content-Type' => 'application/json'
            ]);
        }

        $photo      = $request->file('photo');
        $fileName   = time() . '.' . $photo->getClientOriginalExtension();
        $path       = $request->file('photo')->getRealPath();
        $this->saveAvatarThumbs($path, $fileName);

        $user = User::query()->create([
            'name'          => $request->input("name"),
            'email'         => $request->input("email"),
            'phone'         => $request->input("phone"),
            'position_id'   => $request->input("position"),
            'photo'         => env('APP_URL').'images/users/'.$fileName
        ]);

        if($user) {
            return response([
                'status'    => true,
                'user'      => $user->id,
                'message'   => 'New user successfully registered'
            ], 201);
        } else {
            return response([
                'status'    => false,
                'message'   => 'bad request'
            ], 404);
        }

    }

    private function saveAvatarThumbs($path, $fileName)
    {
        $path_thumbs = 'images/users/';

        if (!File::exists($path_thumbs)) {
            File::makeDirectory($path_thumbs, 0755, true, true);
        }

        $img = Image::make($path);

        $img->fit(70, 70);

        $img->save($path_thumbs . $fileName);
    }
}
