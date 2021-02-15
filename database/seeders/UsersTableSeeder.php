<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role_id' => '1',
            'name' => 'MD.Admin',
            'username' => 'admin',
            'email' => 'admin@blog.com',
            'password' => bcrypt('rootadmin'),
        ]);

        User::create([
            'role_id' => '2',
            'name' => 'MD.Author',
            'username' => 'author',
            'email' => 'author@blog.com',
            'password' => bcrypt('rootauthor'),
        ]);
    }
}
