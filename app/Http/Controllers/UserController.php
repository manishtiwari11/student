<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function view(){
        $user= User::all();
        if($user->count()>0){
            return response()->json([
                'status'=>'success',
                'student'=>$user
            ], 200);
        }
        else{
            return response()->json([
                'status'=>'failure',
                'student'=>'No Record found'
            ], 404);
        }
    }

    public function edit($id){
        $user= User::find($id);
        if($user){
            return response()->json([
                'status'=>'success',
                'student'=>$user
            ], 200);
        }
        else{
            return response()->json([
                'status'=>'failure',
                'student'=>'No Record found'
            ], 404);
        }
    }

    public function register(Request $request){
        $validator= Validator::make($request->all(), [
            'name'=> 'required|string|max:150',
            'branch'=> 'required|string|max:50',
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
            $user= User::create([
                'name'=> $request->name,
                'course'=> $request->course,
                'email'=> $request->email,
                'password'=>bcrypt($request->password),
            ]);
            if($user){
                return response()->json([
                    'status'=>'Success',
                    'student'=>$user->name,
                    'message'=>'Student Registered Successfully'
                ], 201);
            }else{
                return response()->json([
                    'status'=>'Failure',
                    'message'=> "Something went wrong"
                ], 404);
            }
        }
    }
}
