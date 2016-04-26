<?php

namespace Todo\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Todo\Form\Type\TodoType;

class TodoController
{

    public function listAction(Request $request, Application $app)
    {

        $form = $app['form.factory']->createBuilder(TodoType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $data = $form->getData();
            $app['repository.task']->sava($data);

            return $app->redirect($app['url_generator']->generate('homepage'));
        }

        // display the form
        return $app['twig']->render('index.html.twig', array('form' => $form->createView()));
    }

    public function showAction($id)
    {
        return 'The id is '.$id;
    }

    public function newAction(Request $request, Application $app)
    {
        return 'The id is ';
    }

}