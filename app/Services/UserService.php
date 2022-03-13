<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function updateUser(
        string $name,
        string $email,
        string $password,
        UploadedFile|null $profile_picture,
        User $user
    ) {
        $user->update([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        if ($profile_picture) {
            if ($user->profile_picture !== User::DEFAULT_PICTURE) {
                Storage::delete($user->profile_picture);
            }

            $filename = "{$user->id}.{$profile_picture->extension()}";
            $user->update([
                'profile_picture' => $profile_picture->storeAs('profile_pics', $filename)
            ]);
        }

        return $user;
    }
}
