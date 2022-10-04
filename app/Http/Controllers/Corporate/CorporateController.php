<?php

namespace App\Http\Controllers\Corporate;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Corporate;
use Yajra\DataTables\DataTables;

use Illuminate\Support\Facades\Auth;
use App\Repositories\CorporateRepository;
use App\Http\Requests\Corporate\CreateCorporateRequest;
use App\Http\Requests\Corporate\UpdateCorporateRequest;

class CorporateController extends Controller
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $corporate;

    /**
     * CustomerController constructor.
     */

    public function __construct(CorporateRepository $corporate)
    {
        $this->corporate = $corporate;
    }

    public function index()
    {

        if (request()->ajax()) {
            return Datatables::of($this->corporate->all())
                ->addColumn(
                    'action',
                    '
                    <button data-href="{{action(\'App\Http\Controllers/Corporate\CorporateController@edit\', [$id])}}" class="btn btn-xs btn-primary btn-modal" data-container="#ajax_modal"><i class="glyphicon glyphicon-edit"></i> @lang("Edit")</button>
                    &nbsp;

                    <button data-href="{{action(\'App\Http\Controllers\Corporate\CorporateController@show\', [$id])}}" class="btn btn-xs btn-info btn-modal" data-container="#ajax_modal"><i class="glyphicon glyphicon-edit"></i> @lang("View")</button>
                    &nbsp;

                    <button data-href="{{action(\'App\Http\Controllers\Corporate\CorporateController@destroy\', [$id])}}" class="btn btn-xs btn-danger delete_button"><i class="glyphicon glyphicon-trash"></i> @lang("Delete")</button>'
                )

                ->editColumn('name', function ($row) {

                    return  $row->name;
                })




                ->rawColumns(['action'])
                ->make(true);

        }
                return view('corporate.index');
    }


    public function create(Request $request)
    {
          return view('corporate.create');

    }

    public function edit($id)
    {
       $corporate = Corporate::where('id', $id)->first();
       // $authCustomer = AuthCustomer::where('id',$customer->customer_id)->first();
        return view('corporate.edit')->with(compact('corporate'));

    }

    public function show($id)
    {
     $corporate= Corporate::where('id', $id)->first();
    return view('corporate.view')->with(compact('corporate'));

    }

    public function store(CreateCorporateRequest $request)
    {
        return $this->corporate->store();
    }

    public function update(UpdateCorporateRequest $request, $id)
    {
      return $this->corporate->update($id);
    }


    public function destroy($id)
    {

        if (request()->ajax()) {
            return $this->corporate->delete($id);
        }
    }
}
