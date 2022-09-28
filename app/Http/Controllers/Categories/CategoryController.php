<?php

namespace App\Http\Controllers\Categories;

use App\Models\Category;
use App\Models\Industry;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CategoryRepository;
use App\Http\Requests\Categories\CreateCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $category;

    /**
     * CategoryController constructor.
     */

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
        return $this->category->all();
    }

    public function index()
    {
        if (request()->ajax()) {

            return Datatables::of($this->category->all())
                ->addColumn('action', function ($row) {                   
                        $btn = '<div style="display: flex">';
                        $btn =  $btn.'<a href="'.route('categories.edit', [$row->id]).'"
                                    class="btn btn-primary m-2">
                                    <i class="fa fa-pen"></i>
                                </a>';

                        $btn =  $btn.'<a class="btn btn-danger delete_button m-2" href="'.route('categories.destroy', $row->id).'">
                                    <i class="fas fa-trash"></i>
                                </a>';

                        $btn = $btn.'</div>';
                    return $btn;
                })
                ->editColumn('thumb', function ($row) {
                    return '<div style="display: flex;"><img src="' . $row->thumb . '" width="50px" height="auto" alt="Product image" class="product-thumbnail-small"></div>';
                })
                ->editColumn('name', function ($row) {

                    return  $row->name;
                })
                ->editColumn('industry', function ($row) {

                    return  $row->industry->name;
                })
                ->removeColumn('id')
                ->rawColumns(['action', 'thumb','name','industry'])
                ->make(true);
        }
        return view('category.index');
    }


    public function create(Request $req)
    {
        if (Auth::guard('web')->check()) {
            if (!Auth::guard('web')->user()->can('category-create')) {
                abort(403, 'Unauthorized action.');
            }
        }
        $industries = Industry::where('status', 1)
            ->pluck('name','id');
        return view('category.create')->with(compact('industries'));
    }

    public function edit($id)
    {
        if (Auth::guard('web')->check()) {
            if (!Auth::guard('web')->user()->can('category-update')) {
                abort(403, 'Unauthorized action.');
            }
        }
        $this->checkCategory($id);
        $category = Category::where('id', $id)->with('industry')->first();
        $industries = Industry::where('status', 1)->pluck('name','id');
        return view('category.edit')->with(compact('industries','category'));
    }

    protected function checkCategory($id)
    {
        if (Auth::guard('web')->check()) {
            if (ucfirst(auth()->user()->roles->first()->name) != 'Admin') {
                $category = Category::where('id', $id)->get()->first();
                if (!($category->created_by == Auth::id()))
                    abort(403, 'Unauthorized action.');
            }
        } else {
            $category = Category::where('id', $id)->get()->first();
            if (!($category->business_id == request()->session()->get('user.business_id')))
                abort(403, 'Unauthorized action.');
        }
    }

    public function store(CreateCategoryRequest $request)
    {
        # code...
        if (Auth::guard('web')->check()) {
            if (!Auth::guard('web')->user()->can('category-create')) {
                abort(403, 'Unauthorized action.');
            }
        }
        return $this->category->store();
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        # code...
        if (Auth::guard('web')->check()) {
            if (!Auth::guard('web')->user()->can('category-update')) {
                abort(403, 'Unauthorized action.');
            }
        }
        return $this->category->update($id);
    }


    public function destroy($id)
    {
        if (Auth::guard('web')->check()) {
            if (!Auth::guard('web')->user()->can('category-delete')) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            if (!Auth::guard('seller')->user()->can('category-delete')) {
                abort(403, 'Unauthorized action.');
            }
        }
        if (request()->ajax()) {
            return $this->category->delete($id);
        }
    }
}
