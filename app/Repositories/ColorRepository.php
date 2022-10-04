<?php

namespace App\Repositories;
// use App\Models\AuthCustomer;
use App\Models\Color;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


class ColorRepository
{

    public function all()
    {
        return Color::select(['id','name','color'])->get();
    }


     public function store()
     {
        try {

          

            $color= new Color();
            $color->name= request()->name;
           
            $color->color= request()->color;
           
            $color->save();
        
           
            
            
            
            

            if (request()->ajax()) {
                $output = [
                    'success' => true,
                    'data' =>  $color,
                    'path' => '/color',
                    'msg' => __("Color Information Added Success")
                ];
            } else {
                $output = redirect()->back();
            }
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __("messages.something_went_wrong " . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage())
            ];
        }
        return $output;
    }


     public function update($id)
    {
        try {
            $color= Color::findOrFail($id);
            $color->name= request()->name;
           
              $color->color= request()->color;
           
            $color->save();
           
            
            


            if (request()->ajax()) {
                $output = [
                    'success' => true,
                    'data' => '',
                    'path' => '/color',
                    'msg' => __("Color Information Updated Success")
                ];
            } else {
                $output = redirect()->back();
            }
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __("messages.something_went_wrong") . $e->getMessage()
            ];
        }

        return $output;
    }
    public function delete($id)
    {

        try {
             $color = Color::findOrFail($id);
             // $auth = AuthCustomer::where('id',$customer->customer_id)->delete();
             $color->delete();

            $output = [
                'success' => true,
                'msg' => __("Color Deleted Success")
            ];
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            $output = [
                'success' => false,
                'msg' => __("messages.something_went_wrong")
            ];
        }
        return $output;
    }

}
