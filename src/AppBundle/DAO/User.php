<?php
/**
 * Created by PhpStorm.
 * User: pawe
 * Date: 6/15/16
 * Time: 11:52 AM
 */

namespace AppBundle\DAO;


class User
{

    /**
     * @var int
     *
     */
    public $id;

    /**
     * @var string

     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }


    /**
     * User constructor.
     * @param int $id
     * @param string $username
     * @param string $password
     */
    public function __construct($id, $username, $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }


}