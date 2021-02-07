<?php
namespace App\Controllers\API\V1\User;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Soda\Core\Http\Controller;

class UserController extends Controller
{

    public function beforeActionExecution($action_name, $action_arguments)
    {
        parent::beforeActionExecution($action_name, $action_arguments);
    }

    protected function userStarred($username) {
        $client = new Client([
            'base_uri' => 'https://api.github.com/',
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json'
            ]
        ]);

        $resp = [];

        try {
            $response = $client->get("/users/$username/starred");
            $repositories = json_decode($response->getBody());

            foreach($repositories as $item) {

                $rep = [];
                $rep['rep_id'] = $item->id;
                $rep['rep_name'] = $item->name;
                $rep['rep_description'] = $item->description;
                $rep['rep_url'] = $item->url;
                $rep['language'] = $item->language;

                $resp['data'][] = $rep;

            }

            $resp['status'] = 200;
            $resp['time'] = 1347978941;

            return $this->echoNormal($resp);
        } catch (GuzzleException $e) {
            return $this->echoNormal($e->getMessage());
        }
    }
}