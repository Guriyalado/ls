<?php

namespace App\Http\Controllers\Product;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Yajra\DataTables\DataTables;

use Illuminate\Support\Facades\Auth;
use App\Repositories\ProductRepository;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $product;

    /**
     * CustomerController constructor.
     */

    public function __construct(ProductRepository $product)
    {
        $this->product = $product;
    }

    public function index()
    {

        if (request()->ajax()) {
            return Datatables::of($this->product->all())
                ->addColumn(
                    'action',
                    '
                    <button data-href="{{action(\'App\Http\Controllers/Product\ProductController@edit\', [$id])}}" class="btn btn-xs btn-primary btn-modal" data-container="#ajax_modal"><i class="glyphicon glyphicon-edit"></i> @lang("Edit")</button>
                    &nbsp;

                    <button data-href="{{action(\'App\Http\Controllers\Product\ProductController@show\', [$id])}}" class="btn btn-xs btn-info btn-modal" data-container="#ajax_modal"><i class="glyphicon glyphicon-edit"></i> @lang("View")</button>
                    &nbsp;

                    <button data-href="{{action(\'App\Http\Controllers\Product\ProductController@destroy\', [$id])}}" class="btn btn-xs btn-danger delete_button"><i class="glyphicon glyphicon-trash"></i> @lang("Delete")</button>'
                )

                ->editColumn('name', function ($row) {

                    return  $row->name;
                })




                ->rawColumns(['action'])
                ->make(true);

        }
                return view('product.index');
    }


    public function create(Request $request)
    {
          return view('product.create');

    }

    public function edit($id)
    {
       $product = Product::where('id', $id)->first();
       // $authCustomer = AuthCustomer::where('id',$customer->customer_id)->first();
        return view('product.edit')->with(compact('product'));

    }

    public function show($id)
    {
     $product = Product::where('id', $id)->first();
    return view('product.view')->with(compact('product'));

    }

    public function store(CreateProductRequest $request)
    {
        return $this->product->store();
    }

    public function update(UpdateProductRequest $request, $id)
    {
      return $this->product->update($id);
    }


    public function destroy($id)
    {

        if (request()->ajax()) {
            return $this->product->delete($id);
        }
    }
}
