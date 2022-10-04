<?php

namespace App\Repositories;
// use App\Models\AuthCustomer;
use App\Models\Corporate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class CorporateRepository
{

    public function all()
    {
        return Corporate::select(['id','corporate_name','phone_no','email','password','confirm_password','company_address','company_name'])->get();
    }


     public function store()
     {
        try {

          

            $corporate= new Corporate();
            $corporate->corporate_name= request()->corporate_name;
            $corporate->phone_no= request()->phone_no;
            $corporate->email= request()->email;
            $corporate->password= request()->password;
            $corporate->confirm_password= request()->confirm_password;
            $corporate->company_name= request()->company_name;
            $corporate->company_address= request()->company_address;
            $corporate->save();
        
           
            
            
            
            

            if (request()->ajax()) {
                $output = [
                    'success' => true,
                    'data' =>  $corporate,
                    'path' => '/corporate',
                    'msg' => __("Corporate Information Added Success")
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
            $corporate= Corporate::findOrFail($id);
            $corporate->corporate_name= request()->corporate_name;
            $corporate->phone_no= request()->phone_no;
            $corporate->email= request()->email;
            $corporate->password= request()->password;
            $corporate->confirm_password= request()->confirm_password;
            $corporate->company_name= request()->company_name;
            $corporate->company_address= request()->company_address;
        
           
            
            
            
            $corporate->save();
            
            


            if (request()->ajax()) {
                $output = [
                    'success' => true,
                    'data' => '',
                    'path' => '/corporate',
                    'msg' => __("Corporate Information Updated Success")
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
             $corporate = Corporate::findOrFail($id);
             // $auth = AuthCustomer::where('id',$customer->customer_id)->delete();
             $corporate->delete();

            $output = [
                'success' => true,
                'msg' => __("Corporate Deleted Success")
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
