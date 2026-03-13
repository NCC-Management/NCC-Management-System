<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'] ?? trim(($input['first_name'] ?? '') . ' ' . ($input['last_name'] ?? '')),
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => 'cadet',
        ]);

        \App\Models\Cadet::create([
            'user_id'           => $user->id,
            'enrollment_no'     => 'NCC' . random_int(10000, 99999),
            'status'            => 'pending',
            'profile_completed' => false,
        ]);

        return $user;
    }
}
