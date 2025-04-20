<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        try{
            DB::beginTransaction();
            $request['password'] = Hash::make($request['password']);
            $request['remember_token'] = Str::random(10);
            $user = User::create($request->toArray());
            $token = JWTAuth::fromUser($user);
            $response = [
                'token' => $token,
                'user' => $user,
            ];
            DB::commit();
            return sendResponse('User Register successfully',$response,Response::HTTP_OK);
        }catch (\Exception $exception) {
            DB::rollBack();
            return sendError(
                'something went wrong',
                [
                    'error' => $exception->getMessage(),
                    'line' => $exception->getLine(),
                    'file' => $exception->getFile(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

    }
    public function login(LoginRequest $request){
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (auth()->guard('api')->attempt($data)){
            $user = Auth::guard('api')->user();
            $response = [
                'token' => JWTAuth::fromUser($user),
                'user' => $user
            ];
            return sendResponse(
                'Login successfully.',
                $response,
                Response::HTTP_OK
            );
        }else{
            return sendError(
                'Credentials not match.',
                [],
                404
            );
        }

    }
    public function logout(){
        $user = Auth::guard('api')->user();
        auth()->guard('api')->logout();
        return sendResponse('Logout successfully',[],Response::HTTP_OK);
    }
}
