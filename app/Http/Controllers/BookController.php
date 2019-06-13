<?php

namespace App\Http\Controllers;

use App\Eloquent\Book;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class BookController extends Controller
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

    public function create(Request $request)
    {
        $title = $request->get('title');
        $userId = $request->get('user_id');

        if (!$title || !$userId) {
            throw new ValidationException('titleとuser_idは必須です');
        }

        $user = $this->userRepository->findById($userId);
        if (!$user) {
            throw new ValidationException('Userが見つかりませんでした');
        }

        $book = $this->bookRepository->create($title, $user);

        return $book;
    }
}
