<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            "kategori adı" => $this->title,
            "tags" => $this->tags,
            "bu kategoriye ait makale sayısı" => $this->articles_count,
        ];
    }
}
