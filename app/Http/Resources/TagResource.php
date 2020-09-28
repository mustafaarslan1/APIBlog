<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "article(s) count" => $this->articles_count,
            "category(s) count" => $this->categories_count,
            "articles" => $this->articles,
            "categories" => $this->categories,
        ];
    }
}
