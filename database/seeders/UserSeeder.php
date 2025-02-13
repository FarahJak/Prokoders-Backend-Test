<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name'           => 'TestUser1',
                'email'          => 'user1@test.com',
                'password'       => Hash::make('123456789'),
            ],
            [
                'name'           => 'TestUser2',
                'email'          => 'user2@test.com',
                'password'       => Hash::make('123456789'),
            ],
            [
                'name'           => 'TestUser3',
                'email'          => 'user3@test.com',
                'password'       => Hash::make('123456789'),
            ],
            [
                'name'           => 'TestUser4',
                'email'          => 'user4@test.com',
                'password'       => Hash::make('123456789'),
            ],
            [
                'name'           => 'TestUser5',
                'email'          => 'user5@test.com',
                'password'       => Hash::make('123456789'),
            ],
        ];

        User::insert($users);
    }
}
