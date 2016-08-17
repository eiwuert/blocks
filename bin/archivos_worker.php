<?php
namespace App;

use App\Http\Controllers\Worker;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Excel;

$url = parse_url(getenv('CLOUDAMQP_URL'));
$queue_name = "basic_get_queue";
$connection = new AMQPConnection($url['host'], 5672, $url['user'], $url['pass'], substr($url['path'], 1));
$channel = $connection->channel();

$channel->queue_declare(
    $queue_name,        #queue
    false,              #passive
    true,               #durable, make sure that RabbitMQ will never lose our queue if a crash occurs
    false,              #exclusive - queues may only be accessed by the current connection
    false               #auto delete - the queue is deleted when all consumers have finished using it
    );
    
while(true) {
    $retrived_msg = $channel->basic_get($queue_name)->body;
    if($retrived_msg != null){
        var_dump($retrived_msg);
        switch($retrived_msg){ 
            case "simcard":
                $path = "public/files/simcards/temp.xlsx" . $retrived_msg->path;
                $rows = Excel::selectSheetsByIndex(0)->load($path, function($reader) {})->get();
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
                        $simcard = new Simcard(array("ICC" => $row->icc, "numero_linea" => $row->numero_linea,"categoria" => $row->tipo ,"fecha_adjudicacion" => $fecha_adjudicacion,"fecha_activacion" => $fecha_activacion,"fecha_asignacion" => $fecha_asignacion,"paquete_ID" => $row->paquete_id,"Cliente_identificacion" => $row->cliente_identificacion));
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
                var_dump("Filas buenas: " . $filas_buenas);
                var_dump("Errores: " . $errores);
                unlink("files/simcards/" . $file);
            break;
        }
    }
    
}
var_dump('Stoping worker');
$channel->close();
$connection->close();
?>