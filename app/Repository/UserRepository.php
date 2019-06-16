<?php

namespace App\Repository;

use App\Eloquent\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function find(int $userId): ?User
    {
        return User::query()->find($userId);
    }

    public function findByName(string $name): ?User
    {
        return User::query()->where('name', $name)->first();
    }

    public function register(string $name, string $email, string $password): User
    {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);

        $user->save();

        return $user;
    }

}
