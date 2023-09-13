<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    
// Register a user
public function register (Request $request){

    $data = $request->validate([
            'email' => 'required|email:rfc,dns|unique:users,email',
            'name' => 'required|unique:users,name',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
    ]);
    $data['password'] = Hash::make($data['password']);
    $user = User::create($data);
    $token = $user->createToken(User::USER_TOKEN);
    return $this->success([
        'user'=>$user,
        'token'=>$token->plainTextToken,
    ],'User has been register Successfully');

}
// Login User
public function login(Request $request){
    $isValid = $this->isValidCredential($request);
    if(!$isValid['success']){
        return $this->error($isValid['message'],422);
    }
    $user = $isValid['user'];
    $token = $user->createToken(User::USER_TOKEN);
    return $this->success(
        [
            'user'=>$user,
            'token'=>$token->plainTextToken
        ],'Login Successfully ');
}
private function isValidCredential(Request $request){

    $data = $request->validate([
        'email'=>'required',
        'password'=>'required'
    ]);
    $user = User::where('email', $data['email'])->first();
    if($user ===null){
        return [
            'success'=>false,
            'message'=>'Invalid Credential',
        ];
    }
    if (Hash::check($data['password'],$user->password)){
        return [
            'success'=>true,
            'user'=>$user
        ];

    }
    return [
        'success'=>false,
        'message'=>'password is not matched'
    ];
}
// Logout User

public function logout(Request $request){


 return $request->user()->currentAccessToken()->delete();
//        $request->user()
//            ->tokens
//            ->each(function ($token, $key) {
//                $this->revokeAccessAndRefreshTokens($token->id);
//            });
//
//        return response()->json('Logged out successfully', 200);

}

// Login With Token
public function loginWithToken(){
    return $this->success(auth()->user(),'Login Successfully!');
}

}
