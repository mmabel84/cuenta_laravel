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
            'name' => 'Admin',
            'users_nick' => 'admin',
            'email' => 'cuenta.admin@advans.mx', 
            'password' => bcrypt('Admin123*'),
        ]);

        
    }
}
