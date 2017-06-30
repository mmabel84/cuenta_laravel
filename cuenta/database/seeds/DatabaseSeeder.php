<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(sed_paquete::class);
        $this->call(sed_user::class);
        $this->call(sed_roles::class);
    }
}
