
<?php
    require('vendor/autoload.php');
    use PhpAmqpLib\Connection\AMQPConnection;
    use PhpAmqpLib\Message\AMQPMessage;

    $url = parse_url(getenv('CLOUDAMQP_URL'));
    $conn = new AMQPConnection($url['host'], 5672, $url['user'], $url['pass'], substr($url['path'], 1));
    $ch = $conn->channel();
    $exchange = 'amq.direct';
    $queue = 'basic_get_queue';
    $ch->queue_declare($queue, false, true, false, false);
    $ch->exchange_declare($exchange, 'direct', true, true, false);
    $ch->queue_bind($queue, $exchange);
    while(true){
        $retrived_msg = $ch->basic_get($queue);
        var_dump($retrived_msg->body);
    }
/*
$files = scandir("files/simcards",1);
$files = array_diff($files, array('.', '..'));
$files->each(function($file) {
    $rows = Excel::selectSheetsByIndex(0)->load("files/simcards/" . $file, function($reader) {})->get();
    global $request,$counter_filas,$filas_buenas,$filas_malas,$errores,$msg;
    $counter_filas = 0; $filas_buenas = 0; $filas_malas=0; $msg = ""; $errores = "";
    $rows->each(function($row) {
        global $request,$counter_filas,$filas_buenas,$filas_malas,$errores,$msg;
        try{
            $counter_filas++;
            $fecha_adjudicacion = $row->fecha_adjudicacion;
            if($fecha_adjudicacion != null){
                $fecha_adjudicacion = $fecha_adjudicacion->format('Y-m-d');
            }
            $fecha_activacion = $row->fecha_activacion;
            if($fecha_activacion != null){
                $fecha_activacion = $fecha_activacion->format('Y-m-d');
            }
            $fecha_asignacion = $row->fecha_asignacion;
            if($fecha_asignacion != null){
                $fecha_asignacion = $fecha_asignacion->format('Y-m-d');
            }
            $simcard = new Simcard(array("ICC" => $row->icc, "numero_linea" => $row->numero_linea,"categoria" => $request['categoria'] ,"fecha_adjudicacion" => $fecha_adjudicacion,"fecha_activacion" => $fecha_activacion,"fecha_asignacion" => $fecha_asignacion,"paquete_ID" => $row->paquete_id,"Cliente_identificacion" => $row->cliente_identificacion));
            $simcard->save();
            $filas_buenas++;
        }catch(\Exception $e){
            if($e->getCode() == 23000){
                $errores = $errores . $counter_filas . ":  ICC ya registrada\n"; 
            }else{
                $errores = $errores . $counter_filas . ": " . $e->getMessage() ."\n";    
            }
            $filas_malas++;
        }
    });
    unlink("files/simcards/" . $file);
});
*/
