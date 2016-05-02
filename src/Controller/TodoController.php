<?php

namespace Todo\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Todo\Entity\Task;
use Todo\Form\Type\TodoType;
use Todo\Form\Type\TodoEditType;

class TodoController
{
    public function listAction(Request $request, Application $app)
    {
        $tasks = $app['repository.task']->findAll();
        $tasksNumber = $app['repository.task']->count();

        $form = $app['form.factory']->createBuilder(TodoType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $app['task.counter']->check($tasksNumber)) {

            $task = $form->getData();
            $app['repository.task']->save($task);

            return $app->redirect($app['url_generator']->generate('homepage'));
        }

        return $app['twig']->render('index.html.twig', array('form' => $form->createView(), 'tasks'=>$tasks ));
    }

    public function showAction($id, Application $app)
    {
        $task = $app['repository.task']->findOneById($id);

        if(!$task){
            return 'Not cewl';
        }

        return $app['twig']->render('show.html.twig', array('task'=>$task ));
    }

    public function editAction($id, Application $app, Request $request)
    {
        $task = $app['repository.task']->findOneById($id);

        $form = $app['form.factory']->createBuilder(TodoEditType::class, $task)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $task->setName($data->getName());
            $task->setDescription($data->getDescription());
            $task->setIsDone($data->getIsDone());

            $app['repository.task']->save($task);

            $app['session']->getFlashBag()->add('success', 'Task "'.$data->getName().'" edited successfully');

            return $app->redirect($app['url_generator']->generate('homepage'));
        }

        return $app['twig']->render('edit.html.twig', array('editForm' => $form->createView(), 'task'=>$task));
    }

    public function deleteAction($id, Application $app)
    {
        $task = $app['repository.task']->findOneById($id);

        $app['repository.task']->delete($task);

        return $app->redirect($app['url_generator']->generate('homepage'));
    }

    public function aboutAction(Application $app)
    {
        return $app['twig']->render('about.html.twig');
    }

}