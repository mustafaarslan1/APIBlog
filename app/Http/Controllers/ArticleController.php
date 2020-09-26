<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\APIController;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Nullable;

class ArticleController extends APIController
{
    public $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index(Request $request): JsonResponse
    {

        $data = Article::with(['tags','users','categories'])->get();

        $data = ArticleResource::collection($data);

        return $this->success([
            'data' => $data
        ]);

    }

    public function add(): JsonResponse
    {
        $data = $this->request->only(['title','must','is_active','content']);

        $validator = Validator::make($data,[
           'title' => 'required|string|min:3|max:300',
           'must' => 'nullable|numeric',
           'is_active' => 'nullable',
           'content' => 'required',
           'file' => 'nullable|image|mimes:jpg,jpeg,png|max:4096'

        ]);

        if ($validator->fails()){
            return $this->error([
                'msg' => 'Hatalı alan',
                'errors' => $validator->errors(),
            ],400);
        }

        $article = new Article();
        $article->title = $data['title'];
        $article->slug = Str::slug($data['title']);
        $article->must = $data['must'];

        if(isset($data['is_active'])){
            $article->is_active = $data['is_active'];
        }
        else{
            $article->is_active = 1;
        }
        $article->content = $data['content'];
        $article->user_id = 1; //burası middlewareden sonra düzeltilecek

        $article->save();

        return $this->success([
            'data' => $article
        ]);

    }

    public function update(int $article_id, Request $request): JsonResponse
    {
        $data = $this->request->all();

        $validator = Validator::make($data,[
            'title' => 'string|min:3|max:300',
            'must' => 'nullable|numeric',
            'is_active' => 'nullable',
            'file' => 'nullable|image|mimes:jpg,jpeg,png|max:4096'

        ]);

        if ($validator->fails()){
            return $this->error([
                'msg' => 'Hatalı alan',
                'errors' => $validator->errors(),
            ],400);
        }



        $article = Article::find($article_id);

        $article->update($data);

        if (isset($data['title'])){
            $slug = Str::slug($data['title']);
            $article->update([
                "slug" => $slug
            ]);
        }

        return $this->success([
            'data' => $article
        ]);
    }

    public function detail(int $article_id): JsonResponse
    {
        $detail = Article::find($article_id);

        return $this->success([
            'data' => $detail
        ]);
    }

    public function delete(int $article_id, Request $request): JsonResponse
    {
        $article = Article::find($article_id);
        $article->delete();

        return $this->success([
            'data' => $article
        ]);

    }
}
