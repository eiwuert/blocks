<?php

use Illuminate\Database\Seeder;

class ComisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = Excel::selectSheetsByIndex(0)->load("public/files/simcards/comision/comision.csv",false,'ISO-8859-1', function($reader) {})->get();
        $rows->each(function($row) {
            try{
                $simcard = Simcard::where("numero_linea",$row->celular)->first();
                if($simcard == null){
                    //TODO GUARDAR ERROR    
                }else{
                    $comision = new Comision();
                    $comision->Simcard_ICC = $simcard->ICC;
                    $comision->valor = $row->total;
                    $comision->fecha = $row->periodo;
                    $comision->save();
                }
            }catch(\Exception $e){
                $this->command->info($e->getMessage());
            }
        });
    }
}
