<?php

use Illuminate\Database\Seeder;

class CategorieTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [];
        for($i = 0; $i < 4; ++$i){
            $categories[] = [
                'nom_categorie' => 'Categorie' . $i,
            ];
        }
        DB::table('categorie')->insert($categories);
    }
}
