<?php
/**
 * Created by PhpStorm.
 * User: pawe
 * Date: 6/16/16
 * Time: 10:46 PM
 */

namespace AppBundle\Services;


use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class RQService implements ConsumerInterface
{
    public function execute(AMQPMessage $msg)
    {
        var_dump(unserialize($msg->body));
    }
}