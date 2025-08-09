<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function create(array $data): User
    {
        return $this->user->create($data);
    }

 
    public function findByEmail(string $email): ?User
    {
        return $this->user->where('email', $email)->first();
    }


    public function findById(int $id): ?User
    {
        return $this->user->find($id);
    }
}
