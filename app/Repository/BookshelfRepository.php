<?php

namespace App\Repository;

use App\Eloquent\Book;
use App\Eloquent\Bookshelf;
use App\Eloquent\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class BookshelfRepository
{
    public function find(int $bookshelfId): ?Bookshelf
    {
        return Bookshelf::query()->find($bookshelfId);
    }

    public function createPersonal(User $user)
    {
        $bookshelf = new Bookshelf();
        $bookshelf->owner_id = $user->id;
        $bookshelf->owner_type = User::class;

        $bookshelf->save();

        return $bookshelf;
    }

    public function findPersonalBookshelfByUser(User $user): ?Bookshelf
    {
        return Bookshelf::query()
            ->where('owner_type', User::class)
            ->where('owner_id', $user->id)
            ->first();
    }
}
