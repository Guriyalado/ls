<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function all(){
        return User::select(['id',
                        DB::raw("CONCAT(COALESCE(first_name, ''), ' ', COALESCE(last_name, '')) as name"),'email', 'company_name', 'id', 'status'])->where('role_id','!=',1)->with('user');
    }

    public function store()
    {
        try {
            $input = request()->all();
            $input['password'] = Hash::make('123456');
            $user = User::create($input);
            
            if(request()->ajax()){
                $output = ['success' => true,
                            'data' => $user,
                            'msg' => __("user.added_success")
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
    
}
