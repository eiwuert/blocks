<?php
namespace Acme\AmqpWrapper;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class WorkerReceiver
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
            
        /**
         * don't dispatch a new message to a worker until it has processed and 
         * acknowledged the previous one. Instead, it will dispatch it to the 
         * next worker that is not still busy.
         */
        $channel->basic_qos(
            null,   #prefetch size - prefetch window size in octets, null meaning "no specific limit"
            1,      #prefetch count - prefetch window in terms of whole messages
            null    #global - global=null to mean that the QoS settings should apply per-consumer, global=true to mean that the QoS settings should apply per-channel
            );
        
        /**
         * indicate interest in consuming messages from a particular queue. When they do 
         * so, we say that they register a consumer or, simply put, subscribe to a queue.
         * Each consumer (subscription) has an identifier called a consumer tag
         */ 
        $channel->basic_consume(
            $queue_name,            #queue
            '',                     #consumer tag - Identifier for the consumer, valid within the current channel. just string
            false,                  #no local - TRUE: the server will not send messages to the connection that published them
            false,                  #no ack, false - acks turned on, true - off.  send a proper acknowledgment from the worker, once we're done with a task
            false,                  #exclusive - queues may only be accessed by the current connection
            false,                  #no wait - TRUE: the server will not respond to the method. The client should not wait for a reply method
            array($this, 'process') #callback
            );
        
        $channel->basic_qos(
            null,   #prefetch size - prefetch window size in octets, null meaning "no specific limit"
            1,      #prefetch count - prefetch window in terms of whole messages
            null    #global - global=null to mean that the QoS settings should apply per-consumer, global=true to mean that the QoS settings should apply per-channel
        );    
            
        while(count($channel->callbacks)) {
            $this->log->addInfo('Waiting for incoming messages');
            $channel->wait();
        }
        
        $channel->close();
        $connection->close();
    }
    
    /**
     * process received request
     * 
     * @param AMQPMessage $msg
     */ 
    public function process(AMQPMessage $msg)
    {
        if($retrived_msg->body != null){
            var_dump($retrived_msg->body);
        }
    }
   
}



    