<?php

namespace Database\Seeders;

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
        DB::table('users')->insert([
           'name' => 'mustafa',
           'surname' => 'arslan',
           'email' => 'mustafa@mail.com',
           'password' => Hash::make('1234'),
        ]);
    }
}
