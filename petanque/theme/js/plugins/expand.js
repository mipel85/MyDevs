
$(document).ready(function() {
    // Expand/reduce score table
    $('[id*="expand-"').each(function() {
        // if reload
        let url = window.location.hash.slice(1),
            expand = url.split('-')[0];
        
        if(expand == 'expand') {
            $(this).addClass('expanded');
            $(this).parent('.expand-container').addClass('expanded-list');
            $(this).html('<i class="fa fa-lg fa-fw fa-minimize"></i>');
        }
        else {
            $(this).html('<i class="fa fa-lg fa-fw fa-expand"></i>');
        }
        // if click
        $(this).on('click', function() {
            $(this).toggleClass('expanded');
            if ($(this).hasClass('expanded')) {
                $(this).html('<i class="fa fa-lg fa-fw fa-minimize"></i>');
                window.location.hash = $(this).data('expand');
            }
            else {
                $(this).html('<i class="fa fa-lg fa-fw fa-expand"></i>');
                window.location.hash = $(this).data('minimize');
            }
            $(this).parent('.expand-container').toggleClass('expanded-list');
        })
    })

})