<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user() {
        return $this->hasOne(Customer::class, 'id', 'user_id');
    }

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
