<?php

namespace App\controllers;

class Langs
{
    /**
     * Get language of the server
     *
     * @return string
     */
    static function get_locale() : string
    {
        $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        foreach ($langs as $lang) {
            $lang = substr($lang, 0, 2); // Get 2 first digits of languages ('fr', 'en', etc)
            if (is_dir("lang/$lang")) {
                return $lang;
            }
        }
        return 'fr'; // Default language if none is found
    }

    /**
     * Get all lang files from the /lang/locale folder
     *
     * @return array
     */
    static function get_lang_files() : array
    {
        $locales = [];
        $dir = 'lang/' . self::get_locale();
        $files = scandir($dir);
        $files = array_diff($files, array('.', '..'));
        foreach ($files as $file) {
            $locales[] = "$dir/$file";
        }
        return $locales;
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
    function replace_lang_tag($lang) : string
    {
        $html = file_get_contents($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_URL']);
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
}