<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 30-11-17
 * Time: 12:00
 */

/**
 * Class Emotion : DB Table
 */
class Emotion
{

    private $id;
    private $em_name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmName()
    {
        return $this->em_name;
    }

    /**
     * @param mixed $em_name
     */
    public function setEmName($em_name)
    {
        $this->em_name = $em_name;
    }
}