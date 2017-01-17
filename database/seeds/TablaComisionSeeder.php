<?php

use Illuminate\Database\Seeder;
use App\TablaComision;

class TablaComisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comision = new TablaComision();
        $comision->tipo = "BA";
        $comision->tipoPersona = "Natural";
        $comision->descripcion = "3000k";
        $comision->valor = 96500;
        $comision->orden = 1;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "BA";
        $comision->tipoPersona = "Natural";
        $comision->descripcion = "5000k";
        $comision->valor = 121300;
        $comision->orden = 2;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "BA";
        $comision->tipoPersona = "Natural";
        $comision->descripcion = "10000k";
        $comision->valor = 201600;
        $comision->orden = 3;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "BA";
        $comision->tipoPersona = "Natural";
        $comision->descripcion = "15000k";
        $comision->valor = 226600;
        $comision->orden = 4;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "BA";
        $comision->tipoPersona = "Natural";
        $comision->descripcion = "20000k";
        $comision->valor = 340000;
        $comision->orden = 5;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "BA";
        $comision->tipoPersona = "Natural";
        $comision->descripcion = "25000k";
        $comision->valor = 350000;
        $comision->orden = 6;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "BA";
        $comision->tipoPersona = "Natural";
        $comision->descripcion = "30000k";
        $comision->valor = 368900;
        $comision->orden = 7;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "BA";
        $comision->tipoPersona = "Natural";
        $comision->descripcion = "35000k";
        $comision->valor = 385000;
        $comision->orden = 8;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "BA";
        $comision->tipoPersona = "Natural";
        $comision->descripcion = "40000k";
        $comision->valor = 400000;
        $comision->orden = 8;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "LB";
        $comision->tipoPersona = "Natural";
        $comision->descripcion = "General";
        $comision->valor = 33500;
        $comision->orden = 1;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "TV";
        $comision->tipoPersona = "Natural";
        $comision->descripcion = "General";
        $comision->valor = 41900;
        $comision->orden = 1;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "TV";
        $comision->tipoPersona = "Natural";
        $comision->descripcion = "Televisión Diamante";
        $comision->valor = 76700;
        $comision->orden = 2;
        $comision->save();
        
        // EMPRESAS
        
        $comision = new TablaComision();
        $comision->tipo = "BA";
        $comision->tipoPersona = "Empresa";
        $comision->descripcion = "5000k";
        $comision->valor = 160000;
        $comision->orden = 2;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "BA";
        $comision->tipoPersona = "Empresa";
        $comision->descripcion = "10000k";
        $comision->valor = 231100;
        $comision->orden = 3;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "BA";
        $comision->tipoPersona = "Empresa";
        $comision->descripcion = "15000k";
        $comision->valor = 250100;
        $comision->orden = 4;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "BA";
        $comision->tipoPersona = "Empresa";
        $comision->descripcion = "20000k";
        $comision->valor = 340000;
        $comision->orden = 5;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "BA";
        $comision->tipoPersona = "Empresa";
        $comision->descripcion = "25000k";
        $comision->valor = 350000;
        $comision->orden = 6;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "BA";
        $comision->tipoPersona = "Empresa";
        $comision->descripcion = "30000k";
        $comision->valor = 368900;
        $comision->orden = 7;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "BA";
        $comision->tipoPersona = "Empresa";
        $comision->descripcion = "35000k";
        $comision->valor = 385000;
        $comision->orden = 8;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "BA";
        $comision->tipoPersona = "Empresa";
        $comision->descripcion = "40000k";
        $comision->valor = 424700;
        $comision->orden = 8;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "LB";
        $comision->tipoPersona = "Empresa";
        $comision->descripcion = "General";
        $comision->valor = 46800;
        $comision->orden = 1;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "LB";
        $comision->tipoPersona = "Empresa";
        $comision->descripcion = "Ilimitado Departamental";
        $comision->valor = 59200;
        $comision->orden = 2;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "LB";
        $comision->tipoPersona = "Empresa";
        $comision->descripcion = "Ilimitado Nacional";
        $comision->valor = 73000;
        $comision->orden = 3;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "LB";
        $comision->tipoPersona = "Empresa";
        $comision->descripcion = "Sólo segunda Línea Ilimitada Local*";
        $comision->valor = 35000;
        $comision->orden = 4;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "LB";
        $comision->tipoPersona = "Empresa";
        $comision->descripcion = "Sólo segunda Línea Ilimitada Nacional*";
        $comision->valor = 51800;
        $comision->orden = 5;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "TV";
        $comision->tipoPersona = "Empresa";
        $comision->descripcion = "General";
        $comision->valor = 47700;
        $comision->orden = 1;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "TV";
        $comision->tipoPersona = "Empresa";
        $comision->descripcion = "Televisión Diamante";
        $comision->valor = 76700;
        $comision->orden = 2;
        $comision->save();
        
        // Movistar Play
        
        $comision = new TablaComision();
        $comision->tipo = "MP";
        $comision->tipoPersona = "Natural";
        $comision->descripcion = "Movistar Play plan básico - cliente nuevo";
        $comision->valor = 12600;
        $comision->orden = 1;
        $comision->save();
        
        $comision = new TablaComision();
        $comision->tipo = "MP";
        $comision->tipoPersona = "Natural";
        $comision->descripcion = "Movistar Play plan básico - cliente existente";
        $comision->valor = 7800;
        $comision->orden = 2;
        $comision->save();
    }
}
