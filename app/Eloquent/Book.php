<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/** @property $id */
/** @property $title */
/** @property $bookshelf_id */
/** @property $borrow_user_id */
/** @property $is_borrowed */
/** @property $total_page */
/** @property $read_page */
class Book extends Model
{
    use Notifiable;

    public function borrowUser()
    {
        return $this->belongsTo(User::class, 'borrow_user_id');
    }

    public function isBorrowed()
    {
        return $this->is_borrowed;
    }
}
