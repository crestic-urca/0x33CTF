<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategorieTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(TeamTableSeeder::class);
        $this->call(SujetTableSeeder::class);
        $this->call(InvitePlayerSeeder::class);
        $this->call(JoinDemandSeeder::class);
        $this->call(ConfigSeeder::class);
        $this->call(ValidatedChallSeeder::class);
    
    }
}
