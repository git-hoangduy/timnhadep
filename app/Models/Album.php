<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($employee) {
            if ($employee->code == '') {
                $codeNumber = str_pad($employee->id, 3, '0', STR_PAD_LEFT);
                $employee->code = "[ALBUM-{$codeNumber}]" ;
                $employee->save();
            }
        });
    }

    public function avatar() {
        return $this->belongsTo(AlbumImage::class, 'id', 'album_id')->orderBy('is_avatar', 'desc');
    }

    public function images() {
        return $this->hasMany(AlbumImage::class);
    }
}
