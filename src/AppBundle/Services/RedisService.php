<?php

namespace AppBundle\Services;


use AppBundle\DAO\User;
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

    private function authsecret() {
        $fd   = fopen("/dev/urandom", "r");
        $data = fread($fd, 16);
        fclose($fd);

        return md5($data);

    }
    public function registerUser(User $user) {
        $this->redisClient->hset("users", $user->getUsername(), $user->getId());
        $this->redisClient->hmset("user:$user->id",
            "username", $user->getUsername(),
            "password", $user->getPassword(),
            "auth", $this->authsecret());
        $this->redisClient->hset("auths", $this->authsecret(), $user->getId());

    }

}
