<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    // bcrypt 10 rounds
    private $hashes = [
        'p' => '$2y$10$eKkhO6SNyqvWgJH/8S7B4esju2j9rZr5Q5JoDdu6CmK1tn2DgO8iy',
        'admin' => '$2y$10$f1MxqqRHb7mSyo13ryuMiODOgl8WD6IibAzndCLwlMCECT.hLOu5G',
        'joueur' => '$2y$10$gZI1e7salQ9Jq08RX8kmTupUuktH/d8Ht22ejWIdIdw9tvaW9EXi.',
        'creator' => '$2y$10$8iu6ufyYv54W.XnVXc4OSel91PFz65EHfMNiMb8TZb0o8pr7Eqbfm',
    ];

    private function cached_bcrypt($password) {
        if (!isset($this->hashes[$password])) {
            $this->command->warn('missing cached hash for : ' . $password);
            $this->hashes[$password] = Hash::make($password);
        }
        else if (Hash::needsRehash($this->hashes[$password])) {
            $this->command->warn('cached hash needs rehashing : ' . $password);
            $this->hashes[$password] = Hash::make($password);
        }

        return $this->hashes[$password];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [];

        // warning :
        // bulk insertion will fail without 'admin' and 'ctf_creator'

        for($i = 0; $i < 30; ++$i){
            $users[] = [
                'name' => 'Name' . $i,
                'email' => 'email' . $i . '@crot.fr',
                'password' => $this->cached_bcrypt('p'),
                'admin' => false,
                'ctf_creator' => false,
                'ctf_player' => true,
                'email_verified_at' => '2018-04-01 00:00:00',
            ];
        }
        $users[] = [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => $this->cached_bcrypt('admin'),
            'admin' => true,
            'ctf_creator' => true,
            'ctf_player' => false,
            'email_verified_at' => '2018-04-01 00:00:00',
        ];

        $users[] = [
            'name' => 'joueur',
            'email' => 'joueur@gmail.com',
            'password' => $this->cached_bcrypt('joueur'),
            'admin' => false,
            'ctf_creator' => false,
            'ctf_player' => true,
            'email_verified_at' => '2018-04-01 00:00:00',
        ];

        $users[] = [
            'name' => 'creator',
            'email' => 'creator@gmail.com',
            'password' => $this->cached_bcrypt('creator'),
            'admin' => false,
            'ctf_creator' => true,
            'ctf_player' => false,
            'email_verified_at' => '2018-04-01 00:00:00',
        ];

        DB::table('users')->insert($users);
    }
}
