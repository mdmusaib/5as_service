<?php

use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table employee is empty
        if (DB::table('employee')->get()->count() == 0) {
            DB::table('employee')->insert([

            [
                'employee_name' => "emp1",
                
            ],
            
            [
                'employee_name' => "emp2",
              
            ],
            
            [
                'employee_name' => "emp3",
                
            ],
        ]);
        } else {
            echo "\e Table is not empty, therefore NOT Able to create user! ";
        }
    }
}
