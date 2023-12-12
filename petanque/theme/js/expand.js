
$(document).ready(function() {
    // Expand/reduce score table
    $('[id*="expand-"').each(function() {
        $(this).html('<i class="fa fa-lg fa-fw fa-expand"></i>');
        $(this).on('click', function() {
            $(this).toggleClass('expanded');
            $(this).hasClass('expanded') ? 
                $(this).html('<i class="fa fa-lg fa-fw fa-minimize"></i>') :
                $(this).html('<i class="fa fa-lg fa-fw fa-expand"></i>');
            $(this).parent('.expand-container').toggleClass('expanded-list');
        })
    })
})