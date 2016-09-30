<?php

use Illuminate\Database\Seeder;
use App\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Initial membership fee
        Setting::insert([
            'key' => 'user_membership_fee',
            'display_name' => 'Initial Membership Fee',
            'description' => 'One-time fee required to become a member.',
            'value' => '10']);

        // Threshold that the user must have in order to access the system
        Setting::insert([
            'key' => 'user_balance_threshold',
            'display_name' => 'User Balance Threshold',
            'description' => 'A minimum amount that the user must have on its balance in order to access the system.',
            'value' => '20'
        ]);

        // Income percentage for the company per ride
        Setting::insert([
            'key' => 'company_income_percentage',
            'display_name' => 'Company Income Percentage Per Ride',
            'description' => 'Percentage of each ride transaction that goes to the company. Remaining goes to the driver.',
            'value' => '0.05'
        ]);
    }
}
