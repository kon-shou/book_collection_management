<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/** @property $id */
/** @property $owner_type */
/** @property $owner_id */
class Bookshelf extends Model
{
    use Notifiable;

    public function ownerUser()
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    public function borrowUser()
    {
        return $this->belongsTo(User::class, 'borrow_user_id');
    }
}
