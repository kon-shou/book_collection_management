<?php

namespace App\Http\Controllers;

use App\Eloquent\Book;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(Request $request)
    {
        $creds = $request->only('email', 'password');
        if (!auth()->attempt($creds)) {
            return response()->json(['Unauthorized.'], Response::HTTP_UNAUTHORIZED);
        }

        $user = auth()->user();
        $user->tokens()->delete();
        $token = $user->createToken('SPA');
        return [
            'user' => $user,
            'token' => $token->accessToken,
        ];
    }

    public function user()
    {
        return ['user' => auth()->user()];
    }
}
