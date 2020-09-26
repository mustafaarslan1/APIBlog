<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       /* $tags = $this->tags;

        $tag_id = null;

        foreach ($tags as $tag){
           $tag_id = $tag->tag_id;
        };*/

        return [
            "id" => $this->id,
            "title" => $this->title,
            "slug" => $this->slug,
            "must" => $this->must,
            "file" => $this->file ? Storage::url('uploads/articles').$this->file : '',
            "content" => $this->content,
            "user_id" => $this->user_id,
            "is_active" => $this->is_active=='1' ? 'Aktif' : 'Pasif',
            "created_at" => Carbon::parse($this->created_at)->formatLocalized('%d %B %Y'),
            "updated_at" => Carbon::parse($this->updated_at)->formatLocalized('%d %B %Y'),
            "tags" => $this->tags,
            "categories" => $this->categories,
            "users" => $this->users

        ];
    }
}
