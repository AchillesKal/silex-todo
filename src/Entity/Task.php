<?php

namespace Todo\Entity;

class Task
{

    private $id;

    private $name;

    private $description = 'No description';

    private $is_done = 0;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getIsDone()
    {
        if($this->is_done == 0){
            return false;
        }
        return true;
    }

    /**
     * @param mixed $is_done
     */
    public function setIsDone($is_done)
    {
        $this->is_done = $is_done;
    }

}