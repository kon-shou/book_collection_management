<?php

namespace App\Repository;

use App\Eloquent\User;

class UserRepository
{
    public function findById(int $userId): ?User
    {
        return User::query()->find($userId);
    }

    public function findByName(string $name): ?User
    {
        return User::query()->where('name', $name)->first();
    }

}
