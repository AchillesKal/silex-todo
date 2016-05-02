<?php

namespace Todo\Utils;

use Silex\Application;
use Symfony\Component\HttpFoundation\Session\Session;

class TaskCounter
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function check($tasksNumber)
    {
        if($tasksNumber >= 10){
            $this->session->getFlashBag()->add('warning', 'You can\'t have more than 10 tasks');
            return false;
        }

        return true;
    }
}