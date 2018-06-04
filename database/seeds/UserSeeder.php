<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* admin */

        $user = new \App\User();

        $user->name = 'admin';
        $user->email = 'admin@admin.ru';
        $user->password = \Hash::make('admin');

        $user->save();

    }
}


