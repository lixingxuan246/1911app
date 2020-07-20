<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\TokenController;
use Illuminate\Support\Facades\Redis;
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



        $sismember = Redis::sismember('xuan',$token);
        if($sismember == 1){
            $data = [
                'error' => '00003',
                'msg' => '你现在正在黑名单',
            ];
            return $data;
        }
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



            $time = Redis::get('timein');
            if($time){
                $count = Redis::incr('count');
                Redis::expire('count',20);

                if($count>4){

                    $sets = Redis::sadd('xuan',$token);
                    Redis::expire('xuan',40);
                    $data = [
                        'error' => '00001',
                        'msg' => '你的访问次数太频繁了',
                    ];
                    return $data;






                }else{
                    $data = [
                        'error' => '00000',
                        'msg' => '个人中心',
                        'datainfo' => $userinfo,
                        'time'=>$time
                    ];
                    return $data;
                }
            }else{
                $timein =  Redis::set('timein',time());
                Redis::expire('timein',20);

                $data = [
                    'error' => '00000',
                    'msg' => '个人中心...',
                    'datainfo' => $userinfo,
                    'time'=>$time
                ];
                return $data;
            }





        }

    }



    public function kucun(){
        $redis  = Redis::lpush(1,2,3,4,5,4,3,2,1);


    }

    public function qiandao(){
        //签到
        $user_id = request()->get('user_id');
        $key2 = $user_id.'--qiandao';
        $score = date('Ymd');
        $zcard = Redis::zcard($key2);
        if($zcard>0){
            $data = [
                'error' => '00003',
                'msg' => '请改天在签到',
            ];
            return $data;
        }else{
            $id = Redis::zadd($key2,$score,$user_id);
        }
    }


}
