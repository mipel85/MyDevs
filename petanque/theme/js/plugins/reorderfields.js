function reorderfields(container = '#container-id', item = '.item-class', data = 'data')
{
    // reorder list from fields number
    let list = $(container);

    // Sort items depending on data-field
    let items = list.children(item).sort(function(a, b) {
        var aValue = $(a).data(data);
        var bValue = $(b).data(data);
        return aValue - bValue;
    });

    // Clean the current list
    list.empty();

    // Add ordered items
    list.append(items);
    
}