<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user, UserService $userService)
    {
        $userService->updateUser(
            $request->name,
            $request->email,
            $request->password,
            $request->file('profile_picture'),
            $user
        );

        return to_route('users.show', $user)
            ->with('success', 'Profile updated successfully!');
    }
}
