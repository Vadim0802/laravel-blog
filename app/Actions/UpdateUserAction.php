<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UpdateUserAction
{
    public function __invoke(array $data, User $user)
    {
        $userData = collect($data)->except(['profile_picture']);

        $user->update($userData
            ->replace(['password' => Hash::make($userData->get('password'))])
            ->all());

        if (request()->hasFile('profile_picture')) {
            if ($user->profile_picture !== User::DEFAULT_PICTURE) {
                Storage::delete($user->profile_picture);
            }
            $user->update(['profile_picture' => request()->file('profile_picture')->store('profile_pics')]);
        }
    }
}
