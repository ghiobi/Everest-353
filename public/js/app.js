
$(function() {
    /*AJAX Interceptor*/
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': Everest.csrfToken
        }
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

});
