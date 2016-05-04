<?php

use Silex\Application;
use Silex\Provider\FormServiceProvider;

$app = new Application();

$app['sqlite_path'] = __DIR__.'/db/app.db';

$app['fixtures_manager'] = $app->share(function ($app) {
    return new Todo\DataFixtures\FixturesManager($app);
});
$app->register(new FormServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.domains' => array(),
));
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_sqlite',
        'path'     => __DIR__.'/db/app.db',
    ),
));

$app['repository.task'] = $app->share(function ($app) {
    return new Todo\Repository\TodoRepository($app['db']);
});

if (!file_exists($app['sqlite_path'])) {
    $fixtures = $app['fixtures_manager'];
    $fixtures->resetDatabase();
    $fixtures->populateData();
}
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

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