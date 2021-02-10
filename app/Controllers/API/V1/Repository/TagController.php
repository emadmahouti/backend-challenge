<?php

namespace App\Controllers\API\V1\Repository;


use App\Models\Repository;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Soda\Core\Http\Controller;

class TagController extends Controller
{
    public function beforeActionExecution($action_name, $action_arguments)
    {
        parent::beforeActionExecution($action_name, $action_arguments);
    }

    protected function add($id)
    {
        try {
            $data = getJSONInput();
            $tagData = $data['tags'];

            if (!is_null($tagData) && !empty($tagData)) {

                $rep = Repository::where([['id', $id]])->firstOrFail();
                $tags = $rep->tags->toArray();

                $tagTitles = array_map(function ($object) {
                    return $object['title'];
                }, $tags);

                $duplicateValues = $this->duplicateValues(array_merge($tagData, $tagTitles));
                if (count($duplicateValues) > 0)
                    return $this->echoHttp(
                        [
                            'data' => $duplicateValues,
                            'message' => 'duplicate values not allowed',
                            'status' => 400,
                            'time' => time()
                        ], 400);


                if ($rep->user_id != CURRENT_USER_ID)
                    return $this->echoHttp(
                        [
                            'message' => 'not allow to add tag for this repository',
                            'status' => 403,
                            'time' => time()
                        ], 403);

                $temp = [];
                foreach ($tagData as $item) {
                    $tag['rep_id'] = $rep->id;
                    $tag['title'] = $item;

                    $temp[] = $tag;
                }

                Tag::insert($temp);
            }

            return $this->echoHttp(
                [
                    'message' => 'ok',
                    'status' => 201,
                    'time' => time()
                ], 201);
        } catch (ModelNotFoundException $e) {
            return $this->echoHttp(
                [
                    'message' => 'repository not found',
                    'status' => 404,
                    'time' => time()
                ], 404);
        } catch (\Exception $e) {
            return $this->echoHttp(
                [
                    'message' => 'internal server error',
                    'status' => 500,
                    'time' => time()
                ], 500);
        }
    }

    protected function edit($rep_id, $tag_id)
    {
        try {
            $data = getJSONInput();
            $newTitle = $data['title'];

            if (is_null($newTitle) || empty($newTitle))
                return $this->echoHttp(
                    [
                        'message' => 'username is required',
                        'status' => 400,
                        'time' => time()
                    ], 400);

            $tag = Tag::where([['id', $tag_id], ['rep_id', $rep_id]])->firstOrFail();
            $rep = $tag->repository;

            if ($rep->user_id != CURRENT_USER_ID)
                return $this->echoHttp(
                    [
                        'message' => 'not allow to edit this tag',
                        'status' => 403,
                        'time' => time()
                    ], 403);

            unset($tag->repository);

            $oldTitle = $tag->title;
            $tag->title = $newTitle;
            $tag->save();

            return $this->echoNormal(
                [
                    'data' => $tag,
                    'message' => "$oldTitle renamed to $newTitle",
                    'status' => 200,
                    'time' => time()
                ]);

        } catch (ModelNotFoundException  $e) {
            return $this->echoHttp(
                [
                    'message' => 'tag not found',
                    'status' => 400,
                    'time' => time()
                ], 404);
        } catch (\Exception $e) {
            return $this->echoHttp(
                [
                    'message' => 'internal server error',
                    'status' => 500,
                    'time' => time()
                ], 500);
        }
    }

    protected function delete($rep_id, $tag_id)
    {
        try {
            $tag = Tag::where([['id', $tag_id], ['rep_id', $rep_id]])->firstOrFail();
            $rep = $tag->repository;

            if ($rep->user_id != CURRENT_USER_ID)
                return $this->echoHttp(
                    [
                        'message' => 'not allow to delete this tag',
                        'status' => 403,
                        'time' => time()
                    ],
                    403);


            $tag->delete();

            return $this->echoNormal(
                [
                    'message' => 'ok',
                    'status' => 200,
                    'time' => time()
                ]);

        } catch (ModelNotFoundException  $e) {
            return $this->echoHttp(
                [
                    'message' => 'tag not found',
                    'status' => 404,
                    'time' => time()
                ], 404);
        } catch (\Exception $e) {
            return $this->echoHttp(
                [
                    'message' => 'internal server error',
                    'status' => 500,
                    'time' => time()
                ],
                500);
        }
    }
}