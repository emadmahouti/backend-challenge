<?php

use Phroute\Phroute\RouteCollector;

$router = new RouteCollector();

/**
 * Define your routes after this comment!
 */

$router->get('/', ['App\Controllers\HomeController', 'index']);

$router->group(['prefix' => 'api/'], function ($router) {
    $router->group(['prefix' => '/v1'], function ($router) {

        $router->group(['prefix' => '/repository'], function ($router) {
            $router->get('/user-starred', ['App\Controllers\API\V1\Repository\RepositoryController', 'staredRepositories']);
            $router->get('/', ['App\Controllers\API\V1\Repository\RepositoryController', 'search']);

            $router->group(['prefix' => '/{rep_id}/tag'], function($router){
                $router->post('/', ['App\Controllers\API\V1\Repository\TagController', 'add']);
                $router->put('/{tag_id}', ['App\Controllers\API\V1\Repository\TagController', 'edit']);
                $router->delete('/{tag_id}', ['App\Controllers\API\V1\Repository\TagController', 'delete']);
            });
        });
    });
});