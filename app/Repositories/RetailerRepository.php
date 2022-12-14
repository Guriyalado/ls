<?php

namespace App\Repositories;
// use App\Models\AuthCustomer;
use App\Models\Retailer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class RetailerRepository
{

    public function all()
    {
        return Retailer::select(['id','retailer_name','phone_no','email','password','confirm_password'])->get();
    }


     public function store()
     {
        try {

          

            $retailer= new Retailer();
            $retailer->retailer_name= request()->corporate_name;
            $retailer->phone_no= request()->phone_no;
            $retailer->email= request()->email;
            $retailer->password= request()->password;
            $retailer->confirm_password= request()->confirm_password;
           
            $retailer->save();
        
           
            
            
            
            

            if (request()->ajax()) {
                $output = [
                    'success' => true,
                    'data' =>  $retailer,
                    'path' => '/retailer',
                    'msg' => __("Retailer Information Added Success")
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
            $retailer= Retailer::findOrFail($id);
            $retailer->retailer_name= request()->corporate_name;
            $retailer->phone_no= request()->phone_no;
            $retailer->email= request()->email;
            $retailer->password= request()->password;
            $retailer->confirm_password= request()->confirm_password;
           
            $retailer->save();
            
            


            if (request()->ajax()) {
                $output = [
                    'success' => true,
                    'data' => '',
                    'path' => '/retailer',
                    'msg' => __("Retailer Information Updated Success")
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
             $retailer = Retailer::findOrFail($id);
            
             $retailer->delete();

            $output = [
                'success' => true,
                'msg' => __("Retailer Deleted Success")
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
