<?php

use Illuminate\Database\Seeder;

class JoinDemandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $demands = [];
        for($i = 0; $i < 10; ++$i){
            $demands[] = [
                'team_id' => rand(1,10),
                'user_id' => rand(1,30),
            ];
        }
        DB::table('join_demand')->insert($demands);
    }
}
