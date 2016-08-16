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
        for ($i = 1; $i <= 100; $i++) {
            factory(App\Paquete::class)->create(["Actor_cedula" => App\Actor::orderByRaw("RAND()")->first()->cedula]);
        }
        for ($i = 1; $i <= 100; $i++) {
            factory(App\Simcard::class, 20)->create(["Paquete_ID" => $i]);     
        }
        
        factory(App\Cliente::class,5)->create();
        
        for ($i = 0; $i < 100; $i++) {
            factory(App\Comision::class,5)->create(["Simcard_ICC" => App\Simcard::orderByRaw("RAND()")->first()->ICC]);     
        }
        $comisiones = App\Comision::get();
        foreach($comisiones as $comision){
            $simcard = App\Simcard::find($comision->Simcard_ICC);
            if($simcard != null){
                $simcard->Cliente_identificacion = App\Cliente::orderByRaw("RAND()")->first()->identificacion;
            }
            $simcard->save();
        }
    }
}
