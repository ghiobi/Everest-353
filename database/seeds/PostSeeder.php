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
        //Local and one time
        $post = new \App\Post([
            'name' => 'A trip to Concordia!',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris nec gravida tortor. Aliquam et ligula risus. In maximus, ex quis posuere congue, ligula mauris condimentum.',
            'num_riders' => '4',
            'one_time' => true,
            'departure_pcode' => 'H4B 1R6',
            'destination_pcode' => 'H1X 1H2',
            'poster_id' => 3,
            'cost' => 90,
            'departure_date' => (new \Carbon\Carbon())->addDays(5),
            'is_request' => false
        ]);
        \App\LocalTrip::create([
            'departure_time' => '11:00:00',
            'frequency' => [0, 0, 0, 0, 0, 0, 0]
        ])->postable()->save($post);
        $trip = new \App\Trip([
            'host_id' => $post->poster_id,
            'name' => $post->name,
            'description' => $post->description,
            'departure_datetime' => (new \Carbon\Carbon())->addDays(3),
            'departure_pcode' => 'H4B 1R6',
            'arrival_pcode' => 'H1X 1H2',
            'num_riders' => 2,
            'cost' => 30
        ]);
        $post->trips()->save($trip);
        $trip->users()->attach([2, 5]);

        //Local and frequent
        $post = new \App\Post([
            'name' => 'A trip to Concordia!',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis blandit nisl. Morbi vestibulum.',
            'num_riders' => '4',
            'one_time' => false,
            'departure_pcode' => 'H4B 1R6',
            'destination_pcode' => 'H1X 1H2',
            'poster_id' => 3,
            'departure_date' => (new \Carbon\Carbon())->addDays(4),
            'cost' => 90,
            'is_request' => false
        ]);
        \App\LocalTrip::create([
            'departure_time' => '11:00:00',
            'frequency' => [0, 1, 0, 0, 0, 1, 0]
        ])->postable()->save($post);


        //Long distance and frequent.
        $post = new \App\Post([
            'name' => 'I have two seats to Toronto!',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium alias consequatur consequuntur culpa dicta dignissimos dolor doloremque dolores explicabo incidunt ipsa minima necessitatibus nisi porro quaerat quibusdam, quisquam quo velit?',
            'num_riders' => '2',
            'one_time' => true,
            'departure_pcode' => 'H3B 0A2',
            'destination_pcode' => 'M5J 1E6',
            'poster_id' => 6,
            'departure_date' => (new \Carbon\Carbon())->addDays(3),
            'cost' => 30,
            'is_request' => false
        ]);
        \App\LongDistanceTrip::create([
            'departure_city' => 'Montreal',
            'departure_province' => 'Quebec',
            'destination_city' => 'Toronto',
            'destination_province' => 'Ontario',
            'frequency' => []
        ])->postable()->save($post);
        $trip = new \App\Trip([
            'host_id' => $post->poster_id,
            'name' => $post->name,
            'description' => $post->description,
            'departure_datetime' => (new \Carbon\Carbon())->addDays(3),
            'departure_pcode' => 'H3B 0A2',
            'arrival_pcode' => 'M5J 1E6',
            'num_riders' => 2,
            'cost' => 30
        ]);
        $post->trips()->save($trip);
        $trip->users()->attach([3, 4]);

        //Long distance and frequent.
        $post = new \App\Post([
            'name' => 'Quebec on y va!',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab consequuntur cupiditate eos error expedita hic iure labore officiis quibusdam, quidem recusandae rem, repellat suscipit tempore totam unde velit veritatis voluptatum?',
            'num_riders' => '4',
            'one_time' => true,
            'departure_pcode' => 'H3B 0A2',
            'destination_pcode' => 'G1K 8R2',
            'poster_id' => 4,
            'departure_date' => (new \Carbon\Carbon())->addDays(1),
            'cost' => 90,
            'is_request' => false
        ]);
        \App\LongDistanceTrip::create([
            'departure_city' => 'Montreal',
            'departure_province' => 'Quebec',
            'destination_city' => 'Quebec City',
            'destination_province' => 'Quebec',
            'frequency' => 0
        ])->postable()->save($post);
        $trip = new \App\Trip([
            'host_id' => $post->poster_id,
            'name' => $post->name,
            'description' => $post->description,
            'departure_datetime' => (new \Carbon\Carbon())->addDays(3),
            'departure_pcode' => 'H3B 0A2',
            'arrival_pcode' => 'M5J 1E6',
            'num_riders' => 2,
            'cost' => 30
        ]);
        $post->trips()->save($trip);
        $trip->users()->attach([2, 3]);

    }
}
