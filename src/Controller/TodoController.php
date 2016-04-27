<?php

namespace Todo\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Todo\Entity\Task;
use Todo\Form\Type\TodoType;

class TodoController
{
    public function listAction(Request $request, Application $app)
    {
        $tasks = $app['repository.task']->findAll();

        $form = $app['form.factory']->createBuilder(TodoType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $data = $form->getData();

            $task = new Task();
            $task->setName($data['name']);

            $app['repository.task']->save($task);

            return $app->redirect($app['url_generator']->generate('homepage'));
        }

        // display the form
        return $app['twig']->render('index.html.twig', array('form' => $form->createView(), 'tasks'=>$tasks ));
    }

    public function showAction($id, Application $app)
    {
        $task = $app['repository.task']->findOneById($id);

        if(!$task){
            return 'Not cewl';die;
        }

        return $app['twig']->render('show.html.twig', array('task'=>$task ));
    }

    public function newAction(Request $request, Application $app)
    {
        return 'The id is ';
    }

}