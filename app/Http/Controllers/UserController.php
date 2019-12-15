<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Cookie;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function register(Request $request)
    {
        $request['password'] = bcrypt($request->password);  //해시 처리

        if(DB::table('users')->where('user_id', $request->user_id)->first())        //데이터베이스에 있는 정보일 때 error 출력해주는 것
        {
            return response()->json(['error'=>'1']);
        }else if(DB::table('users')->where('email', $request->email)->first())
        {
            return response()->json(['error'=>'2']);
        }

        $user = new User();
        $user->user_id = $request->user_id;
        $user->sex = $request->sex;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->admin = 'no';

        $user->save();
        
        // User::create($request->all());

        return response()->json(['msg'=>"Success"]);
    }

    public function login(Request $request)
    {
        $request->validate([    // 유효성 검사 use_id 가 string형인지
            'user_id' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = request(['user_id', 'password']);
        if(Auth::attempt($credentials)){    // 키/값 배열 받음, DB테이블에서 사용자 찾는데 사용, 비교 전 자동 해시 처리되기 때문에 password 지정 값을 해시처리하면 안됨 / True/Flase 반환
            $user = Auth::user();
            $token = $user->createToken('Personal Access Token')->accessToken;
            //createToken : User 모델 인스턴스 메소드를 사용해 지정된 사용자에 대한 토큰 발행 / 토큰 이름을 첫 번째 인수, 선택적 범위 배열을 두 번째 인수
            $cookie = $this->getCookieDetails($token);
            $session = new Session();           //여기서 세션 저장
            $session->set('user',$user->user_id);
            debug($cookie);
            return response()->json([
                'logged_in_user' =>$user,
                'token' => $token,
            ], 200)->cookie($cookie['key'], $cookie['value'],$cookie['minutes'],$cookie['path'],$cookie['domain'],
            $cookie['secure'],$cookie['httponly'],$cookie['samesite']);
        }else{  //데이터베이스에 해당 값들이 없을 때
            return response()->json(['error'=>'invalid-credentials'],422);
        }
    }

    private function getCookieDetails($token)   //토큰의 정보 지정해주기 위해 만든 메서드
    {
        return [
            'key' => '_token',
            'value' => $token,
            'minutes' => 1440,
            'path' => null,
            'domain' => null,
            'secure' => null,
            'httponly' => false,
            'samesite' => true,
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();    //데이터베이스에서 토큰을 삭제하기 위함
        $cookie = Cookie::forget('_token'); //쿠키 삭제
        $session = new Session();   //세션 제거
        $session->remove('user');
        return response()->json([
            'msg' => 'successful_logout'
        ])->withCookie($cookie);
    }
}
