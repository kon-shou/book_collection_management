<?php

namespace App\Http\Controllers;

use App\Eloquent\Book;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Passport\Token;

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
            abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized.');
        }

        $user = auth()->user();
        $user->tokens()->delete();
        $token = $user->createToken('bcm_'. $user->id);
        return [
            'user' => $user,
            'token' => $token->accessToken,
        ];
    }

    public function register(Request $request)
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        if (!$name || !$email || !$password) {
            throw new ValidationException('name, email, passwordは必須です');
        }

        $user = $this->userRepository->register($name, $email, $password);

        return $user;
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized.');
        }

        $user->tokens()->delete();

        return [];
    }

    public function user()
    {
        return ['user' => auth()->user()];
    }
}
