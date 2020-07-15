<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function index(){
//        echo '123';
        $appid = 'wxfe4e16669b91d830';
        $appsercret = 'b6cde8048ba58f021050069aafa613ea';
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsercret.'';
        $a=file_get_contents($url);
        echo $a;
    }
}
