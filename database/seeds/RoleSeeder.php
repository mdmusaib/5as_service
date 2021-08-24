<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     if(DB::table('roles')->get()->count() == 0){

        DB::table('roles')->insert([

            [
                'name' => "Admin",
                'description'=>"admin role"
            ],
            [
                'name' => "Business Development",
                'description'=>"Business Development role"
            ],
            [
                'name' => "Team Leader",
                'description'=>"Team Leader role"
            ],
            [
                'name' => "Photo Graph",
                'description'=>"Photo Graph role"
            ],
            [
                'name' => "Finance Leader",
                'description'=>"Finance Leader role"
            ],
            [
                'name' => "Sales Person",
                'description'=>"Sales Person role"
            ],

        ]);

    } else { echo "\e Table is not empty, therefore NOT Able to create roles! "; }
    }
    
}
