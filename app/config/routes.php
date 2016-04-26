<?php

$app->match('/', 'Todo\Controller\DefaultController::indexAction')
    ->bind('homepage');

$app->get('/todo/{id}', 'Todo\Controller\DefaultController::showAction')
    ->bind('show_todo');