<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'type', 'post_id', 'project_id'];

    /**
     * Get the post that owns the tag.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the project that owns the tag.
     */
    public function project()
    {
        // Nếu bạn có model Project
        // return $this->belongsTo(Project::class);
        return null;
    }
}