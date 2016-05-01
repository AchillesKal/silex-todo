<?php

namespace Todo\Utils;

use Silex\Application;

class TaskCounter
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function check($tasksNumber)
    {
        if($tasksNumber >= 10){
            $this->app['session']->getFlashBag()->add('warning', 'You can\'t have more than 10 tasks');
            return false;
        }

        return true;
    }
}