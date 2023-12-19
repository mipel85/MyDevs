
$(document).ready(function() {
    // Expand
    $('.modal-button').each(function() {
        $(this).on('click', function(e) {
            $(this).parent().addClass('expanded');
        })
    })
    // Close on xmark button
    $('.close-modal-button').on('click', function() {
        $(this).closest('.modal-container').removeClass('expanded');
    });
    // Close on clicking outside the box
    $(document).mouseup(function(e) {
        var modal_container = $('.modal-content');
        if (!modal_container.is(e.target) && modal_container.has(e.target).length === 0)
            modal_container.parent().removeClass('expanded');
    });

});