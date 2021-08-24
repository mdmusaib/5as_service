<?php

use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     if(DB::table('event_masters')->get()->count() == 0){

        DB::table('event_masters')->insert([

            [
                'name' => "Wedding",
                'description'=>"Wedding anniversary"
            ],
            [
                'name' => "Reception",
                'description'=>"reception ceremony"
            ],
            [
                'name' => "BirthDay",
                'description'=>"Birth day celebration party"
            ],
            [
                'name'=>'Photo Shoot',
                'description'=>"wedding photo shoot"
            ],

        ]);

    } else { echo "\e Table is not empty, therefore NOT Able to create event master! "; }
    }
    
}
