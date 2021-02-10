<?php

namespace App\Controllers\API\V1\Repository;


use App\Models\Repository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Soda\Core\Http\Controller;

class RepositoryController extends Controller
{
    public function beforeActionExecution($action_name, $action_arguments)
    {
        parent::beforeActionExecution($action_name, $action_arguments);
    }


    protected function staredRepositories()
    {
        try {
            $username = $this->getRequest()->query->get('user');

            if (is_null($username) || $username == "")
                return $this->echoHttp(
                    [
                        'message' => 'username is required',
                        'status' => 400,
                        'time' => time()
                    ]
                    , 400);

            $client = new Client([
                'base_uri' => 'https://api.github.com/',
                'headers' => [
                    'accept' => 'application/json',
                    'content-type' => 'application/json'
                ]
            ]);

            $response = $client->get("/users/$username/starred?per_page=10");
            $repositories = json_decode($response->getBody());

            $repIds = array_map(function ($object) {
                return $object->id;
            }, $repositories);

            $storedRepositories = Repository::with('tags')
                ->where('user_id', CURRENT_USER_ID)
                ->whereIn('rep_id', $repIds)
                ->get(['id', 'rep_id', 'user_id'])
                ->toArray();

            $data = [];
            foreach ($repositories as &$item) {
                $rep = [];
                $rep_id = $item->id;
                $id = null;

                foreach ($storedRepositories as $storedRepository) {
                    if ($storedRepository['rep_id'] == $rep_id)
                        $id = $storedRepository['id'];
                }

                $rep['id'] = $id;
                $rep['rep_id'] = $rep_id;
                $rep['rep_name'] = $item->name;
                $rep['user_id'] = CURRENT_USER_ID;
                $rep['rep_url'] = $item->url;
                $rep['language'] = $item->language;
                $rep['rep_description'] = $item->description;

                $data[] = $rep;
            }

            Repository::upsert(
                $data,
                ['id']
            );

            return $this->echoNormal(
                [
                    'data' => $data,
                    'message' => count($data) . ' repositories found',
                    'status' => 200,
                    'time' => time()
                ]);
        } catch (GuzzleException $e) {

            return $this->echoHttp(
                [
                    'message' => 'internal server error',
                    'status' => 500,
                    'time' => time()
                ], 500);

        } catch (\Exception $e) {
            return $this->echoHttp(
                [
                    'message' => 'internal server error',
                    'status' => 500,
                    'time' => time()
                ], 500);
        }
    }

    protected function search()
    {
        $q = $this->getRequest()->query->get('search', null);

        try {
            $repositories = Repository::with('tags')
                ->where('user_id', CURRENT_USER_ID)
                ->whereHas('tags', function ($query) use ($q) {
                    $query->where('title', 'like', "%$q%");
                })
                ->get();

            $response = [
                'data' => $repositories,
                'message' => count($repositories) . " repositories found",
                'status' => 200,
                'time' => time()
            ];

            return $this->echoNormal($response);
        } catch (\Exception $e) {
            return $this->echoHttp(
                [
                    'message' => 'internal server error',
                    'status' => 500,
                    'time' => time()
                ], 500);
        }
    }
}