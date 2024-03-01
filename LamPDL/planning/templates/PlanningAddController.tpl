# IF C_AUTH #
    <a id="add-item" href="{ADD_ITEM}" class="button success">{@planning.item.add}</a>
    <script>
        jQuery('#filters-1')
            .css({
                display: 'flex',
                'justify-content': 'space-between'
            })
            .prepend(jQuery('#add-item'));
    </script>
# ENDIF #