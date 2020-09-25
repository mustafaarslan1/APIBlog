<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\APIController;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends APIController
{

    public $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index(Request $request): JsonResponse
    {
        $data = Category::with('tags')->withCount('articles')->get();

        $data = CategoryResource::collection($data);

        return $this->success([
            'data' => $data
        ]);

    }

    public function add(Request $request): JsonResponse
    {
        $category = new Category();
        $category->title = $request->title;
        $category->save();

        return $this->success([
            'data' => $category
        ]);

    }

    public function update(int $category_id, Request $request): JsonResponse
    {
        $category = Category::find($category_id);
        $category->title = $request->title;
        $category->save();

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

    public function addTag()
    {

    }

    public function deleteTag()
    {

    }
}
