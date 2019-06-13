<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Book extends Model
{
    use Notifiable, HasApiTokens;

    public function ownerUser()
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    public function borrowUser()
    {
        return $this->belongsTo(User::class, 'borrow_user_id');
    }
}
