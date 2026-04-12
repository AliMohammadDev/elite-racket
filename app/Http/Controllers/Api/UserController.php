<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateUserRequest;
use App\Http\Requests\Auth\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
  public function __construct(
    private UserService $userService
  ) {
  }

  public function index()
  {
    $users = $this->userService->findAll();
    return UserResource::collection($users);
  }

  public function store(CreateUserRequest $request)
  {
    $user = $this->userService->createUser($request->validated());
    return new UserResource($user);
  }

  public function show(User $user)
  {
    return new UserResource($user);
  }

  public function update(User $user, UpdateUserRequest $request)
  {
    $newUser = $this->userService->updateUser($user, $request->validated());
    return new UserResource($newUser);
  }
  public function destroy(User $user)
  {
    $user = $this->userService->deleteUser($user);
    return response()->json(['message' => 'User deleted successfully']);
  }
}
