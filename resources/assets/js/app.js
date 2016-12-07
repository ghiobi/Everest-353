
$(function() {
    /*AJAX Interceptor*/
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': Everest.csrfToken
        }
    });

});
