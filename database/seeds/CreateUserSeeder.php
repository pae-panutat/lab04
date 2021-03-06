<?php

use Illuminate\Database\Seeder;
use App\User;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'is_admin' => "1",
                'password' => bcrypt('1234')
            ],
            [
                'name' => 'User',
                'email' => 'user@user.com',
                'is_admin' => "0",
                'password' => bcrypt('1234')
            ],
            [
                'name' => 'User2',
                'email' => 'user2@user2.com',
                'is_admin' => "0",
                'password' => bcrypt('1234')
            ]
        ];

        foreach($user as $key => $value){
            User::create($value);
        }

    }
}
