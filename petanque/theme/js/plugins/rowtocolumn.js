function rowtocolumn(container = '#container-id', item = '.item-class', col = 'row-col', col_number = '4')
{
    let items = $(container + ' ' + item),
            itemsPerColumn = Math.ceil(items.length / col_number);

    for (let i = 0; i < col_number; i++) {
        // Select all items for the current column
        let columnItems = items.slice(i * itemsPerColumn, (i + 1) * itemsPerColumn);
        // Build column and add items
        let column = $('<div class="' + col + '"></div>').append(columnItems);
        // Add the column to the conainer
        $(container).append(column);
    }
}