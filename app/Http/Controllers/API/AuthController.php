<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;   
//Request validation class
use App\Http\Requests\RegisterRequest;  

class AuthController extends Controller
{ 

    public function __construct(){
        $this->middleware('auth:api', ['only' => ['logout']]);
    }

    public function login(){  
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user();  
            $success['token'] =  $user->createToken('vueToken')-> accessToken; 
            $data = [
                'token' => $success['token'],
                'user'=> $user
            ];
            return response()->json($data, 200); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    public function logout(){  
        $accessToken = auth()->user()->token(); 

        $refreshToken = DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke(); 

        return response()->json(['status' => 200, $accessToken, 'message' => 'Successfully logged out']);
        
    }
    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 

    public function register(RegisterRequest $request) 
    {  
        $validator = \Validator::make($request->all(), $request->rules());
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all(); 
        $input['password'] = Hash::make($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['user'] =  $user;
        return response()->json(['success'=>$success], 200); 
    }
}
