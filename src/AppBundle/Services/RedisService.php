<?php

namespace AppBundle\Services;


use Predis\Client;

class RedisService
{
    /**
     * @var Client
     */
    private $redisClient;
    /**
     * RedisService constructor.
     */
    public function __construct()
    {
        $this->redisClient = new Client();
    }

    public function setToSet()
    {
        $this->redisClient->hmset("user:1012","name","Mary Jones");
        //redis-cli  HGET user:1012 name
    }

}
