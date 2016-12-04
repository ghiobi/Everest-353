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

        // Amount at which the user can withdraw the excess of money
        Setting::insert([
            'key' => 'user_balance_withdraw',
            'display_name' => 'Minimum Balance Statement For Withdrawal',
            'description' => 'Minimum balance that the user must hold in order to perform a withdraw operation.',
            'value' => '30'
        ]);

        // Income percentage for the company per ride
        Setting::insert([
            'key' => 'company_income_percentage',
            'display_name' => 'Company Income Percentage Per Ride',
            'description' => 'Percentage of each ride transaction that goes to the company. Remaining goes to the driver.',
            'value' => '0.05'
        ]);

        // Initial cost for any ride
        Setting::insert([
            'key' => 'ride_initial_cost',
            'display_name' => 'Initial Cost Of A Ride',
            'description' => 'The initial cost for a car ride, excluding the fuel cost.',
            'value' => '10.00'
        ]);

        // Fake average cost per kilometer for the fuel
        Setting::insert([
            'key' => 'fuel_cost_per_kilometer',
            'display_name' => 'Fuel Cost Per Kilometer',
            'description' => 'The average fuel cost required to ride one kilometer ($/kilometer)',
            'value' => '0.20'
        ]);

        // Public announcement
        Setting::insert([
            'key' => 'public_announcement',
            'display_name' => 'Public Announcement',
            'description' => 'Public announcement displayed on the main page of the website.',
            'value' => ''
        ]);

    }
}
