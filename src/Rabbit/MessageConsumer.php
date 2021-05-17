<?php

namespace App\Rabbit;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class MessageConsumer implements ConsumerInterface
{
    public function execute(AMQPMessage $msg)
    {
        $message = json_decode($msg->body, true);

        echo 'Received a message from '.$message['sender'];
    }
}
