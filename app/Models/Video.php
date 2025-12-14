<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($employee) {
            if ($employee->code == '') {
                $codeNumber = str_pad($employee->id, 3, '0', STR_PAD_LEFT);
                $employee->code = "[VIDEO-{$codeNumber}]" ;
                $employee->save();
            }
        });
    }
}
