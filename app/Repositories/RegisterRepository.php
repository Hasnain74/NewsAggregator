<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class RegisterRepository
 * @package App\Repositories
 */
class RegisterRepository
{
    /**
     * Create a new user.
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
