<?php

use Illuminate\Database\Seeder;
use App\Post;
use Faker\Factory as Faker;
class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('fr_FR');
        foreach(range(1, 3) as $index)
        {
            $post= Post::create([
                'titre_fr' => $faker->word,
                'contenu_fr' => $faker->word,
                'user_id' => 1,
                'uuid' => \Webpatser\Uuid\Uuid::generate()
            ]);
        }
    }
}
