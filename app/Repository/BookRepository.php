<?php

namespace App\Repository;

use App\Eloquent\Book;
use App\Eloquent\Bookshelf;
use App\Eloquent\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class BookRepository
{
    public function find(int $bookId): ?Book
    {
        return Book::query()->find($bookId);
    }

    public function create(string $title, int $totalPage, Bookshelf $bookshelf)
    {
        $book = new Book();
        $book->title = $title;
        $book->bookshelf_id = $bookshelf->id;
        $book->total_page = $totalPage;
        $book->registered_at = Carbon::now();

        $book->save();

        return $book;
    }

    public function findAllBorrowBooksByUser(User $user): Collection
    {
        return Book::query()->where('borrow_user_id', $user->id)->get();
    }

    public function findAllBooksByBookshelf(Bookshelf $bookshelf): Collection
    {
        return Book::query()->where('bookshelf_id', $bookshelf->id)->get();
    }

    public function updateBorrow(Book $book, User $user, bool $isBorrowed)
    {
        $book->is_borrowed = $isBorrowed;
        $book->borrow_user_id = $isBorrowed ? $user->id : null;
        $book->save();
    }
}
