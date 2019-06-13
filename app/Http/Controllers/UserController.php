<?php

namespace App\Http\Controllers;

use App\Eloquent\Book;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userRepository;
    private $bookRepository;

    public function __construct(
        UserRepository $userRepository,
        BookRepository $bookRepository
    ) {
        $this->userRepository = $userRepository;
        $this->bookRepository = $bookRepository;
    }

    public function login(Request $request)
    {
        $userId = $request->get('name');
        if (!$userId) {
            throw new ValidationException('nameは必須です');
        }

        $user = $this->userRepository->findByName($userId);
        if (!$user) {
            abort('ユーザーが見つかりませんでした');
        }

        return $user;
    }

    public function show(int $userId)
    {
        $books = $this->bookRepository->getByUserId($userId);

        return [
            'books' => $books->map(function (Book $book) {
                return [
                    'id' => $book->id,
                    'registered_at' => $book->registered_at,
                    'owner_user_name' => $book->ownerUser->name,
                    'borrow_user_name' => $book->borrowUser->name ?? null,
                    'status' => $book->status
                ];
            })
        ];
    }
}
