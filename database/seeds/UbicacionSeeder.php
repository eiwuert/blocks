<?php

use Illuminate\Database\Seeder;
use App\Ubicacion;

class UbicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ubicacion = new Ubicacion();
        $ubicacion->region = "Central";
        $ubicacion->ciudad = "Bogotá";
        $ubicacion->save();
        
        $ubicacion = new Ubicacion();
        $ubicacion->region = "Central";
        $ubicacion->ciudad = "Facatativa";
        $ubicacion->save();
        
        $ubicacion = new Ubicacion();
        $ubicacion->region = "Norte";
        $ubicacion->ciudad = "Barraquilla";
        $ubicacion->save();
        
        $ubicacion = new Ubicacion();
        $ubicacion->region = "Sur";
        $ubicacion->ciudad = "Cali";
        $ubicacion->save();
    }
}
