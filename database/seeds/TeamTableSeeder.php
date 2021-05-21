<?php

use Illuminate\Database\Seeder;

class TeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $teams = [];
        for($i = 0; $i < 10; ++$i){
            $teams[] = [
                'team_name' => $faker->company,
                'user_id' => $i+1,
            ];
        }
        DB::table('team')->insert($teams);
    }
}
