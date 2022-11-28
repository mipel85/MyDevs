# INCLUDE CONTENT #

<script>
    // Create new list from FormFieldMultipleCheckBox
        // Create ul
    jQuery('<ul/>', {id : 'cb-list'}).prependTo('#onblurContainerResponseAdminReviewConfigController_folders_list').addClass('cell-flex cell-columns-4');
        // Create li For each checkbox
    jQuery('#onblurContainerResponseAdminReviewConfigController_folders_list .form-field-checkbox').each(function(){
        let $cb = jQuery(this);
        let cbSpan = $cb.find('span');
        let cbSpanText = $cb.find('span').text(); // Get label of cb
        let cbSpanSplit = cbSpanText.split('|'); // Split label to get data's from php ()
        cbSpan.text(cbSpanSplit[0]); // rename label
        let cbLabel = $cb.html(); // get whole html of cb with new name

        jQuery('<li/>').html(cbLabel).appendTo('#cb-list');
        jQuery(this).remove();
    })
</script>