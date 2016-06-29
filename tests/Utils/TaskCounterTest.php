<?php

namespace Tests\Utils;

use Silex\WebTestCase;
use Todo\Utils\TaskCounter;

class TaskCounterTest extends WebTestCase
{

    public function testCheckReturnsTrueWhenNumberLessThanTen()
    {
        $app = $this->createApplication();
        $number = 9;

        $taskCounter = new TaskCounter($app['session']);

        $result = $taskCounter->check($number);

        $this->assertTrue($result);
    }

    public function testCheckReturnsFalseWhenNumbeMoreThanTen()
    {
        $app = $this->createApplication();
        $number = 11;

        $taskCounter = new TaskCounter($app['session']);

        $result = $taskCounter->check($number);

        $this->assertFalse($result);
    }

    public function testCheckReturnsFalseWhenNumbeEqualToTen()
    {
        $app = $this->createApplication();
        $number = 10;

        $taskCounter = new TaskCounter($app['session']);

        $result = $taskCounter->check($number);

        $this->assertFalse($result);
    }

    public function testCheckReturnsFalseWrittesToSession()
    {
        $app = $this->createApplication();
        $number = 12;
        $expectedWarningMessage ='You can\'t have more than 10 tasks';

        $taskCounter = new TaskCounter($app['session']);

        $taskCounter->check($number);

        $actualWarningMessage = $app['session']->getFlashBag()->get('warning')[0];

        $this->assertEquals($expectedWarningMessage, $actualWarningMessage);
    }

    public function createApplication()
    {
        $app = require __DIR__.'/../../app/app.php';
        $app['debug'] = true;
        unset($app['exception_handler']);
        $app['session.test'] = true;

        return $app;
    }
}