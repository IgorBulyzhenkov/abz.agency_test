<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Back\Positions;

class UsersController extends Controller
{
    public function index($id = null)
    {
        if (!is_null($id)) {
            return view('users.oneUser');
        }

        $position = Positions::all();

        return view('users.index', [
            'position' => $position,
        ]);
    }
}
