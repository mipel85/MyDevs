$(document).ready(function() {
    $('input:not([checkbox])').each(function() {
        $(this).on('focus', function() {
            $(this).removeClass('input-error');
        });
    });
});