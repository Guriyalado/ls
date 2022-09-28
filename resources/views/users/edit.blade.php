@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 mt-4 text-gray-800">Edit Users</h1>
                <a href="{{route('users.index')}}" class="d-none mt-4 d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
            </div>

            {{-- Alert Messages --}}
            @include('common.alert')
        
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
                </div>
                <form method="POST" action="{{route('users.update', ['user' => $user->id])}}">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="form-group row">

                            {{-- First Name --}}
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                <span style="color:red;">*</span>First Name</label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-user @error('first_name') is-invalid @enderror" 
                                    id="exampleFirstName"
                                    placeholder="First Name" 
                                    name="first_name" 
                                    value="{{ old('first_name') ?  old('first_name') : $user->first_name}}">

                                @error('first_name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            {{-- Last Name --}}
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                <span style="color:red;">*</span>Last Name</label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-user @error('last_name') is-invalid @enderror" 
                                    id="exampleLastName"
                                    placeholder="Last Name" 
                                    name="last_name" 
                                    value="{{ old('last_name') ? old('last_name') : $user->last_name }}">

                                @error('last_name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                <span style="color:red;">*</span>Email</label>
                                <input 
                                    type="email" 
                                    class="form-control form-control-user @error('email') is-invalid @enderror" 
                                    id="exampleEmail"
                                    placeholder="Email" 
                                    name="email" 
                                    readonly
                                    value="{{ old('email') ? old('email') : $user->email }}">

                                @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            {{-- Mobile Number --}}
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                <span style="color:red;">*</span>Mobile Number</label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-user @error('mobile_number') is-invalid @enderror" 
                                    id="exampleMobile"
                                    placeholder="Mobile Number" 
                                    name="mobile_number" 
                                    value="{{ old('mobile_number') ? old('mobile_number') : $user->mobile_number }}">

                                @error('mobile_number')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            {{-- Company Name --}}
                            <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                                <span style="color:red;">*</span>Company Name</label>
                                <input type="text" 
                                    class="form-control form-control-user @error('company_name') is-invalid @enderror" 
                                    placeholder="Company Name" 
                                    name="company_name" 
                                    value="{{ old('company_name') ? old('company_name') : $user->company_name }}">
                                @error('company_name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-user float-right mb-3">Update</button>
                        <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('users.index') }}">Cancel</a>
                    </div>
                </form>
            </div>

        </div>
    </section>
</div>

@endsection