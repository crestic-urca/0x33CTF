<?php

use Illuminate\Database\Seeder;

class InvitePlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $invites = [];
        for($i = 0; $i < 10; ++$i){
            $invites[] = [
                'team_id' => rand(1,10),
                'user_id' => rand(12,30),
            ];
        }
        DB::table('invitation_player')->insert($invites);
    }
}
