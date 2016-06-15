<?php

namespace AppBundle\Services;


use AppBundle\DAO\User;
use AppBundle\DAO\UserWithAuth;
use Predis\Client;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

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
        $this->redisClient->hmset("user:1012", "name", "Mary Jones");
        //redis-cli  HGET user:1012 name
    }

    private function authsecret()
    {
        $fd = fopen("/dev/urandom", "r");
        $data = fread($fd, 16);
        fclose($fd);

        return md5($data);

    }

    public function registerUser(\AppBundle\Entity\User $user)
    {

        $user = new UserWithAuth($user->getId(), $user->getUsername(), $user->getPassword(), $this->authsecret());

        $this->redisClient->hset("users", $user->getUsername(), $user->getId());


        $this->redisClient->hmset("user:" . $user->getId(),
            "username", $user->getUsername(),
            "password", $user->getPassword(),
            "auth", $user->getAuth());

        $this->redisClient->hset("auths", $user->getAuth(), $user->getId());
        return $user->getAuth();
    }

    public function loginUser(\AppBundle\Entity\User $user)
    {

        $userId = $this->redisClient->hget("users", $user->getUsername());


        if ($user->getUsername() !== $this->redisClient->hmget("user:" . $userId, "username")[0])
            throw new NotFoundResourceException('Nie ma takiego username');
        if ($user->getPassword() !== $this->redisClient->hmget("user:" . $userId, "password")[0])
            throw new NotFoundResourceException('Nie prawidłowe hasło');
        $auth = $this->redisClient->hmget("user:" . $userId, "auth")[0];


        return $auth;
    }

}
