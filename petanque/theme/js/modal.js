
$(document).ready(function() {
    // Expand/reduce score table
    $('.modal-button').each(function() {
        $(this).on('click', function() {
            $(this).parent().addClass('expanded');
        })
    })
    $('.close-modal-button').on('click', function() {
        $(this).closest('.modal-container').removeClass('expanded');
    });

});