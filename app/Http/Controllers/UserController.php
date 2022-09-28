<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use Yajra\DataTables\DataTables;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
        return $this->user->all();
        $this->middleware('auth');
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create','store', 'updateStatus']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['delete']]);
    }


    /**
     * List User 
     * @param Nill
     * @return Array $user
     */

    public function index()
    {       
        if (request()->ajax()) {

            return Datatables::of($this->user->all())
                
                ->addColumn('action', function ($row) {
                        $btn = '<div style="display: flex">';
                        if ($row->status == 0){
                            $btn =  $btn.'<a href="'.route("users.status", ["user_id" => $row->id, "status" => 1]).'"
                                        class="btn btn-success m-2">
                                        <i class="fa fa-check"></i>
                                    </a>';
                        }else{
                            $btn =  $btn.'<a href="'.route("users.status", ["user_id" => $row->id, "status" => 0]).'" class="btn btn-danger m-2"> <i class="fa fa-ban"></i></a>';
                        }
                        
                        $btn =  $btn.'<a href="'.route("users.edit", ["user" => $row->id]).'"
                                    class="btn btn-primary m-2">
                                    <i class="fa fa-pen"></i>
                                </a>';

                        /*$btn =  $btn.'<a class="btn btn-danger delete_button m-2" href="'.route('users.destroy', ['user' => $row->id]).'" data-toggle="modal" data-target="#deleteModal">
                                    <i class="fas fa-trash"></i>
                                </a>';*/

                        $btn = $btn.'</div>';
                    return $btn;
                })
                ->editColumn('status', function($row) {
                    if($row->status == 0){
                        return '<span class="badge badge-danger">Inactive</span>';
                    }else{
                        return '<span class="badge badge-success">Active</span>';
                    }
                })
                ->editColumn('name', function ($row) {
                    return  $row->name;
                })
                ->editColumn('email', function ($row) {

                    return  $row->email;
                })
                ->editColumn('company_name', function ($row) {

                    return  $row->company_name;
                })
                ->removeColumn('id')
                ->rawColumns(['action', 'name','email','company_name','status'])
                ->make(true);
        }
        return view('users.index');
    }

    /**
     * Create User 
     * @param Nill
     * @return Array $user
     */
    public function create()
    {
        return view('users.add');
    }

    /**
     * Store User
     * @param Request $request
     * @return View Users
     */
    public function store(CreateUserRequest $request)
    {
         # code...
         if (Auth::guard('web')->check()) {
            if (!Auth::guard('web')->user()->can('industry-create')) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            if (!Auth::guard('seller')->user()->can('industry-create')) {
                abort(403, 'Unauthorized action.');
            }
        }
        //dd($this->industry->store());
        return $this->user->store();
    }

    /**
     * Update Status Of User
     * @param Integer $status
     * @return List Page With Success
     */
    public function updateStatus($user_id, $status)
    {
        // Validation
        $validate = Validator::make([
            'user_id'   => $user_id,
            'status'    => $status
        ], [
            'user_id'   =>  'required|exists:users,id',
            'status'    =>  'required|in:0,1',
        ]);

        // If Validations Fails
        if($validate->fails()){
            return redirect()->route('users.index')->with('error', $validate->errors()->first());
        }

        try {
            DB::beginTransaction();

            // Update Status
            User::whereId($user_id)->update(['status' => $status]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('users.index')->with('success','User Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Edit User
     * @param Integer $user
     * @return Collection $user
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit')->with([
            'roles' => $roles,
            'user'  => $user
        ]);
    }

    /**
     * Update User
     * @param Request $request, User $user
     * @return View Users
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {

            // Store Data
            $user_updated = User::whereId($user->id)->update([
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'mobile_number' => $request->mobile_number,
                'company_name'  => $request->company_name,
            ]);

            // Delete Any Existing Role
            DB::table('model_has_roles')->where('model_id',$user->id)->delete();
            
            // Assign Role To User
            $user->assignRole($user->role_id);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('users.index')->with('success','User Updated Successfully.');

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Delete User
     * @param User $user
     * @return Index Users
     */
    public function delete(User $user)
    {
        DB::beginTransaction();
        try {
            // Delete User
            User::whereId($user->id)->delete();

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User Deleted Successfully!.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Import Users 
     * @param Null
     * @return View File
     */
    public function importUsers()
    {
        return view('users.import');
    }

    public function uploadUsers(Request $request)
    {
        Excel::import(new UsersImport, $request->file);
        
        return redirect()->route('users.index')->with('success', 'User Imported Successfully');
    }

    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

}
