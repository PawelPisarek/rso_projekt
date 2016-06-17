<?php
/**
 * Created by PhpStorm.
 * User: pawe
 * Date: 6/17/16
 * Time: 12:25 PM
 */

namespace AppBundle\DAO;


class PostQueue
{

    /**
     * @var int
  */
    private $id;

    /**
     * @var string
     *
     */
    private $title;

    /**
     * PostQueue constructor.
     * @param int $id
     * @param string $title
     */
    public function __construct($id, $title)
    {

        $this->id = $id;
        $this->title = $title;
    }

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    function __toString()
    {
        return serialize(array('id' => $this->getId(), 'title' => $this->getTitle()));
    }

}