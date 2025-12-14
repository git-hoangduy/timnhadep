<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category() {
        return $this->belongsTo(ListingCategory::class);
    }

    public function avatar() {
        return $this->belongsTo(ListingImage::class, 'id', 'listing_id')->orderBy('is_avatar', 'desc');
    }

    public function images() {
        return $this->hasMany(ListingImage::class);
    }
}
