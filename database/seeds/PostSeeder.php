<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Local and one time.
        \App\LocalTrip::create([
            'departure_time' => '11:00:00',
            'frequency' => [0, 0, 0, 0, 0, 0, 0]
        ])->postable()->save(new \App\Post([
            'name' => 'A trip to Concordia!',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris nec gravida tortor. Aliquam et ligula risus. In maximus, ex quis posuere congue, ligula mauris condimentum.',
            'num_riders' => '4',
            'one_time' => true,
            'departure_pcode' => 'H4B 1R6',
            'destination_pcode' => 'H1X 1H2',
            'poster_id' => 3,
            'cost' => 90,
            'departure_date' => new \Carbon\Carbon(),
            'is_request' => false
        ]));

        //Local and frequent.
        \App\LocalTrip::create([
            'departure_time' => '11:00:00',
            'frequency' => [0, 1, 0, 0, 0, 1, 0]
        ])->postable()->save(new \App\Post([
            'name' => 'A trip to Concordia!',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis blandit nisl. Morbi vestibulum.',
            'num_riders' => '4',
            'one_time' => false,
            'departure_pcode' => 'H4B 1R6',
            'destination_pcode' => 'H1X 1H2',
            'poster_id' => 3,
            'departure_date' => new \Carbon\Carbon(),
            'cost' => 90,
            'is_request' => false
        ]));

    }
}
