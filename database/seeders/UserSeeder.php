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
        DB::table('users')->insert([
           'name' => 'mustafa',
           'surname' => 'arslan',
           'email' => 'mustafa@mail.com',
           'group_id' => 1,
           'password' => Hash::make('1234'),
        ]);
    }
}
