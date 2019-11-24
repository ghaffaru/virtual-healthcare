<?php

namespace App\Http\Controllers;

use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\PasswordReset;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
class PasswordResetController extends Controller
{
    //
    public function create(Request $request) 
    {
        $request->validate([
            'email' => 'required|string|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => "We can't find a user with that email address"
            ], 404);
        }
        $passwordReset = PasswordReset::updateOrCreate([
            'email' => $user->email,
            'token' => str_random(60)
        ]);

        if ($user && $passwordReset) {
            $user->notify(
                new PasswordResetRequest($passwordReset->token)
            );
        }
        
        return response()->json([
            'message' => 'We have emailed your password reset link'
        ]);
    }

    public function find($token) 
    {
        $passwordReset = PasswordReset::where('token',$token)->first();

        if (!$passwordReset) {
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        }

        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'message' => 'This password reset token is invalid'
            ], 404);
        }

        return response()->json($passwordReset);
    }

    public function reset(Request $request) 
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'token' => 'required|string'
         ]);

         $passwordReset = PasswordReset::where([
             ['token', $request->token],
             ['email', $request->email]
         ])->first();

         if (!$passwordReset) {
             return response()->json([
                 'message' => 'This password reset token is invalid'
             ], 404);
         }

         $user = User::where('email',$passwordReset->email)->first();

         if (!$user) {
             return response()->json([
                 'message' => "We cant find a user with that email address"
             ], 404);
         }

         $user->password = Hash::make($request->password);

         $user->notify(new PasswordResetSuccess($passwordReset));

         return response()->json($user);
    }
}
