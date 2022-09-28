<script>
    $(function () {
      
      var data_table = $('#data_table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('industries.index') }}",
          columns: columns
      });
        
    });
    $( document ).ready(function() {
        $(document).on('click', '.delete_button', function(e) {
            e.preventDefault();
            var thePath = $(this).attr('href');
            const data = thePath.substring(thePath.lastIndexOf('/') + 1)
            swal({
                title: 'Delete',
                text: 'Are you sure!',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        method: 'delete',
                        url: $(this).attr('href'),
                        dataType: 'json',
                        data: {
                            'id': data,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(result) {
                            if (result.success === true) {
                                toastr.success(result.msg);
                                setTimeout(function(){window.location.href=baseUrl+"industries"} , 5000);
                            } else {
                                toastr.error(result.msg);
                            }
                        },
                    });
                }
            });
        });
        $(document).on('click', '.btn-modal', function(e) {
            e.preventDefault();
          
            var container = '#ajax_modal';
            $.ajax({
                url: $(this).data('href'),
                dataType: 'html',
                success: function(result) {
                    $(container)
                        .html(result)
                        .modal('show');
                },
            });
        });
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
                        
                        $('form#ajax_modal').modal('hide');
                        setTimeout(function(){window.location.href=baseUrl+"industries"} , 5000);
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
