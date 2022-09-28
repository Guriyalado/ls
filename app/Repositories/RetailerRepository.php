<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Retailer;

/**
 * Class IndustryRepository.
 */
class RetailerRepository 
{
    /**
     * @return string
     *  Return the model
     */
    public function all(){
        return Retailer::select(['retailer_name', 'phone_no','email', 'password','confirm_password', 'id', 'status'])->where('status','!=',0)->with('retailer');
    }
    public function store()
    {
        try {
            $input = request()->all();
            //dd($input);
            Auth::guard('web')->check() ? $input['status'] = 1 : $input['status'] = 0;

           
            $input['created_by'] = Auth::id();
            //dd($input);
            $retailer = Retailer::create($input);
            
            if(request()->ajax()){
                $output = ['success' => true,
                            'data' => $retailer,
                            'msg' => __("retailer.added_success")
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
            $retailer = Retailer::findOrFail($id);
            $retailer->retailer_name = $input['retailer_name'];
            
            $industry->save();
            if(request()->ajax()){
                $output = ['success' => true,
                'data' => '',
                'msg' => __("retailer.updated_success")
            ];
            }else{
                $output= redirect()->back()->with(['msg' => __("retailer.updated_success"),'success' => true]);
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
            $retailer = Retailer::findOrFail($id);
            $retailer->status = 0;
            $retailer->save();
            $output = ['success' => true,
                        'msg' => __("retailer.deleted_success")
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
