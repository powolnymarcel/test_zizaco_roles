<?php


use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach(range(1, 450) as $index)
        {
            $user=User::create([
                'name' => $faker->userName(),
                'email' => $faker->safeEmail,
                'password' => 'secret'
            ]);
            $rand= rand(1,7);
            $user->attachRole($rand);
        }
    }

}
