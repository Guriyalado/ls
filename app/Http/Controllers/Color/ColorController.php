<?php

namespace App\Http\Controllers\Color;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Color;
use Yajra\DataTables\DataTables;

use Illuminate\Support\Facades\Auth;
use App\Repositories\ColorRepository;
use App\Http\Requests\Color\CreateColorRequest;
use App\Http\Requests\Color\UpdateColorRequest;

class ColorController extends Controller
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $color;

    /**
     * CustomerController constructor.
     */

    public function __construct(ColorRepository $color)
    {
        $this->color = $color;
    }

    public function index()
    {

        if (request()->ajax()) {
            return Datatables::of($this->color->all())
                ->addColumn(
                    'action',
                    '
                    <button data-href="{{action(\'App\Http\Controllers/Color\ColorController@edit\', [$id])}}" class="btn btn-xs btn-primary btn-modal" data-container="#ajax_modal"><i class="glyphicon glyphicon-edit"></i> @lang("Edit")</button>
                    &nbsp;

                    <button data-href="{{action(\'App\Http\Controllers\Color\ColorController@show\', [$id])}}" class="btn btn-xs btn-info btn-modal" data-container="#ajax_modal"><i class="glyphicon glyphicon-edit"></i> @lang("View")</button>
                    &nbsp;

                    <button data-href="{{action(\'App\Http\Controllers\Color\ColorController@destroy\', [$id])}}" class="btn btn-xs btn-danger delete_button"><i class="glyphicon glyphicon-trash"></i> @lang("Delete")</button>'
                )

                ->editColumn('name', function ($row) {

                    return  $row->name;
                })
                 ->editColumn('color', function ($row) {

                    return  $row->color;
                })




                ->rawColumns(['action'])
                ->make(true);

        }
                return view('color.index');
    }


    public function create(Request $request)
    {
          return view('color.create');

    }

    public function edit($id)
    {
       $color = Color::where('id', $id)->first();
       // $authCustomer = AuthCustomer::where('id',$customer->customer_id)->first();
        return view('color.edit')->with(compact('color'));

    }

    public function show($id)
    {
     $color= Color::where('id', $id)->first();
    return view('color.view')->with(compact('color'));

    }

    public function store(CreateColorRequest $request)
    {
        return $this->color->store();
    }

    public function update(UpdateColorRequest $request, $id)
    {
      return $this->color->update($id);
    }


    public function destroy($id)
    {

        if (request()->ajax()) {
            return $this->color->delete($id);
        }
    }
}
