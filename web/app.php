<?php

require_once __DIR__.'/../vendor/autoload.php';

use Silex\Provider\FormServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../app/views',
));
$app->register(new FormServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.domains' => array(),
));

$app->match('/', function (Request $request) use ($app) {
        // some default data for when the form is displayed the first time
        $data = array(
            'name' => 'Your name',
            'email' => 'Your email',
        );
        $form = $app['form.factory']->createBuilder(FormType::class, $data)
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->getForm();


        $form->handleRequest($request);

        if ($form->isValid()) {
                $data = $form->getData();

                return $app->redirect('/');
        }

        // display the form
        return $app['twig']->render('index.html.twig', array('form' => $form->createView()));
})->bind('homepage');;

$app->get('/todo/{id}', function ($id) use ($app){
        return $id;
})->bind('new_todo');



$app->run();