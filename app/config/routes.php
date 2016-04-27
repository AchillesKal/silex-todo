<?php

$app->match('/', 'Todo\Controller\TodoController::listAction')
    ->bind('homepage');

$app->post('/todo', 'Todo\Controller\TodoController::newAction')
    ->bind('new_todo');

$app->get('/todo/{id}', 'Todo\Controller\TodoController::showAction')
    ->bind('show_todo');

$app->match('/todo/{id}/edit', 'Todo\Controller\TodoController::editAction')
    ->bind('edit_todo');

$app->match('/todo/{id}/delete', 'Todo\Controller\TodoController::deleteAction')
    ->bind('delete_todo');

