<?php

namespace App\Repositories;
// use App\Models\AuthCustomer;
use App\Models\Size;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


class SizeRepository
{

    public function all()
    {
        return Size::select(['id','size'])->get();
    }


     public function store()
     {
        try {

          

            $size= new Size();
            $size->size= request()->size;
           
            $size->save();
        
           
            
            
            
            

            if (request()->ajax()) {
                $output = [
                    'success' => true,
                    'data' =>  $size,
                    'path' => '/size',
                    'msg' => __("Size Information Added Success")
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
            $size= Size::findOrFail($id);
              $size->size= request()->size;
           
            $size->save();
           
            
            


            if (request()->ajax()) {
                $output = [
                    'success' => true,
                    'data' => '',
                    'path' => '/size',
                    'msg' => __("Size Information Updated Success")
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
             $size = Size::findOrFail($id);
             // $auth = AuthCustomer::where('id',$customer->customer_id)->delete();
             $size->delete();

            $output = [
                'success' => true,
                'msg' => __("Size Deleted Success")
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
