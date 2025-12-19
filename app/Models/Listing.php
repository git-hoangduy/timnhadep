<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;
    
    // Sử dụng guarded thay vì fillable để linh hoạt hơn
    protected $guarded = [];

    // Constants for status
    const STATUS_PENDING = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_REJECTED = 2;
    const STATUS_EXPIRED = 3;

    // Hoặc dùng fillable nếu muốn rõ ràng hơn
    // protected $fillable = [
    //     'category_id',
    //     'type',
    //     'name',
    //     'slug',
    //     'image',
    //     'excerpt',
    //     'content',
    //     'meta_keywords',
    //     'meta_description',
    //     'status',
    //     'is_highlight',
    //     'price',
    //     'area',
    //     'location',
    //     'customer_id',
    //     'customer_name',
    //     'customer_phone',
    //     'customer_email',
    //     'created_at',
    //     'updated_at'
    // ];

    // Casting các trường
    protected $casts = [
        'status' => 'integer',
        'is_highlight' => 'boolean',
        'category_id' => 'integer',
        'customer_id' => 'integer',
    ];

    // Relationship với category
    public function category()
    {
        return $this->belongsTo(ListingCategory::class, 'category_id');
    }

    // Relationship để lấy ảnh đại diện
    public function avatar()
    {
        return $this->belongsTo(ListingImage::class, 'id', 'listing_id')
                    ->where('is_avatar', 1)
                    ->orderBy('is_avatar', 'desc');
    }

    // Relationship với tất cả images
    public function images()
    {
        return $this->hasMany(ListingImage::class, 'listing_id');
    }

    // Relationship với customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Accessor cho status text
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Chờ duyệt',
            self::STATUS_ACTIVE => 'Đã duyệt',
            self::STATUS_REJECTED => 'Từ chối',
            self::STATUS_EXPIRED => 'Hết hạn',
            default => 'Không xác định',
        };
    }

    // Accessor cho status badge class
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'badge-warning',
            self::STATUS_ACTIVE => 'badge-success',
            self::STATUS_REJECTED => 'badge-danger',
            self::STATUS_EXPIRED => 'badge-secondary',
            default => 'badge-light',
        };
    }

    // Accessor cho type text
    public function getTypeTextAttribute()
    {
        return match($this->type) {
            'sale' => 'Cần bán',
            'rent' => 'Cho thuê',
            'buy' => 'Cần mua',
            'rental' => 'Cần thuê',
            default => 'Không xác định',
        };
    }

    // Accessor cho type badge class
    public function getTypeBadgeAttribute()
    {
        return match($this->type) {
            'sale' => 'badge-danger',
            'rent' => 'badge-warning',
            'buy' => 'badge-success',
            'rental' => 'badge-info',
            default => 'badge-light',
        };
    }

    // Scope cho active listings
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    // Scope cho pending listings
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    // Scope cho listings của customer
    public function scopeByCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    // Scope cho listings theo category
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Scope cho listings theo type
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Method để lấy ảnh đại diện (fallback)
    public function getAvatarImageAttribute()
    {
        // if ($this->image) {
        //     return $this->image;
        // }
        
        if ($this->avatar) {
            return $this->avatar->image;
        }
        
        if ($this->images->count() > 0) {
            return $this->images->first()->image;
        }
        
        return 'uploads/no-image.jpg';
    }

    // Method để format giá
    public function getFormattedPriceAttribute()
    {
        $price = $this->price;
        
        // Nếu giá là số, format
        if (is_numeric($price)) {
            if ($price >= 1000000000) {
                return number_format($price / 1000000000, 1) . ' tỷ';
            } elseif ($price >= 1000000) {
                return number_format($price / 1000000, 1) . ' triệu';
            } else {
                return number_format($price) . ' đồng';
            }
        }
        
        return $price;
    }
}