<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'icon',
        'thumb',
        'banner',
        'industry_id',
        'short_code',
        'description',
        'status',
        'created_by',
    ];

    public function category() {
        return $this->hasOne('App\Models\Category','id');

    }


    public function industry() {
        return $this->belongsTo('\App\Models\Industry');
    }
    /**
     * Combines Category and sub-category
     *
     * @param int $business_id
     * @return array
     */
    public function getThumbAttribute($value)
    {
        # code...

        if (!empty($value)) {
            $image_url =Storage::disk('local')->url($value);
         } else {
            $image_url = url('app/uploads/img/default.jpg');
        }
       return $image_url;

    }
    public function getIconAttribute($value)
    {
        # code...

        if (!empty($value)) {
            $image_url =Storage::disk('local')->url($value);
         } else {
            $image_url = url('uploads/industry/icon/default.jpg');
        }
       return $image_url;
    }

    public function getBannerAttribute($value){
        # code...

        if (!empty($value)) {
            $image_url =Storage::disk('local')->url($value);
         } else {
            $image_url = url('uploads/img/default.jpg');
        }
       return $image_url;
    }
}
