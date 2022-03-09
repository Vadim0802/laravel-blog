<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(20)->create();

        User::create([
            'name' => 'admin',
            'email' => 'admin@articabr.com',
            'password' => Hash::make('admin'),
            'profile_picture' => User::DEFAULT_PICTURE,
            'is_admin' => true
        ]);
    }
}
