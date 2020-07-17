<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
class RegController extends Controller
{
    //
    public function regpost(){
//        echo '123';die;
        $name = request()->post('name');
        $password = request()->post('password');
        $passwords = request()->post('passwords');

        if(empty($name)){
            $data = [
                'error' => '00001',
                'msg' => '用户名不能为空'
            ];
            return $data;
        }
        if(empty($password)){
            $data = [
                'error' => '00003',
                'msg' => '密码不能为空'
            ];
            return $data;
        }

        if($password != $passwords){
            $data = [
                'error' => '00002',
                'msg' => '密码必须一致'
            ];
            return $data;
        }
        $usermodel = new UserModel();
        $usermodel->name = $name;
        $usermodel->password = $password;

        $res = $usermodel->save();
        if($res){
            $data = [
                'error' => '00000',
                'msg' => '注册用户成功'
            ];
            return $data;
        }

    }


    //登陆
    public function loginpost(){
        $name = request()->post('name');
        $password = request()->post('$password');
        $usermodel = new UserModel();
        $data = $usermodel->where('name','=',$name)->first();


    }


}
