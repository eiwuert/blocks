<?php

use Illuminate\Database\Seeder;

class SimcardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            factory(App\Paquete::class)->create(["Actor_cedula" => App\Actor::orderByRaw("RAND()")->first()->cedula]);
        }
        for ($i = 1; $i <= 10; $i++) {
            factory(App\Simcard::class, 20)->create(["Paquete_ID" => $i]);     
        }
        for ($i = 0; $i < 100; $i++) {
            factory(App\Comision::class,5)->create(["Simcard_ICC" => App\Simcard::orderByRaw("RAND()")->first()->ICC]);     
        }
    }
}
