<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        if (DB::table('users')->count() == 0) {
            DB::table('users')->insert([
                [
                    'id' => 1,
                    'name' => 'John Doe',
                    'email' => 'johndoe@gmail.com',
                    'password' => Hash::make('johndoe123'),
                ],
                [
                    'id' => 2,
                    'name' => 'Jane Doe',
                    'email' => 'janedoe@gmail.com',
                    'password' => Hash::make('janedoe123'),
                ],
            ]);
        }

    }
}