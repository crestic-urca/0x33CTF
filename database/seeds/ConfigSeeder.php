<?php

use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $config[] = [
            'name' => "ConfigTest",
            'email_verification' => false,
            'date_start' => now(),
            'date_end'=> new DateTime('tomorrow'),
            'max_players_per_team'=> 3,
            'description' => $faker->text(rand(1500, 3000)),
        ];
        DB::table('ctf_config')->insert($config);
    }
}
