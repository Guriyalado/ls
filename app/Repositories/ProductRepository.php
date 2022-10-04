<?php

namespace App\Repositories;
// use App\Models\AuthCustomer;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;


class ProductRepository
{

    public function all()
    {
        return Product::select(['id','product_category','product_industry','product_name','product_price','product_size','product_descreption','color','use_case','discount','total_price'])->get();
    }


     public function store()
     {
        try {

          

            $product= new Product();
            $product->product_category= request()->product_category;
            $product->product_industry= request()->product_industry;
            $product->product_name= request()->product_name;
            $product->product_price= request()->product_price;
            $product->product_size= request()->product_size;
            $product->product_descreption= request()->product_descreption;
            $product->color= request()->color;
            $product->use_case= request()->use_case;
            $product->discount= request()->discount;
            $product->total_price= request()->total_price;
            $product->save();
        
           
            
            
            
            

            if (request()->ajax()) {
                $output = [
                    'success' => true,
                    'data' =>  $product,
                    'path' => '/product',
                    'msg' => __("Product Information Added Success")
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
            $product= Product::findOrFail($id);
            $product->product_category= request()->product_category;
            $product->product_industry= request()->product_industry;
            $product->product_name= request()->product_name;
            $product->product_price= request()->product_price;
            $product->product_size= request()->product_size;
            $product->product_descreption= request()->product_descreption;
            $product->color= request()->color;
            $product->use_case= request()->use_case;
            $product->discount= request()->discount;
            $product->total_price= request()->total_price;
            $product->save();
        
            
            


            if (request()->ajax()) {
                $output = [
                    'success' => true,
                    'data' => '',
                    'path' => '/product',
                    'msg' => __("Product Information Updated Success")
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
             $product = Product::findOrFail($id);
             // $auth = AuthCustomer::where('id',$customer->customer_id)->delete();
             $product->delete();

            $output = [
                'success' => true,
                'msg' => __("Product Deleted Success")
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
