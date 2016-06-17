<?php
/**
 * Created by PhpStorm.
 * User: pawe
 * Date: 6/16/16
 * Time: 10:46 PM
 */

namespace AppBundle\Services;


use AppBundle\DAO\PostQueue;
use AppBundle\Entity\Post;
use OldSound\RabbitMqBundle\RabbitMq\Consumer;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use OldSound\RabbitMqBundle\RabbitMq\Producer;
use PhpAmqpLib\Exception\AMQPTimeoutException;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Config\Definition\Exception\Exception;

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

    public function publish(Post $post)
    {

        $this->producer->publish(new PostQueue($post->getId(), $post->getTitle()), 'sample');
    }

    public function consume()
    {

        try {
            return $this->consumer->consume(1);
        } catch (AMQPTimeoutException $e) {
//            var_dump($e->getMessage());

            return (array('id' => 0, 'title' => 'Brak nowych wiadomości'));
        }

    }
}