<?php

use Illuminate\Database\Seeder;

class ValidatedChallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $validated_challs = [];
        $date_tom = new DateTime('tomorrow');

        for($i = 0; $i < 100; ++$i){

            $int = rand(strtotime(now()), strtotime( $date_tom->format('Y-m-d H:i:s') ));

            $validated_challs[] = [
                'date_validated' => date("Y-m-d H:i:s", $int),
                'sujet_id' => rand(1,40),
                'team_id' => rand(1,10),
                'state' => 1,
            ];
        }

        DB::table('validated_chall')->insert($validated_challs);    }
}
