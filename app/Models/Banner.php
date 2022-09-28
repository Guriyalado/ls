<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'title',
        'icon',
        'thumb',
        'banner',
        'url',
        'caption',
        'page',
        'type',
        'status',
    ];
    public function getThumbAttribute($value)
    {
        # code...

        if (!empty($value)) {
             $image_url =Storage::disk('local')->url($value);
        } else {
             $image_url = url('uploads/img/default.jpg');
         }
        return $image_url;
    }
    public function getIconAttribute($value)
    {
        # code...

        if (!empty($value)) {
            $image_url =Storage::disk('local')->url($value);
       } else {
            $image_url = url('uploads/img/default.jpg');
        }
       return $image_url;
    }



    public function getBannerAttribute($value)
    {
        # code...

        if (!empty($value)) {
            $image_url =Storage::disk('local')->url($value);
       } else {
            $image_url = url('uploads/img/default.jpg');
        }
       return $image_url;
    }
}
