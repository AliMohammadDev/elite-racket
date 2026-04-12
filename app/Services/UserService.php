<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
  public function findAll()
  {
    return User::with(['roles', 'permissions'])->latest()->get();
  }

  public function createUser(array $data)
  {
    if (isset($data['password'])) {
      $data['password'] = Hash::make($data['password']);
    }
    return User::create($data);
  }

  public function show(User $user)
  {
    return $user->load(['roles', 'permissions']);
  }

  public function updateUser(User $user, array $data)
  {
    $filteredData = collect($data)
      ->only(['name', 'email', 'password', 'is_active'])
      ->filter(fn($value) => $value !== null && $value !== '')
      ->toArray();
    if (isset($filteredData['password'])) {
      $filteredData['password'] = Hash::make($filteredData['password']);
    }
    $user->update($filteredData);
    return $user;
  }

  public function deleteUser(User $user)
  {
    return $user->delete();
  }
}