<?php

// Home page
$app->get('/', 'WebLinks\Controller\HomeController::indexAction')->bind('home');
