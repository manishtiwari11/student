<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator= Validator::make($request->all(), [
            'name'=> 'required|string|max:150',
            'course'=> 'required|string|max:150',
            'email'=> 'required|email|max:150|unique:students,email',
            'password'=> 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'message'=> $validator->messages()
            ], 422);
        }
        else{
            $user= Students::create([
                'name'=> $request->name,
                'course'=> $request->course,
                'email'=> $request->email,
                'password'=>md5($request->password),
            ]);

            $token= $user->createToken('loginToken')->plainTextToken;
            if($user){
                return response()->json([
                    'status'=>'Success',
                    'student'=>$user->name,
                    'message'=>'Student Registered Successfully',
                    'token'=>$token
                ], 201);
            }else{
                return response()->json([
                    'status'=>'Failure',
                    'message'=> "Something went wrong"
                ], 404);
            }
        }
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response(['message'=> "Logged out successfully"]);

    }

    public function login(Request  $request){
        $validator= Validator::make($request->all(), [
            'email'=> 'required|email|max:150',
            'password'=> 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'message'=> $validator->messages()
            ], 422);
        }
        else{
            $user= Students::where('email', $request->email)->where('password', md5($request->password))->first();
            if($user){

                $token= $user->createToken('loginToken')->plainTextToken;
                $response=[
                    'user'=>$user,
                    'token'=>$token,
                    'message'=> 'Logged in successfully'
                ];
                return response($response);
            }
            else{
                return response(['message'=> "Incorrect login details"]);
            }

        }
    }
}
