<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class DestinationController extends Controller
{

    public function getIndex() {
        $destinations = \App\Destination::all(['id','name_'.\App::getLocale().' as name','latitude','longitude']);
        return response()->json(['destinations' => $destinations], 200);
    }

}
