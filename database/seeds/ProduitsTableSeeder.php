<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Produit;
class ProduitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach(range(1, 34) as $index)
        {
            $produit= Produit::create([
                'nom' => $faker->word(),
                'description' => $faker->sentence(6),
                'prix' => $faker->randomNumber(2)
            ]);
        }
    }
}
