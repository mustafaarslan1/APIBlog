<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserGroup extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User Gruplarımızı tanımlıyoruz.
        $groups = [
            // admin
            [
                'role' => 'admin',
                'description' => 'Blog Admini'
            ],
            // yazar
            [
                'role' => 'yazar',
                'description' => 'Blog Yazarı'
            ],
            // abone
            [
                'role' => 'abone',
                'description' => 'Blog Abonesi'
            ]
        ];

        foreach ($groups as $group) {
            $check = null;
            $check = DB::table('user_groups')->where('name', $group['name'])->first();
            if ($check === null) {
                $group['created_at'] = now();
                $group['updated_at'] = now();
                DB::table('user_groups')->insert($group);
            } else {
                $group['updated_at'] = now();
                DB::table('user_groups')->where('id', $check->id)->update($group);
            }
        }
    }
}
