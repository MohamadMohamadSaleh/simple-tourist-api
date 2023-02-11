<?php

namespace Database\Seeders\Client;

use Database\Factories\Client\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        UserFactory::new()
            ->user()
            ->create(['email' => 'test@gmail.com']);
        UserFactory::new()
            ->admin()
            ->create(['email' => 'admin@gmail.com', 'username' => 'admin']);
        UserFactory::new()
            ->user()
            ->count(5)
            ->create();
    }
}
