@extends('layouts.app')
@section('title')
    {{ 'Subject - Categories' }}
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
                    <h4 class="text-themecolor">Categories</h4>
                </div> 
                <div class="col-md-7 align-self-end text-right">
                    <div class="d-flex mt-4 justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
                            <li class="breadcrumb-item active">Edit Category</li>
                        </ol>



                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-header bg-white modal-header d-block">
                            <h1 class="h3 mb-0 text-gray-800 float-left">Edit Category</h1>
                            <a type="button" href="javascript:void(0);" class="btn float-right btn-primary btn-modal waves-effect waves-light"
                                href="{{ route('categories.index') }}"
                                data-container="#ajax_modal" style="color:#fff!important;">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>                           
                                                          
                        </div>
                        {!! Form::open(['url' => action('App\Http\Controllers\Categories\CategoryController@update', [$category->id]), 'method' => 'PUT', 'id' => 'ajax_form',  'enctype' => 'multipart/form-data' ]) !!}
                            
                            <div class="card-body">
                                @php
                                    $form = 'edit';
                                @endphp
                                @csrf
                                <div class="form-group">
                                    {{ Form::label('Category name: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('name', $category->name ?? '', ['class' => 'form-control', 'name' => 'name', 'id' => 'name', 'placeholder' => 'Category name']) !!}
                                    <span class="md-line" id="name_error"></span>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('Category code: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('short_code', $category->short_code ?? '', ['class' => 'form-control', 'name' => 'short_code', 'id' => 'short_code', 'placeholder' => 'Category code']) !!}
                                    <span class="md-line" id="short_code_error"></span>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('Description: ', null, ['class' => 'label text-black']) }}

                                    {!! Form::text('description', $category->description ?? '', ['class' => 'form-control', 'name' => 'description', 'id' => 'description', 'placeholder' => 'Description']) !!}
                                    <span class="md-line" id="description_error"></span>
                                </div>
                                    <div class="form-group">
                                        {!! Form::label('Industry:*') !!}
                                        <div class="controls category">
                                            {!! Form::select('industry_id', $industries, $category->industry_id ?? '', ['placeholder' => __('please_select'), 'class' => 'form-control select2 ', 'data-validation-required-message' => 'The industry field is required']) !!}
                                            <span class="md-line" id="business_id_error"></span>
                                        </div>
                                    </div>

                                <div class="form-group">
                                    {{ Form::label('Icon: ', null, ['class' => 'label text-black']) }}
                                    {!! Form::file('icon', ['class' => 'form-control', 'id' => 'icon']) !!}
                                    <span class="md-line" id="icon_error"></span>
                                </div>
                                <div class="form-group banner">
                                    {{ Form::label('Image: ', null, ['class' => 'label text-black']) }}
                                    {!! Form::file('banner', ['class' => 'form-control', 'id' => 'banner']) !!}
                                    <span class="md-line" id="banner_error"></span>
                                </div>
                                <div class="form-group thumb">
                                    {{ Form::label('Thumb: ', null, ['class' => 'label text-black']) }}
                                    {!! Form::file('thumb', ['class' => 'form-control', 'id' => 'thumb']) !!}
                                    <span class="md-line" id="thumb_error"></span>
                                </div>                          
                            </div>
                            <div class="card-footer">
                                
                                {!! Form::submit('Save', ['class' => 'btn btn-info waves-effect', 'id' => 'on_submit_industry']) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                   
                </div>
            </div>
        </div>
    </section>
</div>


@endsection

@section('scripts')

<script>
    $(document).ready(function(){
        $(document).on('submit', 'form#ajax_form', function(e) {
            e.preventDefault();         
            var ref = $(this);
            ref.find('span.md-line').html('');
            ref.find('input[type="submit"]').attr('disabled', true);
            $.ajax({
                method: 'POST',
                url: ref.attr('action'),
                data: new FormData(this),
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.ajax_loader').removeClass('d-none');
                },
                success: function(result) {
                    $('.ajax_loader').addClass('d-none');
                    if (result.success === true) {
                        toastr.success(result.msg);
                        setTimeout(function(){window.location.href=baseUrl+"categories"} , 5000);
                    } else {
                        toastr.error(result.msg);
                        console.log(result.msg);
                    }
                },
                error: function(data) {
                    $('.ajax_loader').addClass('d-none');
                    var response = JSON.parse(data.responseText);
                    $.each(response.errors, function(key, value) {
                        $('#' + key + '_error').html(value);
                    });
                    ref.find('input[type="submit"]').attr('disabled', false);
                },
            });
        });
    });
</script>

@endsection

