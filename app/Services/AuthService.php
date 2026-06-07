<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
  public function registerUser(array $data)
  {
    $user = User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'phone' => $data['phone'],
      'password' => Hash::make($data['password']),
    ]);
    $user->assignRole('customer');
    $token = $user->createToken('auth_token')->plainTextToken;
    return $token;
  }

  public function loginUser(array $data)
  {
    $user = User::where('email', $data['email'])->first();
    if (!$user || !Hash::check($data['password'], $user->password)) {
      return null;
    }

    if (!$user->is_active) {
      abort(403, 'This account is disabled. Please contact the administration.');
    }

    $user->assignRole('customer');
    $user->tokens()->delete();
    $token = $user->createToken('auth_token')->plainTextToken;
    return $token;
  }

  public function updateProfile(User $user, array $data): User
  {
    $filteredData = collect($data)->only(['name', 'email', 'password'])->filter()->toArray();

    if (isset($filteredData['password'])) {
      $filteredData['password'] = Hash::make($filteredData['password']);
    }

    $user->update($filteredData);

    return $user;
  }
}
