function reorderfields($container = '#container-id', $item = '.item-class', $data = 'data')
{
    // reorder list from fields number
    let list = $($container);

    // Sort items depending on data-field
    let items = list.children($item).sort(function(a, b) {
        var aValue = $(a).data($data);
        var bValue = $(b).data($data);
        return aValue - bValue;
    });

    list.html(items);
    
    let items_number = list.children($item);
    
    items_number.each(function(i, e) {
        if ($(this).data($data) === $(this).prev().data($data))
            $(this).appendTo(list);
    });
}