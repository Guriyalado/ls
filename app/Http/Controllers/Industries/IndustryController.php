<?php

namespace App\Http\Controllers\Industries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Industry;
use Yajra\DataTables\DataTables;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use App\Repositories\IndustryRepository;
use App\Http\Requests\Industries\CreateIndustryRequest;
use App\Http\Requests\Industries\UpdateIndustryRequest;
class IndustryController extends Controller
{
    /**
     * @var IndustryRepositoryInterface
     */
    private $industry;

    /**
     * IndustryController constructor.
     */

    public function __construct(IndustryRepository $industry)
    {
        $this->industry = $industry;
        return $this->industry->all();
    }

    public function index()
    {
        if (request()->ajax()) {

            return Datatables::of($this->industry->all())
                ->addColumn('action', function ($row) {                   
                        $btn = '<div style="display: flex">';
                        $btn =  $btn.'<a href="'.route('industries.edit', [$row->id]).'"
                                    class="btn btn-primary m-2">
                                    <i class="fa fa-pen"></i>
                                </a>';

                        $btn =  $btn.'<a class="btn btn-danger delete_button m-2" href="'.route('industries.destroy', $row->id).'">
                                    <i class="fas fa-trash"></i>
                                </a>';

                        $btn = $btn.'</div>';
                    return $btn;
                })
                ->editColumn('icon', function ($row) {
                    return '<div style="display: flex;"><img src="'. $row->icon.'" width="50px" height="auto" alt="Product image" class="product-thumbnail-small"></div>';
                })
                ->editColumn('name', function ($row) {

                    return  $row->name;
                })
                ->removeColumn('id')
                ->rawColumns(['action', 'icon','name'])
                ->make(true);
        }
        return view('industry.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $req)
    {
        
        if (Auth::guard('web')->check()) {
            if (!Auth::guard('web')->user()->can('industry-create')) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            if (!Auth::guard('seller')->user()->can('industry-create')) {
                abort(403, 'Unauthorized action.');
            }
        }
        return view('industry.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateIndustryRequest $request)
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
        return $this->industry->store();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::guard('web')->check()) {
            if (!Auth::guard('web')->user()->can('industry-update')) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            if (!Auth::guard('seller')->user()->can('industry-update')) {
                abort(403, 'Unauthorized action.');
            }
        }
        $industry = Industry::where('id', $id)->first();
        return view('industry.edit')->with(compact('industry'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIndustryRequest $request, $id)
    {
        
        # code...
        if (Auth::guard('web')->check()) {
            if (!Auth::guard('web')->user()->can('industry-update')) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            if (!Auth::guard('seller')->user()->can('industry-update')) {
                abort(403, 'Unauthorized action.');
            }
        }
        return $this->industry->update($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        if (Auth::guard('web')->check()) {
            if (!Auth::guard('web')->user()->can('industry-delete')) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            if (!Auth::guard('seller')->user()->can('industry-delete')) {
                abort(403, 'Unauthorized action.');
            }
        }
        if (request()->ajax()) {
            return $this->industry->delete($id);
        }
    }

}
