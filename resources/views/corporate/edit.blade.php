@extends('layouts.app')
@section('title')
    {{ 'Subject - Corporate' }}
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
                    <h4 class="text-themecolor">Corporate</h4>
                </div> 
                <div class="col-md-7 align-self-end text-right">
                    <div class="d-flex mt-4 justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('corporate.index') }}">Corporate</a></li>
                            <li class="breadcrumb-item active">Edit Corporate</li>
                        </ol>



                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <!-- Zero config.table start -->
                    <div class="card">
                        <div class="card-header bg-white modal-header d-block">
                            <h1 class="h3 mb-0 text-gray-800 float-left">Edit Corporate</h1>
                            <a type="button" href="javascript:void(0);" class="btn float-right btn-primary btn-modal waves-effect waves-light"
                                href="{{ route('corporate.index') }}"
                                data-container="#ajax_modal" style="color:#fff!important;">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>                           
                                                          
                        </div>
                        {!! Form::open(['url' => action('App\Http\Controllers\Corporate\CorporateController@update', [$corporate->id]), 'method' => 'PUT', 'id' => 'ajax_form',  'enctype' => 'multipart/form-data' ]) !!}
                            
                            <div class="card-body">
                                @php
                                    $form = 'edit';
                                @endphp
                                @csrf
                                <div class="form-group">
                                    {{ Form::label('Corporate name: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('corporate_name', $corporate->corporate_name ?? '', ['class' => 'form-control',   'placeholder' => 'Corporate name']) !!}
                                    <span class="md-line text-danger" id="name_error"></span>
                                </div>
                                <div class="form-group">
                                     {{ Form::label('Phone Number: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('phone_no', $corporate->phone_no ?? '', ['class' => 'form-control',   'id' => 'phone_no', 'placeholder' => 'Phone Number']) !!}
                                   
                                    <span class="md-line text-danger" id="icon_error"></span>
                                </div>
                                <div class="form-group ">
                                     {{ Form::label('Email Address: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('email', $corporate->email ?? '', ['class' => 'form-control',  'id' => 'email', 'placeholder' => 'Phone Number']) !!}
                                    
                                    <span class="md-line text-danger" id="banner_error"></span>
                                </div>
                                <div class="form-group ">
                                     {{ Form::label('Password: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('password', $corporate->password ?? '', ['class' => 'form-control',  'id' => 'password', 'placeholder' => 'Password']) !!}
                                    <span class="md-line text-danger" id="thumb_error"></span>
                                </div>
                                <div class="form-group ">
                                     {{ Form::label('Confirm_Password: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('confirm_password', $corporate->confirm_password ?? '', ['class' => 'form-control',  'id' => 'confirm_password', 'placeholder' => 'Confirm_Password']) !!}
                                    <span class="md-line text-danger" id="thumb_error"></span>
                                </div>
                                <div class="form-group ">
                                     {{ Form::label('Company Name: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('company_name', $corporate->company_name ?? '', ['class' => 'form-control',  'id' => 'company_name', 'placeholder' => 'Company_name']) !!}
                                    <span class="md-line text-danger" id="thumb_error"></span>
                                </div>
                                <div class="form-group ">
                                     {{ Form::label('Company Address: *', null, ['class' => 'label text-black']) }}
                                    {!! Form::text('company_address', $corporate->company_address ?? '', ['class' => 'form-control',  'id' => 'company_address', 'placeholder' => 'Company_address']) !!}
                                    <span class="md-line text-danger" id="thumb_error"></span>
                                </div>
                                
                            
                            </div>
                            <div class="card-footer">
                                
                                {!! Form::submit('Save', ['class' => 'btn btn-info waves-effect', 'id' => 'on_submit_corporate']) !!}
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
                        setTimeout(function(){window.location.href=baseUrl+"corporate"} , 5000);
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

