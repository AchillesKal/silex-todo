<?php

$app->match('/', 'Todo\Controller\TodoController::listAction')
    ->bind('homepage');

$app->get('/todo/{id}', 'Todo\Controller\TodoController::showAction')
    ->bind('show_todo');

$app->match('/todo/{id}/edit', 'Todo\Controller\TodoController::editAction')
    ->bind('edit_todo');

$app->match('/todo/{id}/delete', 'Todo\Controller\TodoController::deleteAction')
    ->bind('delete_todo');

$app->match('/about', 'Todo\Controller\TodoController::aboutAction')
    ->bind('about');

