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
            'email' => 'admin@mail.com',
            'first_name' => 'System',
            'last_name' => 'User',
            'balance' => 100.00
        ]);

        $owner->attachRoles([1, 2]);

        $admin = \App\User::create([
            'password' => bcrypt('password'),
            'email' => 'lim-philip@hotmail.com',
            'first_name' => 'Philip',
            'last_name' => 'Lim',
            'balance' => 100.00,
            'license_num' => 'LIMP987654321'
        ]);

        $admin->attachRole(2);

        \App\User::create([
            'password' => bcrypt('password'),
            'email' => 'lamlaurendy@gmail.com',
            'first_name' => 'Laurendy',
            'last_name' => 'Lam',
            'balance' => 100.00,
            'license_num' => 'LAML123456789'
        ]);

        \App\User::create([
            'password' => bcrypt('password'),
            'email' => 'donaldtrump@mail.com',
            'first_name' => 'Donald',
            'last_name' => 'Trump',
            'balance' => 50.00
        ]);

        \App\User::create([
            'password' => bcrypt('password'),
            'email' => 'barackobama@mail.com',
            'first_name' => 'Barack',
            'last_name' => 'obama',
            'balance' => 150.00
        ]);

        \App\User::create([
            'password' => bcrypt('password'),
            'email' => 'justintrudeau@mail.com',
            'first_name' => 'Justin',
            'last_name' => 'Trudeau',
            'balance' => 150.00
        ]);

        \App\User::create([
            'password' => bcrypt('password'),
            'email' => 'stephenhawking@mail.com',
            'first_name' => 'Stephen',
            'last_name' => 'Hawking',
            'balance' => 200.00
        ]);


        \App\User::create([
            'password' => bcrypt('password'),
            'email' => 'hillaryclinton@mail.com',
            'first_name' => 'Hillary',
            'last_name' => 'Clinton',
            'balance' => 100.00
        ]);
    }
}
