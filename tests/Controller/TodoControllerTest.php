<?php

namespace Tests\Controller;

use Silex\WebTestCase;

class TodoControllerTest extends WebTestCase
{

    public function testListAction()
    {
        $client = $this->createClient();

        $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isSuccessful());
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