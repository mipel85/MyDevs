# INCLUDE CONTENT #

<script>
    // Create new list from FormFieldMultipleCheckBox
        // Create ul
    jQuery('<ul/>', {id : 'cb-list'}).prependTo('#onblurContainerResponseAdminReviewConfigController_multiple_check_box').addClass('cell-flex cell-columns-4');
        // Create li For each checkbox
    jQuery('#onblurContainerResponseAdminReviewConfigController_multiple_check_box .form-field-checkbox').each(function(){
        let $cb = jQuery(this);
        let cbSpan = $cb.find('span');
        let cbSpanText = $cb.find('span').text(); // Get label of cb
        let cbSpanSplit = cbSpanText.split('|'); // Split label to get data's from php ()
        cbSpan.text(cbSpanSplit[0]); // rename label
        let cbLabel = $cb.html(); // get whole html of cb with new name

        // set data's depending on folder tree
        if(cbSpanSplit.length == 5) // second row in root folders
        {
            jQuery('<li/>', {id: 'li-' + cbSpanSplit[1] + '-' + cbSpanSplit[2] + '-' + cbSpanSplit[3] + cbSpanSplit[4], 'data-cb-id': cbSpanSplit[4], 'data-cb-parent' : cbSpanSplit[3], 'data-cb-order': cbSpanSplit[4]}).html(cbLabel).appendTo('#ul-' + cbSpanSplit[1] + '-' + cbSpanSplit[2] + '-' + cbSpanSplit[3]);
        }
        else if(cbSpanSplit.length == 4) // second row in root folders
        {
            jQuery('<li/>', {id: 'li-' + cbSpanSplit[1] + '-' + cbSpanSplit[2] + '-' + cbSpanSplit[3], 'data-cb-id': cbSpanSplit[3], 'data-cb-parent' : cbSpanSplit[2], 'data-cb-order': cbSpanSplit[3]}).html(cbLabel).appendTo('#ul-' + cbSpanSplit[1] + '-' + cbSpanSplit[2]);
            jQuery('<ul/>', {id: 'ul-' + cbSpanSplit[1] + '-' + cbSpanSplit[2] + '-' + cbSpanSplit[3], class : 'level-3'}).appendTo(['#li-' + cbSpanSplit[1] + '-' + cbSpanSplit[2] + '-' + cbSpanSplit[3]]);
        }
        else if(cbSpanSplit.length == 3) // first row in root folders
        {
            jQuery('<li/>', {id: 'li-' + cbSpanSplit[1] + '-' + cbSpanSplit[2], 'data-cb-id': cbSpanSplit[2], 'data-cb-parent' : cbSpanSplit[1], 'data-cb-order': cbSpanSplit[2]}).html(cbLabel).appendTo('#ul-' + cbSpanSplit[1]);
            jQuery('<ul/>', {id: 'ul-' + cbSpanSplit[1] + '-' + cbSpanSplit[2], class : 'level-2'}).appendTo(['#li-' + cbSpanSplit[1] + '-' + cbSpanSplit[2]]);
        }
        else if(cbSpanSplit.length == 2) // root folders
        {
            jQuery('<li/>', {id: 'li-' + cbSpanSplit[1], class: 'first-row', 'data-cb-id': cbSpanSplit[1], 'data-cb-parent' : 0, 'data-cb-order': cbSpanSplit[1]}).html(cbLabel).appendTo('#cb-list');
            jQuery('<ul/>', {id: 'ul-' + cbSpanSplit[1], class : 'level-1'}).appendTo(['#li-' + cbSpanSplit[1]]);
        }
        $cb.remove(); // remove FormFieldMultipleCheckBox initial content html
    });

    // Tree details
    jQuery('.level-1, .level-2, .level-3').each(function(){
        if(jQuery(this).children().length == 0)
            jQuery(this).remove(); // Remove ul if empty
        else
            jQuery(this).parent().addClass('has-sub').prepend('<span class="swap-handle"></span>');  // add arrow if ul not empty         
    });

    // Animate tree on arrow click
    jQuery('.has-sub .swap-handle').each(function(){
        jQuery(this).on('click', function() {
            jQuery(this).parent().toggleClass('open');
        })
    });
    // Automatic tree opening for selected checkboxes
    jQuery('input[type="checkbox"]').each(function(){
        if(jQuery(this).is(':checked'))
        {
            let parentUl = jQuery(this).parents('ul');
            if (parentUl.parent().hasClass('has-sub'))
                parentUl.parent().addClass('open');
        }
    })
</script>