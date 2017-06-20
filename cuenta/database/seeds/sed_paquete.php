<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Paquete;

class sed_paquete extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paqprueba = Paquete::create([
			'paqapp_cantrfc' => 10,
			'paqapp_cantgig' => 300,
			'paqapp_f_venta' => '2017/01/01',
			'paqapp_f_act' => '2017/01/10',
			'paqapp_f_caduc' => '2017/08/10',
			'paqapp_f_fin' => '2017/08/10',
		]);
    }
}
