<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

$app->match('/', function (Request $request) use ($app) {
    // some default data for when the form is displayed the first time
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
})->bind('homepage');;

$app->get('/todo/{id}', function ($id) use ($app){
    return $id;
})->bind('new_todo');