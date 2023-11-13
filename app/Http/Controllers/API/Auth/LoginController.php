<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordEmail;
use App\Mail\VerifyEmail;
use App\Models\Mapping;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function authenticate(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!auth()->attempt($request->only('email', 'password'))){
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ],
            'user' => $user
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //first check if user creation was successful
        if (!$user) {
            return response()->json([
                'message' => 'Account creation failed',
            ], 500);
        }

        // //generate random code
        // $code = rand(100000, 999999);

        // //save code to database
        // $verificationCode = new VerificationCode();
        // $verificationCode->email = $user->email;
        // $verificationCode->code = $code;
        // $verificationCode->save();

        // if(!$verificationCode){
        //     return response()->json([
        //         'message' => 'Account creation failed',
        //     ], 500);
        // }
        //send email to the user
        // Mail::to($user->email)->send(new VerifyEmail($code, $user->name));

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    public function logout(Request $request){
        $logout = $request->user()->currentAccessToken()->delete();
        if(!$logout){
            return response()->json([
                'message' => 'Logout failed',
                'status' => 'error'
            ], 500);
        }

        return response()->json([
            'message' => 'Logged out',
            'status' => 'success'
        ], 200);
    }

        //verify email using the code
        public function verifyEmail(Request $request)
        {
            $request->validate([
                'email' => ['required', 'string', 'email'],
                'code' => ['required', 'string'],
            ]);

            $verificationCode = VerificationCode::where('email', $request->email)->where('code', (int)$request->code)->first();

            if (!$verificationCode) {
                return response()->json([
                    'message' => 'Invalid verification code',
                ], 401);

                }

            //update user email_verified_at column
            $user = User::where('email', $request->email)->first();
            $user->email_verified_at = now();

            if (!$user->save()) {
                return response()->json([
                    'message' => 'Verification failed',
                ], 500);
            }

            //delete verification code from database
            $verificationCode->delete();

            return response()->json([
                'message' => 'Email verified successfully',
            ], 200);
        }

        public function resendVerificationCode(Request $request)
        {
            $request->validate([
                'email' => ['required', 'email'],
            ]);

            $user = VerificationCode::where('email', $request->email)->first();

            //regenerate code and update database
            $code = rand(100000, 999999);

            $user->code = $code;

            if (!$user->save()) {
                return response()->json([
                    'message' => 'Failed to resend verification code',
                ], 500);
            }

            //temporarily auth the user to get the name
            $user = User::where('email', $request->email)->first();
            auth()->login($user);

            $name = auth()->user()->name;
            Mail::to($user->email)->send(new VerifyEmail($code, $name));
            auth()->logout();

            return response()->json([
                'message' => 'Verification code resent successfully',
            ], 200);
        }

        public function resetPasswordCode(Request $request)
        {
            $request->validate([
                'email' => ['required', 'email'],
            ]);

            $user = User::where('email', $request->email)->first();

            //check if user exists
            if (!$user) {
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            }

            //check if the user already has a verification code and delete it
            $verificationCode = VerificationCode::where('email', $request->email)->first();

            if ($verificationCode) {
                $verificationCode->delete();
            }

            //generate code and update verification code table
            $code = rand(100000, 999999);

            $verificationCode = new VerificationCode();

            $verificationCode->email = $request->email;

            $verificationCode->code = $code;

            if (!$verificationCode->save()) {
                return response()->json([
                    'message' => 'Failed to send reset code',
                ], 500);
            }

            //send email to the user
            $user = User::where('email', $request->email)->first();
            auth()->login($user);

            $name = auth()->user()->name;
            Mail::to($user->email)->send(new ResetPasswordEmail($code, $name));
            auth()->logout();

            return response()->json([
                'message' => 'Reset code sent successfully',
            ], 200);
        }

        public function resetPassword(Request $request)
        {
            $request->validate([
                'email' => ['required', 'email'],
                'code' => ['required', 'string'],
                'password' => ['required']]
            );

            //check if user exists in the verification code table
            $verificationCode = VerificationCode::where('email', $request->email)->where('code', (int)$request->code)->first();

            if (!$verificationCode) {
                return response()->json([
                    'message' => 'Invalid verification code',
                ], 401);
            }

            //update user password

            $user = User::where('email', $request->email)->first();

            $user->password = Hash::make($request->password);

            if (!$user->save()) {
                return response()->json([
                    'message' => 'Failed to reset password',
                ], 500);
            }

            //delete verification code from database

            $verificationCode->delete();

            return response()->json([
                'message' => 'Password reset successfully',
            ], 200);

        }

            //verify email using the code
            public function verifyPasswordResetEmail(Request $request)
            {
                $request->validate([
                    'email' => ['required', 'string', 'email'],
                    'code' => ['required', 'string'],
                ]);

                $verificationCode = VerificationCode::where('email', $request->email)->where('code', (int)$request->code)->first();

                if (!$verificationCode) {
                    return response()->json([
                        'message' => 'Invalid verification code',
                    ], 401);

                    }

                return response()->json([
                    'message' => 'Code verified successfully',
                ], 200);
            }

            public function profile(Request $request)
            {
                //get the logged in user profile
                $user = User::where('id', auth()->user()->id)->first();
                //return the user profile
                return response()->json([
                    'message' => 'User profile retrieved successfully',
                    'user' => $user,
                ], 200);
            }

            public function deleteUserAccount()
            {
                $userId = auth()->user()->id;

                // Delete related records in the mappings table
                Mapping::where('user_id', $userId)->delete();

                // Now, delete the user
                $user = User::find($userId);

                if (!$user->delete()) {
                    return response()->json([
                        'message' => 'Failed to delete user account',
                    ], 500);
                }

                return response()->json([
                    'message' => 'User account deleted successfully',
                ], 200);
            }

}
