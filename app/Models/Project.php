<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category() {
        return $this->belongsTo(ProjectCategory::class);
    }

    public function blocks() {
        return $this->hasMany(ProjectBlock::class);
    }

    public function avatar()
    {
        return $this->hasOne(ProjectImage::class, 'project_id')
            ->orderByDesc('is_avatar')
            ->orderBy('id');
    }

    public function images() {
        return $this->hasMany(ProjectImage::class);
    }
}
