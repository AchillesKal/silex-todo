<?php

use Silex\Application;
use Silex\Provider\FormServiceProvider;

$app = new Application();

$app['debug'] = true;

$app->register(new FormServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.domains' => array(),
));
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array (
        'driver'    => 'pdo_mysql',
        'host'      => 'localhost',
        'dbname'    => 'silextodo_db',
        'user'      => 'root',
        'password'  => '',
        'charset'   => 'utf8mb4',
        )
));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app['repository.task'] = $app->share(function ($app) {
    return new Todo\Repository\TodoRepository($app['db']);
});

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/logs.log',
));
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../app/views',
));

$app['task.counter'] = $app->share(function ($app) {
    return new \Todo\Utils\TaskCounter($app['session']);
});

require 'config/routes.php';

return $app;