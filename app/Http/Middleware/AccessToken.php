<?php

namespace App\Http\Middleware;

use App\Models\TokenController;
use Closure;
use Illuminate\Support\Facades\Redis;

class AccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $token = $request->get('tokens');

        if(empty($token)){
            $data =  [
              'error' => '00001',
              'msg' => '用户未授权'
            ];
            echo json_encode($data);
        }
        $models = new TokenController();

        $tokeninfo = $models->where('token','=',$token)->first();

//        echo $tokeninfo['token'];
        if($tokeninfo['token'] != $token){
            $data =  [
                'error' => '00001',
                'msg' => '授权失败'
            ];
            echo json_encode($data);
        }


        $b = $request->getRequestUrI();
        echo $b;
//        $c = $request->getMethod();
        $c = substr($b,0,7);
//        echo $c;
        $user_id = $request->get('user_id');
        $date = date('Ymd');
        echo $date;
        $key = $c.'..'.$date;
        Redis::zincrby($key,'1','count');



        //获取每个用户访问的接口统计
        $key2 = "h:view_count:".$user_id;
        $key3 = '1';
        $key4 = Redis::incr($key3,1);
        Redis::hset($key2,$key4,$b);


        return $next($request);
    }
}
