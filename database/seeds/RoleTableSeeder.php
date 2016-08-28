<?php

use Illuminate\Database\Seeder;
use App\Role;
class RoleTableSeeder extends Seeder
{
    /**

     * Run the database seeds.

     *

     * @return void

     */

    public function run()

    {


        $roles = [

            [
                'name' => 'user',
            ],
            [
                'name' => 'formateur',
            ],
            [
                'name' => 'admin_franchise',
            ],
            [
                'name' => 'super_admin',
            ],
            [
                'name' => 'collaborateur_externe',
            ],
            [
                'name' => 'collaborateur_interne',
            ],
            [
                'name' => 'partenaire_commercial',
            ],
        ];


        foreach ($roles as $key => $value) {

            Role::create($value);

        }

    }
}
