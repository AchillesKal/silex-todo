<?php

namespace Todo\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DefaultController
{

    public function indexAction(Request $request, Application $app)
    {

        $data = array(
            'task' => 'Task',
        );
        $form = $app['form.factory']->createBuilder(FormType::class, $data)
            ->add('task', TextType::class)
            ->getForm();


        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            return $app->redirect($app['url_generator']->generate('homepage'));
        }

        // display the form
        return $app['twig']->render('index.html.twig', array('form' => $form->createView()));

    }

}