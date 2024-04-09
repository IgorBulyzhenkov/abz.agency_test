<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\Positions;

class PositionController extends Controller
{
    public function index(){

        $positions = Positions::all();

        if(empty($positions)){
            return response([
                'status'    => false,
                'message'   => 'Positions not found'
            ], 404);
        }

        $arrPositions   = [];

        foreach ($positions as $position) {
            $arrPositions[] = [
                'id'            => $position->id,
                'name'          => $position->name,
            ];
        }

        return response([
            'status' => true,
            'positions' => $arrPositions
        ],200);
    }
}
