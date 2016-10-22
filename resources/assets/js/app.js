
$(function() {
    /*AJAX Interceptor*/
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': Everest.csrfToken
        }
    });

    var $footer = $('footer'), $main = $('main'), $pageContent = $('.page-content');
    $(window).resize(function(){
        if($pageContent.height() + $footer.height() < $main.height()){
            $footer.addClass('push-bottom');
        } else {
            $footer.removeClass('push-bottom');
        }
    }).resize();

    $('.datepicker').pickadate({
        format: 'yyyy-mm-dd',
        selectMonths: true,
        selectYears: true
    });
    $('.timepicker').pickatime()

});
