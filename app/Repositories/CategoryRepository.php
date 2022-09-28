<?php

namespace App\Repositories;
use App\Helpers;
use App\Models\Category;
use App\Models\Industry;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

/**
 * Class CategoryRepository.
 */
class CategoryRepository 
{
    public function all(){
        return Category::select(['name', 'short_code','industry_id', 'description', 'id','thumb'])->where('status','=',1)->with('industry');
    }

    public function store()
    {
        try {
            $input = request()->all();
            Auth::guard('web')->check() ? $input['status'] = 1 : $input['status'] = 0;

            if(request()->hasFile('thumb')){
                $image_path = request()->file('thumb')->store('uploads/category/thumb', 'public');
                $input['thumb'] =  $image_path;                 
            }
            if(request()->hasFile('banner')){
                $image_path = request()->file('banner')->store('uploads/category/banner', 'public');
                $input['banner'] =  $image_path;               
            }
            if(request()->hasFile('icon')){
                $image_path = request()->file('icon')->store('uploads/category/icon', 'public');
                $input['icon'] =  $image_path; 
            }
            $input['industry_id'] = request()->input('industry_id');
            $input['created_by'] = Auth::id();

            $category = Category::create($input);
            if(request()->ajax()){
                $output = ['success' => true,
                            'data' => $category,
                            'msg' => __("category.added_success")
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
    public function edit($id){
        return Category::where('id',$id)->with('industry')->first();
    }

    public function update($id){
        try {
            $input = request()->all();

            $category = Category::findOrFail($id);
            $category->name = $input['name'];
            $category->description = $input['description'];
            $category->industry_id = $input['industry_id'];
            $category->short_code = $input['short_code'];
            if(request()->hasFile('thumb')){
                if(($category->thumb != null || $category->thumb != '') &&  $category->thumb != url('uploads/img/default.jpg'))
                    $image_org = str_replace('/storage/','', $category->thumb);
                    if(Storage::exists($image_org)){
                        Storage::delete($image_org);
                    }
                $category->thumb = request()->file('thumb')->store('uploads/category/thumb', 'public');                
            }
            if(request()->hasFile('banner')){
                if(($category->banner != null || $category->banner != '') &&  $category->banner != url('uploads/img/default.jpg'))
                    $image_org = str_replace('/storage/','', $category->banner);
                    if(Storage::exists($image_org)){
                        Storage::delete($image_org);
                    }
                $category->banner = request()->file('banner')->store('uploads/category/banner', 'public'); 
            }
            if(request()->hasFile('icon')){
                if(($category->icon != null || $category->icon != '') &&  $category->icon != url('uploads/img/default.jpg'))
                    $image_org = str_replace('/storage/','', $category->icon);
                    if(Storage::exists($image_org)){
                        Storage::delete($image_org);
                    }
                $category->icon = request()->file('icon')->store('uploads/category/icon', 'public'); 
            }
             $input['industry_id'] = request()->input('industry_id');
            $category->save();
            if(request()->ajax()){
                $output = ['success' => true,
                'data' => '',
                'msg' => __("category.updated_success")
            ];
            }else{
                $output= redirect()->back()->with(['msg' => __("category.updated_success"),'success' => true]);
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
            $category = Category::findOrFail($id);
            $category->status = 0;
            $category->save();
            $output = ['success' => true,
                        'msg' => __("category.deleted_success")
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
