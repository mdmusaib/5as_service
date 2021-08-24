<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table users is empty
        if (DB::table('users')->get()->count() == 0) {
            DB::table('users')->insert([

            [
                'name' => "Super Admin",
                'email' => 'admin@5as.com',
                'password' => Hash::make('admin123'),
                'phone' => mt_rand(1000000000, 9999999999),
                'status'=>true,
                'role'=>1,
                'api_token' => Str::random(60),
                'remember_token' => Str::random(10),
            ],
            
            [
                'name' => "Sales Lead",
                'email' => 'lead@5as.com',
                'password' => Hash::make('admin123'),
                'phone' => mt_rand(1000000000, 9999999999),
                'status'=>true,
                'role'=>2,
                'api_token' => Str::random(60),
                'remember_token' => Str::random(10),
            ],
            
            [
                'name' => "BD Exec",
                'email' => 'bde@5as.com',
                'password' => Hash::make('admin123'),
                'phone' => mt_rand(1000000000, 9999999999),
                'status'=>true,
                'role'=>3,
                'api_token' => Str::random(60),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => "Event Co-ordinator",
                'email' => 'event-co@5as.com',
                'password' => Hash::make('admin123'),
                'phone' => mt_rand(1000000000, 9999999999),
                'status'=>true,
                'role'=>4,
                'api_token' => Str::random(60),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => "Data Manager",
                'email' => 'datamanager@5as.com',
                'password' => Hash::make('admin123'),
                'phone' => mt_rand(1000000000, 9999999999),
                'status'=>true,
                'role'=>5,
                'api_token' => Str::random(60),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => "Ops Exec",
                'email' => 'ops@5as.com',
                'password' => Hash::make('admin123'),
                'phone' => mt_rand(1000000000, 9999999999),
                'status'=>true,
                'role'=>6,
                'api_token' => Str::random(60),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => "Photography Exec",
                'email' => 'photography@5as.com',
                'password' => Hash::make('admin123'),
                'phone' => mt_rand(1000000000, 9999999999),
                'status'=>true,
                'role'=>7,
                'api_token' => Str::random(60),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => "Videography Exec",
                'email' => 'videography@5as.com',
                'password' => Hash::make('admin123'),
                'phone' => mt_rand(1000000000, 9999999999),
                'status'=>true,
                'role'=>8,
                'api_token' => Str::random(60),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => "Photoshop Exec",
                'email' => 'photoshop@5as.com',
                'password' => Hash::make('admin123'),
                'phone' => mt_rand(1000000000, 9999999999),
                'status'=>true,
                'role'=>9,
                'api_token' => Str::random(60),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => "Retouch ",
                'email' => 'retouch@5as.com',
                'password' => Hash::make('admin123'),
                'phone' => mt_rand(1000000000, 9999999999),
                'status'=>true,
                'role'=>10,
                'api_token' => Str::random(60),
                'remember_token' => Str::random(10),
            ],

        ]);
        } else {
            echo "\e Table is not empty, therefore NOT Able to create user! ";
        }
    }
}
