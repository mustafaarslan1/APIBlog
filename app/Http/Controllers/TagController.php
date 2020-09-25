<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\APIController;
use App\Http\Resources\CategoryResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends APIController
{
    public $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index(Request $request): JsonResponse
    {
        $data = Tag::withCount('articles')->get();

        //Resourcedan geçirilecek

        return $this->success([
            'data' => $data
        ]);

    }

    public function add(Request $request): JsonResponse
    {
        $tag = new Tag();
        $tag->title = $request->title;
        $tag->save();

        return $this->success([
            'data' => $tag
        ]);

    }

    public function update(int $tag_id, Request $request): JsonResponse
    {
        $tag = Tag::find($tag_id);
        $tag->title = $request->title;
        $tag->save();

        return $this->success([
            'data' => $tag
        ]);
    }

    public function detail(int $tag_id): JsonResponse
    {
        $detail = Tag::find($tag_id);

        return $this->success([
            'data' => $detail
        ]);
    }

    public function delete(int $tag_id, Request $request): JsonResponse
    {
        $tag = Tag::find($tag_id);
        $tag->delete();

        return $this->success([
            'data' => $tag
        ]);

    }
}
