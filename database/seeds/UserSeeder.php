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
            'email' => 'admin@mail.ca',
            'first_name' => 'The',
            'last_name' => 'System'
        ]);

        $owner->attachRoles([1, 2]);

        $admin = \App\User::create([
            'password' => bcrypt('password'),
            'email' => 'lim-philip@hotmail.com',
            'first_name' => 'Philip',
            'last_name' => 'Lim'
        ]);

        $admin->attachRole(2);

        \App\User::create([
            'password' => bcrypt('password'),
            'email' => 'lamlaurendy@gmail.com',
            'first_name' => 'Laurendy',
            'last_name' => 'Lam'
        ]);

        \App\User::create([
            'password' => bcrypt('password'),
            'email' => 'donaldtrump@mail.com',
            'first_name' => 'Donald',
            'last_name' => 'Trump'
        ]);

        \App\User::create([
            'password' => bcrypt('password'),
            'email' => 'barackobama@mail.com',
            'first_name' => 'Barack',
            'last_name' => 'obama'
        ]);

        \App\User::create([
            'password' => bcrypt('password'),
            'email' => 'justintrudeau@mail.com',
            'first_name' => 'Justin',
            'last_name' => 'Trudeau'
        ]);

        \App\User::create([
            'password' => bcrypt('password'),
            'email' => 'stephenhawking@mail.com',
            'first_name' => 'Stephen',
            'last_name' => 'Hawking'
        ]);


        \App\User::create([
            'password' => bcrypt('password'),
            'email' => 'hillaryclinton@mail.com',
            'first_name' => 'Hillary',
            'last_name' => 'Clinton'
        ]);
    }
}
