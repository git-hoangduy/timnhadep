<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function parent() {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(static::class, 'parent_id')->where('status', 1)->orderBy('id', 'desc');
    }

    public function childrenIds($lv1 = null) {
        
        if(!$lv1) {
            $lv1 = $this;
        }

        $ids = [];
        if (!empty($lv1)) {
            array_push($ids, $lv1->id);
            if($lv1->children->count()) {
                foreach($lv1->children as $lv2) {
                    array_push($ids, $lv2->id);
                    if ($lv2->children->count()) {
                        foreach($lv2->children as $lv3) {
                            array_push($ids, $lv3->id);
                        }
                    }
                }
            }
        }

        return $ids;
    }

    public function projects() {
        return $this->hasMany(Project::class, 'category_id', 'id')->orderBy('id', 'asc');
    }
}
