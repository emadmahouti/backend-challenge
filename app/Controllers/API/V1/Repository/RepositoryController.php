<?php

namespace App\Controllers\API\V1\Repository;


use App\Models\Repository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Soda\Core\Http\Controller;

class RepositoryController extends Controller
{
    private $currentUserId = 1;
    public function beforeActionExecution($action_name, $action_arguments)
    {
        parent::beforeActionExecution($action_name, $action_arguments);
    }

    protected function search() {
        $q = $this->getRequest()->query->get('search');

        try {
            $repositories = Repository::with('tags')
                ->where('user_id', $this->currentUserId)
                ->whereHas('tags', function($query) use ($q){
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
        }catch (ModelNotFoundException $e) {
            return $this->echoHttp('no result', 404);
        }
    }
}