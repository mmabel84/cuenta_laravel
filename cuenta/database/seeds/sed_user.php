<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
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
            'name' => 'Usuario API',
            'users_nick' => 'api',
            'email' => 'usuario.api@advans.mx', 
            'password' => bcrypt('Usuarioapi123*'),
        ]);

    }
}
