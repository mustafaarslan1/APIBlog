<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\APIController;
use App\Http\Resources\CategoryResource;
use App\Models\ArticleTag;
use App\Models\Category;
use App\Models\CategoryTag;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends APIController
{

    public $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index(Request $request): JsonResponse
    {
        $data = Category::with(['tags','articles'])->withCount(['articles','tags'])->get();

        $data = CategoryResource::collection($data);

        return $this->success([
            'data' => $data
        ]);

    }

    public function add(Request $request): JsonResponse
    {
        $data = $this->request->only('title');

        $validator = Validator::make($data, [
            'title' => 'required|string|min:2|max:100|unique:categories,title'
        ]);

        if ($validator->fails()){
            return $this->error([
                'msg' => 'Hatalı alan',
                'errors' => $validator->errors(),
            ],400);
        }

        $category = new Category();
        $category->title = $data['title'];
        $category->save();

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

                $add_tag_to_category = new CategoryTag();
                $add_tag_to_category->category_id = $category->id;
                $add_tag_to_category->tag_id = $tag->id;
                $add_tag_to_category->save();
            }
        }

        return $this->success([
            'data' => $category
        ]);

    }

    public function update(int $category_id, Request $request): JsonResponse
    {
        $data = $this->request->all();

        $validator = Validator::make($data, [
            'title' => 'required|string|min:2|max:100|unique:categories,title'
        ]);

        if ($validator->fails()){
            return $this->error([
                'msg' => 'Hatalı alan',
                'errors' => $validator->errors(),
            ],400);
        }

        $category = Category::find($category_id);
        $category->update($data);

        return $this->success([
            'data' => $category
        ]);
    }

    public function detail(int $category_id): JsonResponse
    {
        $detail = Category::find($category_id);

        return $this->success([
          'data' => $detail
        ]);
    }

    public function delete(int $category_id, Request $request): JsonResponse
    {
            $category = Category::find($category_id);
            $category->delete();

            return $this->success([
                'data' => $category
            ]);

    }

    public function addTag(): JsonResponse
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

            $add_tag_to_category = new CategoryTag();
            $add_tag_to_category->category_id = $data['category_id'];
            $add_tag_to_category->tag_id = $tag->id;
            $add_tag_to_category->save();
        }

        return $this->success([
            'data' => $data
        ]);
    }

    public function deleteTag($category_tag_id): JsonResponse
    {
        $deleteTag = CategoryTag::find($category_tag_id);
        $deleteTag->delete();

        $data = Tag::find($deleteTag->tag_id);

        return $this->success([
            'data' => $data
        ]);
    }
}
