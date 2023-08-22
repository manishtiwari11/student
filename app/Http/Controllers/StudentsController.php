<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentsController extends Controller
{
    public function index(){
        $user= Students::all();
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

    public function view($id){
        $user= Students::find($id);
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


    public function edit($id){
        $user= Students::find($id);
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


    function update(Request $request, int $id){
        $validator= Validator::make($request->all(), [
            'name'=> 'required|string|max:150',
            'course'=> 'required|string|max:50',
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
            $student= Students::find($id);
            
            if($student){
                $student->update([
                    'name'=> $request->name,
                    'course'=> $request->course,
                    'email'=> $request->email,
                    'password'=> md5($request->password),
                ]);

                return response()->json([
                    'status'=>'Success',
                    'message'=>'Student Updated Successfully'
                ], 200);
            }else{
                return response()->json([
                    'status'=>'Fail',
                    'message'=> "Student not found"
                ], 404);
            }
        }
    }

    public function delete(int $id){
        $student= Students::find($id);
        if($student){
            $student->delete();
            return response()->json([
                'status'=>'Success',
                'message'=>"Student Deleted Successfully"
            ], 200);
        }
        else{
            return response()->json([
                'status'=>'fail',
                'message'=> 'Student not found'
            ], 404);
        }
    }

}
