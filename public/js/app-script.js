$(function(){
    if ($(document).width() > 767) {
        $('.navbar-brand').remove();
    } else {
        $('.nav.navbar-nav li:first-child').remove();
    }

    ///////////////   for tip tool   //////////////////////////////////////////

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

    ///////////////////////////////////////////////////////////////////////////

    $('.form-horizontal label').eq(4).removeClass('control-label');

    if ($(document).width() <  992) {
        $('.form-horizontal .form-group:eq(4) div').css('display', 'inline-block');
    }

});