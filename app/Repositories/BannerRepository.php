<?php

namespace App\Repositories;
use App\Models\Banner;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller as Controller;
class BannerRepository
{
    public function all(){
        return Banner::select(['title', 'caption', 'url', 'id', 'status','thumb',])->where('status',1)->get();
    }

    public function store()
    {
        try {
            $input = request()->all();
            $input['status'] = request()->input('status');
            if (!empty(request()->input('add_as_type')) &&  request()->input('add_as_type') == 1 && !empty(request()->input('type'))) {
                $input['type'] = request()->input('type');
            }
            if(request()->hasFile('thumb')){
                $image_path = request()->file('thumb')->store('uploads/banner/thumb', 'public');
                $input['thumb'] =  $image_path;  
            }
            if(request()->hasFile('banner')){
                $image_path = request()->file('banner')->store('uploads/banner/banner', 'public');
                $input['banner'] =  $image_path; 
            }
            if(request()->hasFile('icon')){
                $image_path = request()->file('icon')->store('uploads/banner/icon', 'public');
                $input['icon'] =  $image_path; 
            }
            $banner = Banner::create($input);
            if(request()->ajax()){
                $output = ['success' => true,
                            'data' => $banner,
                            'msg' => __("banner.added_success")
                        ];
            }else{
                $output= redirect()->back();
            }
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong ". $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage())
                        ];
        }
        return $output;
    }

    public function update($id){
        try {
            $input = request()->all();
            $banner = Banner::findOrFail($id);
            $banner->title = $input['title'];
            $banner->caption = $input['caption'];
            $banner->page = $input['page'];
            $banner->url = $input['url'];
            $banner->status = request()->input('status');

            if (!empty(request()->input('add_as_type')) &&  request()->input('add_as_type') == '1' && !empty(request()->input('type'))) {
                $banner->type = request()->input('type');
            }
           // $banner->slug=strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\-]/', ' ',request()->name)));
            if(request()->hasFile('thumb')){
                if(($banner->thumb != null || $banner->thumb != '') &&  $banner->thumb != url('uploads/img/default.jpg'))
                        deleteBannerImageInS3($banner->thumb);
                $banner->thumb = uploadBannerImage(request()->file('thumb'),'uploads/banner/thumb');
            }
            if(request()->hasFile('banner')){
                if(($banner->banner != null || $banner->banner != '') &&  $banner->banner != url('uploads/img/default.jpg'))
                        deleteBannerImageInS3($banner->banner);
                $banner->banner =  uploadBannerImage(request()->file('banner'),'uploads/banner/banner');
            }
            if(request()->hasFile('icon')){
                if(($banner->icon != null || $banner->icon != '') &&  $banner->icon != url('uploads/img/default.jpg'))
                deleteBannerImageInS3($banner->icon);
                $banner->icon =  uploadBannerImage(request()->file('icon'),'uploads/banner/icon');
            }
            $banner->save();
            if(request()->ajax()){
                $output = ['success' => true,
                'msg' => __("banner.updated_success")
            ];
            }else{
                $output= redirect()->back()->with(['msg' => __("banner.updated_success"),'success' => true]);
            }
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            $output = ['success' => false,
                        'msg' => __("messages.something_went_wrong")
                    ];
        }
        return $output;
    }

    public function delete($id){

        try {
            $business_id = request()->session()->get('user.business_id');
            $banner = Banner::findOrFail($id);
            if($banner->thumb != null || $banner->thumb == '' )
                deleteBannerImageInS3($banner->thumb);
            if($banner->banner != null || $banner->banner == '')
                deleteBannerImageInS3($banner->banner);
            if($banner->icon != null || $banner->icon == '')
                deleteBannerImageInS3($banner->icon);
            $banner->delete();

            $output = ['success' => true,
                        'msg' => __("banner.deleted_success")
                        ];
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => false,
                        'msg' => __("messages.something_went_wrong")
                    ];
        }

        return $output;
    }
}
