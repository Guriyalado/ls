@extends('layouts.app')
@section('title')
    {{ 'Subject - Color' }}
@endsection
@section('content')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h4 class="text-themecolor">Color</h4>
                </div> 
                <div class="col-md-7 align-self-end text-right">
                    <div class="d-flex mt-4 justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Color</li>
                        </ol>



                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-header bg-white modal-header d-block">
                            <h1 class="h3 mb-0 text-gray-800 float-left">Color</h1>
                            <a type="button" href="javascript:void(0);" class="btn float-right btn-primary btn-modal waves-effect waves-light"
                                data-href="{{ action('App\Http\Controllers\Color\ColorController@create') }}"
                                data-container="#ajax_modal" style="color:#fff!important;">
                                <i class="fa fa-plus"></i> Add
                            </a>                           
                                                          
                        </div>
                        <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                <table id="data_table" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Color</th>
                                             <th >Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
        @if(!empty($color))
            @foreach ($colors as $color)
                <tr data-entry-id="{{ $color->id }}">
                    <td field-key='name'>{{ $color->name }}</td>
                    <td field-key='color'>{{ $color->color }}</td>
                    <td>
                        <a href="{{ route('color.edit',[$color->id]) }}" class="btn btn-xs btn-info">Edit</a>
                        {!! Form::open(array(
                            'style' => 'display: inline-block;',
                            'method' => 'DELETE',
                            'onsubmit' => "return confirm('Are you sure?');",
                            'route' => ['color.destroy', $tag->id])) !!}
                        {!! Form::submit('Delete', array('class' => 'btn btn-xs btn-danger')) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            @endif
       
    </tbody>
 


                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Zero config.table end -->
                    <div class="modal fade" id="ajax_modal" tabindex="-1" role="dialog" style=""></div>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection

@section('scripts')

<script>
    var columns= [
        {
            data: 'color',
            name: 'color'
        },
       
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        },
    ];

    
           
</script>
@include('layouts.partials.common-js');
@endsection

