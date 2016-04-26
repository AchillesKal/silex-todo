<?php

$app->match('/', 'Todo\Controller\TodoController::listAction')
    ->bind('homepage');

$app->get('/todo/{id}', 'Todo\Controller\TodoController::showAction')
    ->bind('show_todo');

$app->post('/todo', 'Todo\Controller\TodoController::newAction')
    ->bind('new_todo');
