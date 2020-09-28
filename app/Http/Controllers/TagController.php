<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\APIController;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TagController extends APIController
{
    public $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index(Request $request): JsonResponse
    {
        $data = Tag::with(['categories','articles'])->withCount(['articles','categories'])->get();

        $data = TagResource::collection($data);

        return $this->success([
            'data' => $data
        ]);
    }

    public function add(Request $request): JsonResponse
    {
        $data = $this->request->only('title');

        $validator = Validator::make($data, [
            'title' => 'required|string|min:2|max:100'
            ]);

        if ($validator->fails()){
            return $this->error([
                'msg' => 'Hatalı alan',
                'errors' => $validator->errors(),
            ],400);
        }

        $tag = new Tag();
        $tag->title = $data['title'];
        $tag->save();

        return $this->success([
            'data' => $tag
        ]);

    }

    public function update(int $tag_id, Request $request): JsonResponse
    {
        $data = $this->request->only('title');

        $validator = Validator::make($data, [
            'title' => 'string|min:2|max:100'
        ]);

        if ($validator->fails()){
            return $this->error([
                'msg' => 'Hatalı alan',
                'errors' => $validator->errors(),
            ],400);
        }

        $tag = Tag::find($tag_id);
        $tag->update($data);

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
