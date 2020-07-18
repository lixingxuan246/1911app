<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\TokenController;

use Illuminate\Support\Str;
class RegController extends Controller
{
    //
    public function kkk(){
        phpinfo();
    }
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
        $usermodel->password = password_hash($password,PASSWORD_DEFAULT);

        $res = $usermodel->save();
        if($res){
            $data = [
                'error' => '00000',
                'msg' => '注册用户成功'
            ];
            return $data;
        }

    }
//str::random  password_varify

    //登陆
    public function loginpost(){
        $name = request()->post('name');
        $password = request()->post('password');
        $usermodel = new UserModel();
        $data = $usermodel->where('name','=',$name)->first();

            if(password_verify($password,$data['password'])){

                $token = Str::random(32);
                $gg = 7200;

                $tokenmodel = new TokenController();
                $tokenmodel->token = $token;
                $tokenmodel->token_time = time() + $gg;
                $tokenmodel->uid = $data->uid;
                $tokenmodel->save();

                $data = [
                    'error' => '00000',
                    'msg' => '登陆成功',
                    'token' => $token,
                ];
                return $data;



            }else{
                $data = [
                    'error' => '00001',
                    'msg' => '密码错误',
                ];
                return $data;
            }


    }


    /*
     * 个人中心
     * */
    public function center(){
        //验证token是否存在
        $token = request()->get('token');

        if(empty($token)){
            $data = [
                'error' => '00001',
                'msg' => '你还未授权',
            ];
            return $data;
        }

        $res = TokenController::where(['token'=>$token])->first();

        if($res){

            $userinfo = UserModel::where(['uid'=>$res->uid])->first();

            $data = [
                'error' => '00000',
                'msg' => '个人中心',
                'datainfo' => $userinfo,
            ];
            return $data;

        }

    }


}
