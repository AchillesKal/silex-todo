<?php

$app->match('/', 'Todo\Controller\DefaultController::indexAction')
    ->bind('homepage');

$app->get('/todo/{id}', function ($id) use ($app){
    return $id;
})->bind('new_todo');