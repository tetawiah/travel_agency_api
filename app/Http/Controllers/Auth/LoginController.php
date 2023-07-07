<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Symfony\Component\Mailer\Transport\Smtp\Auth\LoginAuthenticator;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $user = User::where('email',$request->validated('email'))->first();
       if(! $user || ! Hash::check($request->validated('password'),$user->password)){
           return response()->json(["messsage" => "Unauthenticated"],Response::HTTP_UNAUTHORIZED);
       };
       return response()->json(
           ["data" => ["token" => $user->createToken('token')->plainTextToken,
       "message" => "Success",]],
        Response::HTTP_OK);
    }
}
