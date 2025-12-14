<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = ['product_avatar_link'];

    public function category() {
        return $this->belongsTo(ProductCategory::class);
    }

    public function avatar() {
        return $this->belongsTo(ProductImage::class, 'id', 'product_id')->where('is_avatar', 1);
    }

    public function images() {
        return $this->hasMany(ProductImage::class);
    }

    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }

    public function getProductAvatarLinkAttribute(){
        $avatar = ProductImage::where(['product_id' => $this->id])->orderBy('is_avatar', 'DESC')->first();
        $link = asset('uploads/default.png');
        if (!empty($avatar)) {
            $link = asset($avatar->image);
        }
        return $this->attributes['product_avatar_link'] =  $link;
    }
}
