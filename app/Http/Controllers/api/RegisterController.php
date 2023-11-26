<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __invoke(Request $request) {
        $validator = Validator::make($request->all(), [
          'name' => 'required',
          'email' => 'required|email|unique:users',
          'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
          return response()->json($validator->errors(), 422);
        }

        $user = User::create ([
          'name' => $request->input('name'),
          'email' => $request->input('email'),
          'password' => bcrypt($request->input('password'))
        ]);

        if($user) {
          return response()->json ([
            'berhasil' => true,
            'user' => $user,
          ], 201);
        }

        return response()->json([
          'berhasil'=>false,
        ], 409);
    }//
}
