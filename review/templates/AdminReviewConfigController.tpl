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

        let lv1 = cbSpanSplit[1],
            lv2 = cbSpanSplit[2],
            lv3 = cbSpanSplit[3],
            lv4 = cbSpanSplit[4],
            lv5 = cbSpanSplit[5],
            lv6 = cbSpanSplit[6],
            lv7 = cbSpanSplit[7],
            lv8 = cbSpanSplit[8];

        // set data's depending on folder tree
        if(cbSpanSplit.length == 9) // eighth row in root folders
        {
            jQuery('<li/>', {id: 'li-'+lv1+'-'+lv2+'-'+lv3+'-'+lv4+'-'+lv5+'-'+lv6+'-'+lv7+'-'+lv8, 'data-cb-id': lv8, 'data-cb-parent' : lv7, 'data-cb-order': lv8}).html(cbLabel).appendTo('#ul-'+lv1+'-'+lv2+'-'+lv3+'-'+lv47+'-'+lv5+'-'+lv6+'-'+lv7);
        }
        else if(cbSpanSplit.length == 8) // seventh row in root folders
        {
            jQuery('<li/>', {id: 'li-'+lv1+'-'+lv2+'-'+lv3+'-'+lv4+'-'+lv5+'-'+lv6+'-'+lv7, 'data-cb-id': lv7, 'data-cb-parent' : lv6, 'data-cb-order': lv7}).html(cbLabel).appendTo('#ul-'+lv1+'-'+lv2+'-'+lv3+'-'+lv47+'-'+lv5+'-'+lv6);
            jQuery('<ul/>', {id: 'ul-'+lv1+'-'+lv2+'-'+lv3+'-'+lv4+'-'+lv5+'-'+lv6, class : 'level-3'}).appendTo(['#li-'+lv1+'-'+lv2+'-'+lv3+'-'+lv4+'-'+lv5+'-'+lv6+'-'+lv7]);
        }
        else if(cbSpanSplit.length == 7) // sixth row in root folders
        {
            jQuery('<li/>', {id: 'li-'+lv1+'-'+lv2+'-'+lv3+'-'+lv4+'-'+lv5+'-'+lv6, 'data-cb-id': lv6, 'data-cb-parent' : lv5, 'data-cb-order': lv6}).html(cbLabel).appendTo('#ul-'+lv1+'-'+lv2+'-'+lv3+'-'+lv4+'-'+lv5);
            jQuery('<ul/>', {id: 'ul-'+lv1+'-'+lv2+'-'+lv3+'-'+lv4+'-'+lv5+'-'+lv6, class : 'level-3'}).appendTo(['#li-'+lv1+'-'+lv2+'-'+lv3+'-'+lv4+'-'+lv5+'-'+lv6]);
        }
        else if(cbSpanSplit.length == 6) // fifth row in root folders
        {
            jQuery('<li/>', {id: 'li-'+lv1+'-'+lv2+'-'+lv3+'-'+lv4+'-'+lv5, 'data-cb-id': lv5, 'data-cb-parent' : lv4, 'data-cb-order': lv5}).html(cbLabel).appendTo('#ul-'+lv1+'-'+lv2+'-'+lv3+'-'+lv4);
            jQuery('<ul/>', {id: 'ul-'+lv1+'-'+lv2+'-'+lv3+'-'+lv4+'-'+lv5, class : 'level-3'}).appendTo(['#li-'+lv1+'-'+lv2+'-'+lv3+'-'+lv4+'-'+lv5]);
        }
        else if(cbSpanSplit.length == 5) // forth row in root folders
        {
            jQuery('<li/>', {id: 'li-'+lv1+'-'+lv2+'-'+lv3+'-'+lv4, 'data-cb-id': lv4, 'data-cb-parent' : lv3, 'data-cb-order': lv4}).html(cbLabel).appendTo('#ul-'+lv1+'-'+lv2+'-'+lv3);
            jQuery('<ul/>', {id: 'ul-'+lv1+'-'+lv2+'-'+lv3+'-'+lv4, class : 'level-3'}).appendTo(['#li-'+lv1+'-'+lv2+'-'+lv3+'-'+lv4]);
        }
        else if(cbSpanSplit.length == 4) // third row in root folders
        {
            jQuery('<li/>', {id: 'li-'+lv1+'-'+lv2+'-'+lv3, 'data-cb-id': lv3, 'data-cb-parent' : lv2, 'data-cb-order': lv3}).html(cbLabel).appendTo('#ul-'+lv1+'-'+lv2);
            jQuery('<ul/>', {id: 'ul-'+lv1+'-'+lv2+'-'+lv3, class : 'level-3'}).appendTo(['#li-'+lv1+'-'+lv2+'-'+lv3]);
        }
        else if(cbSpanSplit.length == 3) // second row in root folders
        {
            jQuery('<li/>', {id: 'li-'+lv1+'-'+lv2, 'data-cb-id': lv2, 'data-cb-parent' : lv1, 'data-cb-order': lv2}).html(cbLabel).appendTo('#ul-'+lv1);
            jQuery('<ul/>', {id: 'ul-'+lv1+'-'+lv2, class : 'level-2'}).appendTo(['#li-'+lv1+'-'+lv2]);
        }
        else if(cbSpanSplit.length == 2) // first row in root folders
        {
            jQuery('<li/>', {id: 'li-'+lv1, class: 'first-row', 'data-cb-id': lv1, 'data-cb-parent' : 0, 'data-cb-order': lv1}).html(cbLabel).appendTo('#cb-list');
            jQuery('<ul/>', {id: 'ul-'+lv1, class : 'level-1'}).appendTo(['#li-'+lv1]);
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