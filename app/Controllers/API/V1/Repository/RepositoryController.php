<?php

namespace App\Controllers\API\V1\Repository;


use App\Models\Repository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Soda\Core\Http\Controller;

class RepositoryController extends Controller
{
    private $currentUserId = 1;

    public function beforeActionExecution($action_name, $action_arguments)
    {
        parent::beforeActionExecution($action_name, $action_arguments);
    }


    protected function staredRepositories()
    {
        $username = $this->getRequest()->query->get('user');
        if (is_null($username))
            return $this->echoNormal('user is required');

        $client = new Client([
            'base_uri' => 'https://api.github.com/',
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json'
            ]
        ]);

        $resp = [];

        try {
            $response = $client->get("/users/$username/starred?per_page=10");
            $repositories = json_decode($response->getBody());

            $repIds = array_map(function ($object) {
                return $object->id;
            }, $repositories);

            $storedRepositories = Repository::with('tags')
                ->whereIn('rep_id', $repIds)
                ->get(['id', 'rep_id', 'user_id'])
                ->toArray();

            foreach ($repositories as $item) {

                $rep = [];
                $rep['rep_id'] = $item->id;
                $rep['rep_name'] = $item->name;
                $rep['rep_description'] = $item->description;
                $rep['rep_url'] = $item->url;
                $rep['language'] = $item->language;
                $rep['tags'] = array_map(function ($object) use ($item) {
                    if ($object['rep_id'] == $item->id && $object['user_id'] == $this->currentUserId)
                        return $object['tags'];
                    return null;
                }, $storedRepositories);

                $resp['data'][] = $rep;
            }

            $resp['status'] = 200;
            $resp['time'] = 1347978941;

            return $this->echoNormal($resp);
        } catch (GuzzleException $e) {
            return $this->echoNormal($e->getMessage());
        }
    }

    protected function search()
    {
        $q = $this->getRequest()->query->get('search');

        try {
            $repositories = Repository::with('tags')
                ->where('user_id', $this->currentUserId)
                ->whereHas('tags', function ($query) use ($q) {
                    $query->where('title', 'like', "%$q%");
                })
                ->limit(10)
                ->get();

            $response = [
                'data' => $repositories,
                'status' => 200,
                'time' => 16484
            ];

            return $this->echoNormal($response);
        } catch (ModelNotFoundException $e) {
            return $this->echoHttp('no result', 404);
        }
    }
}