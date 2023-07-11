<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\Auth;

class userController extends Controller
{
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $data = new User();
        $data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->password = $request->input('password');
        $data->role = "2";
        $data->save();

        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else{
            return ApiFormatter::createApi(400,'Failed');
        }
    }

    public function login(Request $request)
    {
            $userLogin = User::where('name', $request->name)->first();

                if($userLogin){

                if(password_verify($request->password, $userLogin->password)) {
                    $token = $userLogin->createToken('api-token')->plainTextToken;
                        return response()->json([

                            'Code' => 200,
                            'Token' => $token,
                            'Message' => 'Welcome '.$userLogin->name,
                            'data' => $userLogin
                        ]);
                    }

                    return $this->error('Username atau Password Salah');
                }
        
                return $this->error('Username Tidak ditemukan');
                }

                public function error($message) {
                    return response()->json([
                        'Code' => 500,
                        'Message' => $message
                    ]);
                 }
    

    public function logout()
    {
        // $request->user()->tokens()->delete();
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }
}
