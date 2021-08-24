<?php

use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                     
     if(DB::table('services_masters')->get()->count() == 0){

        DB::table('services_masters')->insert([

            [
                'name' => "Traditional Photographer",
                'base_unit_price'=>"15000",
                'tax'=>"10",
                'is_deliverable'=>'0',
                'description'=>"Traditional Photographer"
            ],
            [
                'name' => "Traditional Videographer",
                'base_unit_price'=>"15000",
                'tax'=>"10",
                'is_deliverable'=>'0',
                'description'=>"Traditional Videographer"
            ],
            [
                'name' => "Candid Photographer",
                'base_unit_price'=>"35000",
                'tax'=>"10",
                'is_deliverable'=>'0',
                'description'=>"Candid Photographer"
            ],
            [
                'name' => "Candid Videographer",
                'base_unit_price'=>"50000",
                'tax'=>"10",
                'is_deliverable'=>'0',
                'description'=>"Candid Videographer"
            ],
            [
                'name' => "Outdoor Photoshoot",
                'base_unit_price'=>"35000",
                'tax'=>"10",
                'is_deliverable'=>'0',
                'description'=>"Outdoor Photoshoot"
            ],
            [
                'name' => "Live Streaming",
                'base_unit_price'=>"35000",
                'tax'=>"10",
                'is_deliverable'=>'0',
                'description'=>"Live Streaming"
            ],
            [
                'name' => "Traditional Album",
                'base_unit_price'=>"7500",
                'tax'=>"10",
                'is_deliverable'=>'0',
                'description'=>"Traditional Album",
                'is_deliverable' => true
            ],

        ]);

    } else { echo "\e Table is not empty, therefore NOT Able to create service master! "; }
    }
    
}
