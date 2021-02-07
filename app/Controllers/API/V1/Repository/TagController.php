<?php

namespace App\Controllers\API\V1\Repository;


use App\Models\Repository;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Soda\Core\Http\Controller;

class TagController extends Controller
{
    private $currentUserId = 1;
    public function beforeActionExecution($action_name, $action_arguments)
    {
        parent::beforeActionExecution($action_name, $action_arguments);
    }

    protected function index($rep_id) {

    }

    protected function add() {
        $data = getJSONInput();
        $repositoryData = $data['repository'];
        $tagsData = $repositoryData['tags'];

        if(!is_null($repositoryData) && !is_null($tagsData)) {

            $rep = Repository::where('rep_id', $repositoryData['rep_id'])->first();

            if($rep == null) {
                $rep = new Repository();
                $rep->user_id = $this->currentUserId;
                $rep->fill($repositoryData);
                $rep->save();
            }
            $repId = $rep->id;

            foreach($tagsData as &$tag) {
                if($tag['title'] == '' || is_null($tag['title']))
                    continue;

                $tag['rep_id'] = $repId;
            }

            Tag::insert($tagsData);
        }
    }

    protected function edit($rep_id, $tag_id) {
        $data = getJSONInput();
        $newTitle = $data['title'];

        if(is_null($newTitle))
            return $this->echoHttp('title required', 400);

        try {
            $tag = Tag::where('id', $tag_id)->firstOrFail();
            $rep = $tag->repository;

            if($rep->rep_id != $rep_id || $rep->user_id != $this->currentUserId)
                return $this->echoHttp('not allowed to edit tag', 403);


            $tag->title = $newTitle;
            $tag->save();

        }catch (ModelNotFoundException  $e) {
            return $this->echoHttp('not found', 404);
        }

        return $this->echoNormal('done');
    }

    protected function delete($rep_id, $tag_id) {
        try {
            $tag = Tag::where('id', $tag_id)->firstOrFail();
            $rep = $tag->repository;

            if($rep->rep_id != $rep_id || $rep->user_id != $this->currentUserId)
                return $this->echoHttp('not allowed to delete tag', 403);


            $tag->active = false;
            $tag->save();

        }catch (ModelNotFoundException  $e) {
            return $this->echoHttp('not found', 404);
        }

        return $this->echoNormal('done');
    }
}