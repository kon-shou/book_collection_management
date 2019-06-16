<?php

namespace App\Http\Controllers;

use App\Eloquent\Book;
use App\Repository\BookRepository;
use App\Repository\BookshelfRepository;
use App\Repository\UserRepository;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class BookController extends Controller
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

    public function create(Request $request)
    {
        $title = $request->get('title');
        $totalPage = $request->get('total_page');
        $bookshelfId = $request->get('bookshelf_id');
        if (!$title|| !$totalPage || !$bookshelfId) {
            throw new ValidationException('titleとtotal_pageとuser_idとbookshelf_idは必須です');
        }

        $bookshelf = $this->bookshelfRepository->find($bookshelfId);
        if (!$bookshelf) {
            abort('404', 'Bookshelf not Found');
        }

        $book = $this->bookRepository->create($title, $totalPage, $bookshelf);

        return $book;
    }

    public function startBorrow(Request $request, int $bookId)
    {
        $userId = $request->get('user_id');
        if (!$userId) {
            throw new ValidationException('user_idは必須です');
        }

        $user = $this->userRepository->find($userId);
        if (!$user) {
            abort('404', 'User not Found');
        }

        $book = $this->bookRepository->find($bookId);
        if (!$book) {
            abort('404', 'Book not Found');
        }

        if ($book->isBorrowed()) {
            new ValidationException('既に貸出中です');
        }

        $this->bookRepository->updateBorrow($book, $user, true);

        return [];
    }

    public function endBorrow(Request $request, int $bookId)
    {
        $userId = $request->get('user_id');
        if (!$userId) {
            throw new ValidationException('user_idは必須です');
        }

        $user = $this->userRepository->find($userId);
        if (!$user) {
            abort('404', 'User not Found');
        }

        $book = $this->bookRepository->find($bookId);
        if (!$book) {
            abort('404', 'Book not Found');
        }

        if ($book->isBorrowed()) {
            new ValidationException('既に貸出中です');
        }

        $this->bookRepository->updateBorrow($book, $user, false);

        return [];
    }
}
