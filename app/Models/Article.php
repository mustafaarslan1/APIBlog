<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public function users(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany('App\Models\Category', 'article_categories', 'article_id','category_id');
    }

    public function tags(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany('App\Models\Tag', 'article_tags', 'article_id','tag_id');
    }

    protected $fillable = [
        'title',
        'slug',
        'file',
        'must',
        'content',
        'user_id',
        'is_active',
    ];
}
