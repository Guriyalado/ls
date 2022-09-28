<div class="modal-body">
    @csrf
    <div class="form-group">
        {{ Form::label('Retailer name: *', null, ['class' => 'label text-black']) }}
         {!! Form::text('retailer_name', $retailer->reatiler_name ?? '', ['class' => 'form-control',  'id' => 'name', 'placeholder' => 'Retailer name']) !!}
        <span class="md-line text-danger" id="name_error"></span>
    </div>
    <div class="form-group">
        {{ Form::label('Phone Number: *', null, ['class' => 'label text-black']) }}
       {!! Form::text('phone_no', $retailer->phone_no ?? '', ['class' => 'form-control',  'id' => 'phone_no', 'placeholder' => 'Phone Number']) !!}
        <span class="md-line text-danger" id="icon_error"></span>
    </div>
    <div class="form-group ">
        {{ Form::label('Email Address: *', null, ['class' => 'label text-black']) }}
        {!! Form::text('email', $retailer->email ?? '', ['class' => 'form-control',  'id' => 'email', 'placeholder' => 'Phone Number']) !!}
                                    
        <span class="md-line text-danger" id="banner_error"></span>
    </div>
    <div class="form-group">
        {{ Form::label('Password: *', null, ['class' => 'label text-black']) }}
        {!! Form::text('password', $retailer->password ?? '', ['class' => 'form-control',  'id' => 'password', 'placeholder' => 'Password']) !!}
        <span class="md-line text-danger" id="thumb_error"></span>
    </div>
     <div class="form-group ">
      {{ Form::label('Confirm_Password: *', null, ['class' => 'label text-black']) }}
      {!! Form::text('confirm_password', $retailer->confirm_password ?? '', ['class' => 'form-control',  'id' => 'confirm_password', 'placeholder' => 'Confirm_Password']) !!}
     <span class="md-line text-danger" id="thumb_error"></span>
     </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default waves-effect " data-bs-dismiss="modal">Close</button>
    {!! Form::submit('Save', ['class' => 'btn btn-info waves-effect', 'id' => 'on_submit_retailer']) !!}
</div>
