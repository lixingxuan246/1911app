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


    public function getwxtoken(){
        $appid = 'wxfe4e16669b91d830';
        $appsercret = 'b6cde8048ba58f021050069aafa613ea';
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsercret.'';
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);//请求url地址
        curl_setopt($ch,CURLOPT_HEADER,0);//是否返回响应头信息
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//s是否将结果返回
        $response = curl_exec($ch);//执行
        curl_close($ch);//关闭
        echo $response;
    }










    public function getwww(){
        $url = "http://www.1911.com/usr/info";
        $response = file_get_contents($url);
       var_dump($response);
    }



}
