<?php

use Illuminate\Database\Seeder;
use App\Ubicacion;

class ActorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ubicacion = new Ubicacion();
        $ubicacion->region = "Bogotá";
        $ubicacion->ciudad = "Bogotá";
        $ubicacion->save();
        factory(App\Actor::class, 1)->create([
            'cedula' => '1015439593',
        ]);
    }
}
