<?php

use Illuminate\Database\Seeder;

class SujetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $sujets = [];
        for($i = 0; $i < 40; ++$i){
            $sujets[] = [
                'categorie_id' => rand(1,4),
                'enonce' => $faker->text(rand(500, 1000)),
                'titre' => $faker->word,
                'flag' => '0x5655AVC',
                'user_id' => rand(1,30),
                'nb_points' => rand(150,500),
                'nb_try' => rand(1,5),
            ];
        }
        DB::table('sujet')->insert($sujets);
    }
}
