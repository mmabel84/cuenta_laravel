<?php

use Illuminate\Database\Seeder;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(sed_roles::class);
        $this->call(sed_user::class);

        $apiRole = Role::where('slug','=','rol.api')->first();
        $apiUsr = User::where('email','=','mmabel@advans.mx')->first();

        if ($apiRole && $apiUsr)
        {
            $apiUsr->attachRole($apiRole);
        }

        
    }
}
