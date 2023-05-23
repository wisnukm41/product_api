<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors(), 403);
        }

        $input = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ];

        $user = User::create($input);

        $success = [
            'name' => $user->name,
            'email' => $user->email,
            'token' => $user->createToken('LoginToken')->plainTextToken,
        ];

        return $this->sendResponse($success, 'User registered successfully', 201);
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->password])){

            $user = Auth::user();

            $success = [
                'name' => $user->name,
                'token' => $user->createToken('LoginToken')->plainTextToken,
            ];

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorized', ['error' => 'Unathorized']);
        }
    }
}
