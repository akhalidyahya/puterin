<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class UserController extends Controller
{
    public function getAll(){
        $user = User::all();
        return response()->json([
                $user,
            ],200);
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'nohp' => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()
            ],401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $success['status'] = 'success';
        $success['message'] = "Berhasil mendaftar!";
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['data'] =  $input;

        return response()->json($success, 200); 
    }

    public function login(){
        if(Auth::attempt(['email'=>request('email'),'password'=>request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return response()->json([
                'status' => 'success',
                'message' => 'Your login attempt is success!',
                'data' => $user,
                'token' => $success['token']
            ],200);
        }
        else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Email atau password tidak tepat',
            ],401);
        }
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out'
        ],200);
    }

    public function details() 
    { 
        $user = Auth::user();
        $data = User::find($user->id);
        return response()->json(['data' => $data], 200); 
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        $data = User::find($user->id);
        $data->name = $request->nama;
        $data->email = $request->email;
        $data->nohp = $request->nohp;
        $data->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Data updated succesfully',
        ],200);
    }

}
