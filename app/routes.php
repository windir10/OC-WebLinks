<?php

// Home page
$app->get('/', 'WebLinks\Controller\HomeController::indexAction')
->bind('home');

// Login form
$app->get('/login', "WebLinks\Controller\HomeController::loginAction")
->bind('login');

// Submit link
$app->match('/link/submit', "WebLinks\Controller\HomeController::submitLinkAction")
->bind('submitlink');

// Admin : Homepage
$app->get('/admin', "WebLinks\Controller\AdminController::indexAction")
->bind('admin');

// Admin : Add a new link
$app->match('/admin/link/add', "WebLinks\Controller\AdminController::addLinkAction")
->bind('admin_link_add');

// Admin : Edit an existing link
$app->match('/admin/link/{id}/edit', "WebLinks\Controller\AdminController::editLinkAction")
->bind('admin_link_edit');

// Admin : Remove a link
$app->get('/admin/link/{id}/delete', "WebLinks\Controller\AdminController::deleteLinkAction")
->bind('admin_link_delete');

// Admin : Add a user
$app->match('/admin/user/add', "WebLinks\Controller\AdminController::addUserAction")
->bind('admin_user_add');

// Admin : Edit an existing user
$app->match('/admin/user/{id}/edit', "WebLinks\Controller\AdminController::editUserAction")
->bind('admin_user_edit');

// Admin : Remove a user
$app->get('/admin/user/{id}/delete', "WebLinks\Controller\AdminController::deleteUserAction")
->bind('admin_user_delete');

// API : get all links
$app->get('/api/links', "WebLinks\Controller\ApiController::getLinksAction")
->bind('api_links');

// API : get a link by id
$app->get('/api/link/{id}', "WebLinks\Controller\ApiController::getLinkAction")
->bind('api_article');
