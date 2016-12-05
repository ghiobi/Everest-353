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
        Setting::create([
            'key' => 'user_membership_fee',
            'type' => 'numeric',
            'display_name' => 'Initial Membership Fee',
            'description' => 'One-time fee required to become a member.',
            'value' => '10']);

        // Threshold that the user must have in order to access the system
        Setting::create([
            'key' => 'user_balance_threshold',
            'type' => 'numeric',
            'display_name' => 'User Balance Threshold',
            'description' => 'A minimum amount that the user must have on its balance in order to access the system.',
            'value' => '20'
        ]);

        // Amount at which the user can withdraw the excess of money
        Setting::create([
            'key' => 'user_balance_withdraw',
            'type' => 'numeric',
            'display_name' => 'Minimum Balance Statement For Withdrawal',
            'description' => 'Minimum balance that the user must hold in order to perform a withdraw operation.',
            'value' => '30'
        ]);

        // Income percentage for the company per ride
        Setting::create([
            'key' => 'company_income_percentage',
            'type' => 'numeric',
            'display_name' => 'Company Income Percentage Per Ride',
            'description' => 'Percentage of each ride transaction that goes to the company. Remaining goes to the driver.',
            'value' => '0.05'
        ]);

        // Initial cost for any ride
        Setting::create([
            'key' => 'ride_initial_cost',
            'type' => 'numeric',
            'display_name' => 'Initial Cost Of A Ride',
            'description' => 'The initial cost for a car ride, excluding the fuel cost.',
            'value' => '10.00'
        ]);

        // Fake average cost per kilometer for the fuel
        Setting::create([
            'key' => 'fuel_cost_per_kilometer',
            'type' => 'numeric',
            'display_name' => 'Fuel Cost Per Kilometer',
            'description' => 'The average fuel cost required to ride one kilometer ($/kilometer)',
            'value' => '0.20'
        ]);

        // Public announcement
        Setting::create([
            'key' => 'public_announcement',
            'type' => 'string',
            'display_name' => 'Public Announcement',
            'description' => 'Public announcement displayed on the main page of the website.',
            'value' => 'This is a public announcement, it can be changed in the settings page by an administrator.'
        ]);
    }
}
