<?php

namespace App\Http\Controllers\Landings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingPage_Controller extends Controller
{
    //
    public function index(Request $request){
        // return view('landing');

        $data = [
        ];
        return view('pages.landings.vp_main', $data);

    }

}
