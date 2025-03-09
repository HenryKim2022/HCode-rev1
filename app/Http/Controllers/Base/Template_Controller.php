<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Template_Controller extends Controller
{
    function template(){
        // return redirect('/public/template/index.html');
        return redirect('/template/index.html');
    }
}
