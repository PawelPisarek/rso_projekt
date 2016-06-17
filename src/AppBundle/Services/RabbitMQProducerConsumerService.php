<?php
/**
 * Created by PhpStorm.
 * User: pawe
 * Date: 6/16/16
 * Time: 10:46 PM
 */

namespace AppBundle\Services;


use OldSound\RabbitMqBundle\RabbitMq\Consumer;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use OldSound\RabbitMqBundle\RabbitMq\Producer;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQProducerConsumerService
{
    /**
     * @var Producer
     */
    private $producer;

    /**
     * @var Consumer
     */
    private $consumer;

    /**
     * RabbitMQProducerConsumerService constructor.
     * @param Producer $producer
     * @param Consumer $consumer
     */
    public function __construct(Producer $producer, Consumer $consumer)
    {
        $this->producer = $producer;
        $this->consumer = $consumer;
    }

    public function publish()
    {
        $this->producer->publish(serialize(array('foo'=>'bar','_FOO'=>'_BAR')), 'sample');
    }

    public function consume()
    {
        return $this->consumer->consume(1);
    }




}