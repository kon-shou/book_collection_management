<?php

namespace App\Http\Controllers;

use App\Eloquent\Book;
use App\Repository\BookRepository;
use App\Repository\BookshelfRepository;
use App\Repository\UserRepository;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class BookshelfController extends Controller
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

    public function createPersonal(Request $request)
    {
        $userId = $request->get('user_id');
        if (!$userId) {
            throw new ValidationException('user_idは必須です');
        }

        $user = $this->userRepository->find($userId);
        if (!$user) {
            abort('404', 'User not Found');
        }

        $this->bookshelfRepository->createPersonal($user);

        return [];
     }

    public function indexBooks(int $bookshelfId)
    {
        $bookshelf = $this->bookshelfRepository->find($bookshelfId);
        if (!$bookshelf) {
            abort('404', 'Bookshelf not Found');
        }

        $books = $this->bookRepository->findAllBooksByBookshelf($bookshelf);

        return $books;
    }
}
