<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category() {
        return $this->belongsTo(PageCategory::class);
    }

    public function blocks() {
        return $this->hasMany(PageBlock::class);
    }

    public function avatar() {
        return $this->belongsTo(PageImage::class, 'id', 'post_id')->where('is_avatar', 1);
    }

    public function images() {
        return $this->hasMany(PageImage::class);
    }
}
