
$(function() {
    /*AJAX Interceptor*/
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': Everest.csrfToken
        }
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    $('.delete').click(function(event){
        event.preventDefault();
        var form = $(this).next('form');
        swal({
              title: "Are you sure?",
              text: "You will not be able to recover this imaginary file!",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes, delete it!",
              closeOnConfirm: false
          },
          function(){
              form.submit();
              swal("Deleted!", "Your imaginary file has been deleted.", "success");
          });
    });

});
