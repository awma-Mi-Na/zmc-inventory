<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Validator;

class TokenController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required|exists:users,username',
                'password' => 'required'
            ]
        );
        if ($validator->fails()) {
            return response(
                [
                    'message' => array_values($validator->getMessageBag()->getMessages())
                ],
                422
            );
        }

        try {
            $user = User::where('username', $request->username)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response(
                [
                    'message' => ['The user does not exist']
                ],
                404
            );
        }

        if (!Hash::check($request->password, $user->password))
            return response(['message' => ['Password is incorrect.']], 422);

        return response(
            [
                'message' => 'Login successful',
                'token' => $user->createToken('auth-token')->plainTextToken
            ]
        );
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response(['message' => 'Logout successful']);
        } catch (\Exception $e) {
            return response(
                [
                    'message' => $e->getMessage()
                ],
                400
            );
        }
    }
}
