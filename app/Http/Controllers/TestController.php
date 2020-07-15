<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function index(){
        echo '123';
        $appid = '';
        $appsercret = '';
        $url = '';
        file_get_contents($url);
    }
}
