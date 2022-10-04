<?php

namespace App\Http\Controllers\Size;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\size;
use Yajra\DataTables\DataTables;

use Illuminate\Support\Facades\Auth;
use App\Repositories\SizeRepository;
use App\Http\Requests\Corporate\CreateCorporateRequest;
use App\Http\Requests\Corporate\UpdateCorporateRequest;

class SizeController extends Controller
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $size;

    /**
     * CustomerController constructor.
     */

    public function __construct(SizeRepository $size)
    {
        $this->size = $size;
    }

    public function index()
    {

        if (request()->ajax()) {
            return Datatables::of($this->size->all())
                ->addColumn(
                    'action',
                    '
                    <button data-href="{{action(\'App\Http\Controllers/Size\SizeController@edit\', [$id])}}" class="btn btn-xs btn-primary btn-modal" data-container="#ajax_modal"><i class="glyphicon glyphicon-edit"></i> @lang("Edit")</button>
                    &nbsp;

                    <button data-href="{{action(\'App\Http\Controllers\Size\SizeController@show\', [$id])}}" class="btn btn-xs btn-info btn-modal" data-container="#ajax_modal"><i class="glyphicon glyphicon-edit"></i> @lang("View")</button>
                    &nbsp;

                    <button data-href="{{action(\'App\Http\Controllers\Size\SizeController@destroy\', [$id])}}" class="btn btn-xs btn-danger delete_button"><i class="glyphicon glyphicon-trash"></i> @lang("Delete")</button>'
                )

                ->editColumn('name', function ($row) {

                    return  $row->name;
                })




                ->rawColumns(['action'])
                ->make(true);

        }
                return view('size.index');
    }


    public function create(Request $request)
    {
          return view('size.create');

    }

    public function edit($id)
    {
       $size = Size::where('id', $id)->first();
       // $authCustomer = AuthCustomer::where('id',$customer->customer_id)->first();
        return view('size.edit')->with(compact('size'));

    }

    public function show($id)
    {
     $size= Size::where('id', $id)->first();
    return view('size.view')->with(compact('size'));

    }

    public function store(CreateSizeRequest $request)
    {
        return $this->size->store();
    }

    public function update(UpdateSizeRequest $request, $id)
    {
      return $this->size->update($id);
    }


    public function destroy($id)
    {

        if (request()->ajax()) {
            return $this->size->delete($id);
        }
    }
}
