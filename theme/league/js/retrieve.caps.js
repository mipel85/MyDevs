function retrieveCaps($element)
{
    let title = $element.text(),
        caps = title.match(/[A-Z]/g);
        chars = [],
        replacement = {};
    for ( i = 0; i < caps.length; i++)
    {
        chars.push('<span class="capital">'+caps[i]+'</span>');
    }
    for ( i = 0; i < caps.length; i++)
    {
        replacement[caps[i]] = chars[i];
    }
    $element.html(allReplace(title, replacement));
}

function allReplace(str, obj) {
    for (const x in obj) {
        str = str.replace(new RegExp(x, 'g'), obj[x]);
    }
    return str;
};