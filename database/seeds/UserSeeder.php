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
        $owner = \App\User::create([
            'password' => bcrypt('password'),
            'email' => 'admin@everest.ca',
            'first_name' => 'The',
            'last_name' => 'Administrator'
        ]);

        $owner->attachRoles([1, 2]);

        $admin = \App\User::create([
            'password' => bcrypt('password'),
            'email' => 'lim-philip@hotmail.com',
            'first_name' => 'Philip',
            'last_name' => 'Lim'
        ]);

        $admin->attachRole(2);

        $user = \App\User::create([
            'password' => bcrypt('password'),
            'email' => 'lamlaurendy@gmail.com',
            'first_name' => 'Laurendy',
            'last_name' => 'Lam'
        ]);
    }
}
