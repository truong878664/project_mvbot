<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // $groupId = DB::table('groups')->insert([
        //     'name' => 'Administrator',
        //     'user_id' => 0,
        //     'permissions' => '{"users":["view","add","edit","delete"],"groups":["view","add","edit","delete","permission"]}',
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s')
        // ]);

        // DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // if ($groupId > 0) {
        //     $userId = DB::table('users')->insertGetId([
        //         'name' => 'admin',
        //         'email' => 'admin@gmail.com',
        //         'password' => Hash::make('123123'),
        //         'group_id' => $groupId,
        //         'user_id' => 0,
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s')
        //     ]);
        // }

        // DB::table('modules')->insert([
        //     'name' => 'users',
        //     'title' => 'Manager users',
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s'),
        // ]);

        // DB::table('modules')->insert([
        //     'name' => 'groups',
        //     'title' => 'Manager groups',
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s'),
        // ]);
    }
}
