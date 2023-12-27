function reorderitems($container = '#container-id', $item = '.item-class', $data = 'data')
{
    // Define container
    let list = $($container);

    // Sort items depending on data
    let items = list.children($item).sort(function(a, b) {
        var aValue = $(a).data($data);
        var bValue = $(b).data($data);
        return aValue - bValue;
    });

    // Send reordered items list to container
    list.html(items);
    
    // Get the new items list
    items = list.children($item);
    
    // If two items have the same data content, send the second one at the end of the list
    items.each(function() {
        if ($(this).data($data) === $(this).prev().data($data))
            $(this).appendTo(list);
    });
}