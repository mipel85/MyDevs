function retrieveCaps($element)
{
    let title = $element.text(),
        caps = title.match(/[A-Z]/g);
        chars = [],
        replacement = {};

    if (caps === null)
        return;

    for (let i = 0; i < caps.length; i++)
    {
        chars.push('<span class="capital">' + caps[i] + '</span>');
    }
    for (let i = 0; i < caps.length; i++)
    {
        replacement[caps[i]] = chars[i];
    }
    $element.html(allReplace(title, replacement));
}

function allReplace(str, replacement) {
    for (let key in replacement) {
        str = str.replace(new RegExp(key, 'g'), replacement[key]);
    }
    return str;
};