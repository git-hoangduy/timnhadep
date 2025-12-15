<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category() {
        return $this->belongsTo(PostCategory::class);
    }

    public function avatar()
    {
        return $this->hasOne(PostImage::class, 'post_id')
            ->orderByDesc('is_avatar')
            ->orderBy('id');
    }

    public function images() {
        return $this->hasMany(PostImage::class);
    }
}
