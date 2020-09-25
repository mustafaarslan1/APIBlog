<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    public function tags(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany('App\Models\CategoryTag');
    }

    public function articles(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany('App\Models\ArticleCategory');
    }
}
