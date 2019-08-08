<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once APPPATH."/rabbitmq/receiver.php";

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RBMQMail
{
    public function sendRabQueue($toEmail,$subject,$message)
    {
        $connection = new AMQPConnection('localhost', 5672, 'admin', 'admin');
        $channel = $connection->channel();
        
        $channel->queue_declare('email_queue', false, false, false, false);
        
        $data['toEmail'] = $toEmail;
        $data['subject'] = $subject;
        $data['message'] = $message;
        $data = json_encode($data);
        
        $msg = new AMQPMessage($data, array('delivery_mode' => 2));
        $channel->basic_publish($msg, '', 'email_queue');
        
        return true;
    }

    public function sendMail()
    {
        $objrec = new RMail();
        $objrec->sendMail();
    }

    
}

 

 
?>