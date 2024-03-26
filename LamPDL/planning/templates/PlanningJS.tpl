<script>
    const trigger = jQuery('#PlanningItemFormController_more_infos'),
        target = jQuery('#PlanningItemFormController_options');
    if (trigger.is(':checked'))
        target.show();
    else
        target.hide();
    trigger.on('click', function() {
        target.toggle();
    });
</script>