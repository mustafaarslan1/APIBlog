<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\APIController;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleTag;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public function add(Request $request): JsonResponse
    {
        $data = $this->request->all();

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
        if (isset($data['must'])){
            $article->must = $data['must'];
        }else{
            $article->must = 1;
        }


        if(isset($data['is_active'])){
            $article->is_active = $data['is_active'];
        }
        else{
            $article->is_active = 1;
        }
        $article->content = $data['content'];
        $article->user_id = 1; //burası middlewareden sonra düzeltilecek

        if ($request->hasFile('file')){
            $filename = uniqid().'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path('uploads/articles'),$filename);
            $article->file = $filename;
        }

        $article->save();

        if (isset($data['tags'])){
            foreach ($data['tags'] as $t) {
                $find = Tag::where('title',$t)->first();
                if ($find){
                    $tag = Tag::find($find->id);
                }else{
                    $tag = new Tag();
                }
                $tag->title = $t;
                $tag->save();

                $add_tag_to_article = new ArticleTag();
                $add_tag_to_article->article_id = $article->id;
                $add_tag_to_article->tag_id = $tag->id;
                $add_tag_to_article->save();
            }
        }

        if (isset($data['categories'])){
            foreach ($data['categories'] as $c) {
                $find = Category::where('title',$c)->first();
                if ($find){
                    $category = Category::find($find->id);
                }else{
                    $category = new Category();
                }
                $category->title = $c;
                $category->save();

                $add_category_to_article = new ArticleCategory();
                $add_category_to_article->article_id = $article->id;
                $add_category_to_article->category_id = $category->id;
                $add_category_to_article->save();
            }
        }



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

        if ($request->hasFile('file')){
            $file_name=uniqid().'.'.$request->blog_file->getClientOriginalExtension();
            $request->blog_file->move(public_path('uploads/articles'),$file_name);
            $article->update([
                "file" => $file_name,
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

    public function addTag()
    {
        $data = $this->request->all();
        foreach ($data['tags'] as $t) {
            $find = Tag::where('title', $t)->first();
            if ($find){
                $tag = Tag::find($find->id);
            }else{
                $tag = new Tag();
            }
            $tag->title = $t;
            $tag->save();

            $add_tag_to_article = new ArticleTag();
            $add_tag_to_article->article_id = $data['article_id'];
            $add_tag_to_article->tag_id = $tag->id;
            $add_tag_to_article->save();
        }

        return $this->success([
            'data' => $data
        ]);
    }

    public function deleteTag($article_tag_id)
    {
        $deleteTag = ArticleTag::find($article_tag_id);
        $deleteTag->delete();

        $data = Tag::find($deleteTag->tag_id);

        return $this->success([
            'data' => $data
        ]);
    }

    public function addCategory()
    {
        $data = $this->request->all();
        foreach ($data['categories'] as $c) {
            $find = Category::where('title', $c)->first();
            if ($find){
                $category = Category::find($find->id);
            }else{
                $category = new Category();
            }
            $category->title = $c;
            $category->save();

            $add_category_to_article = new ArticleCategory();
            $add_category_to_article->article_id = $data['article_id'];
            $add_category_to_article->category_id = $category->id;
            $add_category_to_article->save();
        }

        return $this->success([
            'data' => $data
        ]);
    }

    public function deleteCategory($article_category_id)
    {
        $deleteCategory = ArticleCategory::find($article_category_id);
        $deleteCategory->delete();

        $data = Category::find($deleteCategory->category_id);

        return $this->success([
            'data' => $data
        ]);
    }
}
