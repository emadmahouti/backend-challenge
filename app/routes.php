<?php

use Phroute\Phroute\RouteCollector;

$router = new RouteCollector();

/**
 * Define your routes after this comment!
 */

$router->get('/', ['App\Controllers\HomeController', 'index']);

$router->group(['prefix' => 'api/'], function ($router) {
    $router->group(['prefix' => '/v1'], function ($router) {

        $router->group(['prefix' => '/repository/{rep_id}?'], function ($router) {
            $router->get('/user-starred', ['App\Controllers\API\V1\Repository\RepositoryController', 'staredRepositories']);
            $router->get('/', ['App\Controllers\API\V1\Repository\RepositoryController', 'search']);

            $router->group(['prefix' => '/tag'], function($router){
                $router->get('/', ['App\Controllers\API\V1\Repository\TagController', 'index']);
                $router->post('/add', ['App\Controllers\API\V1\Repository\TagController', 'add']);
                $router->post('/edit/{tag_id}', ['App\Controllers\API\V1\Repository\TagController', 'edit']);
                $router->get('/delete/{tag_id}', ['App\Controllers\API\V1\Repository\TagController', 'delete']);
            });
        });


        $router->group(['prefix' => '/user/{username}'], function ($router) {
            $router->group(['prefix' => '/user-starred'], function($router){
                $router->get('/', ['App\Controllers\API\V1\User\UserController', 'userStarred']);
            });
        });
    });
});