<?php

/**
 * Get language of the server
 *
 * @return string
 */
function get_language() : string
{
    $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
    foreach ($langs as $lang) {
        $lang = substr($lang, 0, 2); // Get 2 first digits of languages ('fr', 'en', etc)
        if (is_dir("lang/$lang")) {
            return $lang;
        }
    }
    return 'en'; // Default language if none is found
}

/**
 * Get all lang files from the /lang/locale
 *
 * @return array
 */
function get_lang_files() : array
{
    $locales = [];
    $dir = 'lang/' . get_language();
    $files = scandir($dir);
    $files = array_diff($files, array('.', '..'));
    foreach ($files as $file) {
        $locales[] = "$dir/$file";
    }
    return $locales;
}

function current_content()
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $page = file_get_contents($protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    // var_dump($page);
    return $page;
}

// Todo
//$html must be the content of the current page the function below (current_content()) doesn't work
/**
 * replace {@text.variable} by <?= $lang['text.variable'] ?> in dom
 *
 * @param  string $html the html content of the current page ############## FAIL return error from L10 : $_SERVER['HTTP_ACCEPT_LANGUAGE'] ####################
 * @param  mixed $lang the variable from files in /lang
 * @return string
 */
function replace_lang_tag($html, $lang) : string
{
    $pattern = '/\{@(.*?)\}/';
    preg_match_all($pattern, $html, $matches);
    foreach ($matches[1] as $match) {
        if (isset($lang[$match])) {
            $replacement = '<?= $lang[\'' . $match . '\'] ?>';
            $html = str_replace('{@' . $match . '}', $replacement, $html);
        }
    }

    return $html;
}

foreach (get_lang_files() as $path) { include($path); }
// current_content();
// replace_lang_tag($page, $lang);


?>