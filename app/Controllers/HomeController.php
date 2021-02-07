<?php

namespace App\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use MPScholten\GitHubApi\Github;
use Soda\Core\Http\Controller;


class HomeController extends Controller
{

    public function beforeActionExecution($action_name, $action_arguments)
    {
        parent::beforeActionExecution($action_name, $action_arguments);
    }

    function index() {
        return $this->render('home.index');
    }
}