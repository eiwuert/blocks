<?php

use Illuminate\Database\Seeder;

use App\Descripcion_Equipo;

class EquipoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() 
    {
        $rows = Excel::selectSheetsByIndex(0)->load("public/files/equipo/descripcion/descripcion_equipos.csv",false,'ISO-8859-1', function($reader) {})->get();
        $rows->each(function($row) {
            try{
                $equipo = Descripcion_Equipo::find($row->cod_scl);
                if($equipo == null)
                    $equipo = new Descripcion_Equipo();
                $equipo->cod_scl = trim($row->cod_scl);
                $equipo->tecnologia = trim($row->tecnologia);
                $equipo->modelo = trim($row->nombre_equipo);
                $equipo->precio_prepago = trim($row->prepago_con_iva);
                $equipo->precio_contado = trim($row->contado_con_iva);
                $equipo->precio_3_cuotas = trim($row->cuotas_3_con_iva);
                $equipo->precio_6_cuotas = trim($row->cuotas_6_con_iva);
                $equipo->precio_12_cuotas = trim($row->cuotas_12_con_iva);
                $equipo->precio_24_cuotas = trim($row->cuotas_24_con_iva);
                $equipo->save();
            }catch(\Exception $e){
                $this->command->info($e->getMessage());
            }
        });
    }
}
