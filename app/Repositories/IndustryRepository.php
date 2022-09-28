<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Industry;

/**
 * Class IndustryRepository.
 */
class IndustryRepository 
{
    /**
     * @return string
     *  Return the model
     */
    public function all(){
        return Industry::select(['name', 'thumb','icon', 'banner', 'id', 'status'])->where('status','!=',0)->with('industry');
    }
    public function store()
    {
        try {
            $input = request()->all();
            //dd($input);
            Auth::guard('web')->check() ? $input['status'] = 1 : $input['status'] = 0;

            if(request()->hasFile('thumb')){
                $image_path = request()->file('thumb')->store('uploads/industry/thumb', 'public');
                $input['thumb'] =  $image_path;                
            }
            if(request()->hasFile('banner')){
                $image_path = request()->file('banner')->store('uploads/industry/banner', 'public');
                $input['banner'] =  $image_path;
            }
            if(request()->hasFile('icon')){
                $image_path = request()->file('icon')->store('uploads/industry/icon', 'public');
                $input['icon'] =  $image_path;
            }
            $input['created_by'] = Auth::id();
            //dd($input);
            $industry = Industry::create($input);
            
            if(request()->ajax()){
                $output = ['success' => true,
                            'data' => $industry,
                            'msg' => __("industry.added_success")
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
        //return Industry::where('id',$id)->first();
    }

    public function update($id){
        try {
            $input = request()->all();
            //dd($input);
            $industry = Industry::findOrFail($id);
            $industry->name = $input['name'];
            if(request()->hasFile('thumb')){
                if(($industry->thumb != null || $industry->thumb != '') &&  $industry->thumb != url('uploads/img/default.jpg'))
                    $image_org = str_replace('/storage/','', $industry->thumb);
                    if(Storage::exists($image_org)){
                        Storage::delete($image_org);
                    }
                $industry->thumb = request()->file('thumb')->store('uploads/industry/thumb', 'public');
            }
            if(request()->hasFile('banner')){
                if(($industry->banner != null || $industry->banner != '') &&  $industry->banner != url('uploads/img/default.jpg'))
                    $image_org = str_replace('/storage/','', $industry->banner);
                    if(Storage::exists($image_org)){
                        Storage::delete($image_org);
                    }
                $industry->banner = request()->file('banner')->store('uploads/industry/banner', 'public');               
            }
            if(request()->hasFile('icon')){
                if(($industry->icon != null || $industry->icon != '') &&  $industry->icon != url('uploads/img/default.jpg'))
                    $image_org = str_replace('/storage/','', $industry->icon);
                    if(Storage::exists($image_org)){
                        Storage::delete($image_org);
                    }
                $industry->icon = request()->file('icon')->store('uploads/industry/icon', 'public');               
            }
            $industry->save();
            if(request()->ajax()){
                $output = ['success' => true,
                'data' => '',
                'msg' => __("industry.updated_success")
            ];
            }else{
                $output= redirect()->back()->with(['msg' => __("industry.updated_success"),'success' => true]);
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
            $industry = Industry::findOrFail($id);
            $industry->status = 0;
            $industry->save();
            $output = ['success' => true,
                        'msg' => __("industry.deleted_success")
                        ];
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => false,
                        'msg' => __("messages.something_went_wrong")
                    ];
        }

        return $output;
    }

    protected function uploadImage($img,$path,$width=120,$height=75,$multiple = false){
        $name=time().$img->getClientOriginalName();
        $image = Image::make($img)->resize($width, $height);
        $imgName = $name;
        $img->move(public_path('images'), $imgName);
        //$img->storeAs($path, $imgName);
        
        // if($multiple){
        //     $this->uploadMultiple($img,$path,300,400,$name);
        //     $this->uploadMultiple($img,$path,400,500,$name);
        // }
        return $imgName;
    }

    protected function uploadMultiple($img,$path,$width=200,$height=200,$name){
        $image = Image::make($img)->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        
        Storage::disk('public')->put($path.'/'.$name.'_'.$height.'X'.$height.'.jpg',$image,'public');
        
        return $path.'/'.$name.'_'.$height.'X'.$height.'.jpg';
    }
}
