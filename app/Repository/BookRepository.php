<?php

namespace App\Repository;

use App\Eloquent\Book;
use App\Eloquent\User;
use Carbon\Carbon;

class BookRepository
{
    public function getByUserId(int $userId)
    {
        return Book::query()->where('owner_user_id', $userId)->get();
    }

    public function create(string $title, User $user)
    {
        $book = new Book();
        $book->title = $title;
        $book->owner_user_id = $user->id;
        $book->registered_at = Carbon::now();

        $book->save();

        return $book;
    }

}
