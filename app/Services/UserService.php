<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function getAll() {
        return User::oldest()->paginate(10);
    }

    public function createUser(array $data)
    {
        return User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
        ]);
    }

    public function getOne($id) {
        return User::find($id);
    }
    
}
