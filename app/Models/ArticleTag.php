<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleTag extends Model
{
    use HasFactory;

    public function articles(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo('App\Models\Article', 'article_id', 'id');
    }
}
