<?php

namespace App\Http\Controllers;

use App\Eloquent\Book;
use App\Repository\BookRepository;
use App\Repository\BookshelfRepository;
use App\Repository\UserRepository;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private $userRepository;
    private $bookRepository;
    private $bookshelfRepository;

    public function __construct(
        UserRepository $userRepository,
        BookRepository $bookRepository,
        BookshelfRepository $bookshelfRepository
    ) {
        $this->userRepository = $userRepository;
        $this->bookRepository = $bookRepository;
        $this->bookshelfRepository = $bookshelfRepository;
    }

    public function show(int $userId)
    {
        $user = $this->userRepository->find($userId);
        if (!$user) {
            abort('404', 'User not Found');
        }

        return $user;
    }

    public function indexBorrowBooks(int $userId)
    {
        $user = $this->userRepository->find($userId);
        if (!$user) {
            abort('404', 'User not Found');
        }

        $books = $this->bookRepository->findAllBorrowBooksByUser($user);

        return $books;
    }

    public function showPersonalBookshelf(int $userId)
    {
        $user = $this->userRepository->find($userId);
        if (!$user) {
            abort('404', 'User not Found');
        }

        $bookshelf = $this->bookshelfRepository->findPersonalBookshelfByUser($user);
        if (!$bookshelf) {
            abort('404', 'Personal Bookshelf not Found');
        }

        return $bookshelf;

    }
}
