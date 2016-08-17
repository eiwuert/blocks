<?php

namespace App;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Worker
{
    /* ... SOME OTHER CODE HERE ... */
    
    /**
     * Process incoming request to generate pdf invoices and send them through 
     * email.
     */ 
    public function listen()
    {
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
            
        $callback = function($msg){
          var_dump($msg->body);
        };
        $channel->basic_consume($queue_name, '', false, false, false, false, $callback);
        while(true) {
            $retrived_msg = $channel->basic_get($queue_name);
            if($retrived_msg->body != null){
                var_dump("No vale: " . $retrived_msg->body);
            }
            
        }
        var_dump('Stoping worker');
        $channel->close();
        $connection->close();
    }
    
}



    