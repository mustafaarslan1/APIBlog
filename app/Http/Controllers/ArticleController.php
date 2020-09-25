<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\APIController;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends APIController
{
    public $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index(Request $request): JsonResponse
    {
        $data = Article::all();

        //Resourcedan geçirilecek

        return $this->success([
            'data' => $data
        ]);

    }

    public function add(): JsonResponse
    {
        $data = $this->request->only(['title','must','is_active','content']);

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
