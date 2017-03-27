<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Ad;

class AdController extends Controller
{

    public function getIndex() {
        $ad = Ad::select(['id','redirect_url','image_url'])->get();
        return response()->json(['ads' => $ad], 200);
    }

    public function getRandom() {
        $ad = Ad::select(['id','redirect_url','image_url'])
            ->orderByRaw('RAND()')
            ->first();

        return response()->json(['ad' => $ad], 200);
    }

    public function getShow($id) {
        $ad = Ad::select(['id','redirect_url','image_url'])
            ->where('id', $id)
            ->first();
        if(empty($ad)) {
            return response()->json('',204);
        }
        return  response()->json(['ad' => $ad], 200);

    }

}
