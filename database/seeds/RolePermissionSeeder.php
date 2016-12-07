<?php

use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Role::insert([
            ['name' => 'super-admin', 'display_name' => 'Application Owner', 'description' => 'Owner of the application.'],
            ['name' => 'admin', 'display_name' => 'Application Administrator', 'description' => 'User is an application administrator.'],
        ]);

//        \App\Permission::insert([
//            ['name' => '', 'display_name' => '', 'description' => ''],
//        ]);
    }
}
