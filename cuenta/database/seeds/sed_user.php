<?php

use Illuminate\Database\Seeder;
use App\User;

class sed_user extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = User::create([
            'name' => 'Mabel Medina',
            'users_nick' => 'mmabel',
            'email' => 'mmabel@advans.mx', 
            'password' => bcrypt('Admin123*'),
        ]);



        
    }
}
