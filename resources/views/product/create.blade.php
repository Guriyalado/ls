<div class="modal-dialog modal-lg  position-relative" role="document">
    <div class="ajax_loader text-center d-none">
        <img src="{{ asset('uploads/img/loader.png') }}" class="img-responsive">
    </div>
    <div class="modal-content">
        <div class="bg-info modal-header">
            <h4 class="modal-title text-white">Add</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {!! Form::open(['url' => action('App\Http\Controllers\Product\ProductController@store'), 'method' => 'post', 'id' => 'ajax_form', 'enctype' => 'multipart/form-data']) !!}
        @php
            $form = 'create';
        @endphp
        @include('product.form')
        {!! Form::close() !!}
    </div>
</div>
