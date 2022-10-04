
<div class="modal-body">
    @csrf
  <div class="form-row mb-4">
     <div class="form-group col-md-12">
         {!! Form::label('Corporate Name:') !!}
         {!! Form::text('corporate_name', $corporate->corporate_name ?? '', ['class' => 'form-control']) !!}
         
     </div>
      <div class="form-group col-md-12">
         {!! Form::label('Phone No:') !!}
         {!! Form::text('phone_no', $corporate->phone_no ?? '', ['class' => 'form-control']) !!}
        
     </div>
     <div class="form-group col-md-12">
        {{ Form::label('Email: *', null, ['class' => 'label text-black']) }}
        {!! Form::text('email', $corporate->email?? '', ['class' => 'form-control', 'name' => 'email', 'id' => 'email']) !!}

    </div>
    <div class="form-group col-md-12">
        {{ Form::label('Password: *', null, ['class' => 'label text-black']) }}
        {!! Form::text('password', $corporate->password?? '', ['class' => 'form-control', 'name' => 'password', 'id' => 'password']) !!}

    </div>
    <div class="form-group col-md-12">
        {{ Form::label('Confirm Password: *', null, ['class' => 'label text-black']) }}
        {!! Form::text('confirm_password', $corporate->confirm_password?? '', ['class' => 'form-control', 'name' => 'confirm_password', 'id' => 'confirm_password']) !!}

    </div>
    <div class="form-group col-md-12">
          {!! Form::label('Company Name:') !!}
         {!! Form::text('company_name', $corporate->company_name ?? '', ['class' => 'form-control']) !!}
         
     </div>
   
     
      <div class="form-group col-md-12">
          {!! Form::label('Company Address:') !!}
         {!! Form::text('company_address', $corporate->company_address ?? '', ['class' => 'form-control']) !!}
        
     </div>
     


    </div>
    </div>
 <div class="modal-footer">
    <button type="button" class="btn btn-default waves-effect " data-bs-dismiss="modal">Close</button>
    {!! Form::submit('Save', ['class' => 'btn btn-info waves-effect', 'id' => 'on_submit_corporate']) !!}
</div>

