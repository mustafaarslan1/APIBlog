<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public function articles(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany('App\Models\ArticleTag');
    }

    protected $fillable = [
        'title'
    ];
}
