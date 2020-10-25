<?php

if (defined('FOR_XOOPS_LANG_CHECKER') || !defined('TINYCONTENT_MB_LOADED')) {
    // Appended by Xoops Language Checker -GIJOE- in 2005-04-19 18:26:42

    define('_TC_FMT_DEFAULT_COMMENT_TITLE', 'Re: %s');

    define('TINYCONTENT_MB_LOADED', 1);

    define('_TC_FILENOTFOUND', 'Filen hittades inte! VçÏligen kontrollera URL!');

    define('_TC_PRINTERFRIENDLY', 'UtskriftsvçÏlig Sida');

    define('_TC_SENDSTORY', 'Skicka denna artikel till en vçÏ');

    define('_TC_NEXTPAGE', 'NçÔta');

    define('_TC_PREVPAGE', 'F‹ÓegéÆnde');

    define('_TC_TOPOFCONTENTS', 'Index');

    // whether parameter for "mailto:" is already rawurlencoded

    define('_TC_DONE_MAILTOENCODE', false);

    // %s is your site name. for single byte languages (ignored when _TC_DONE_MAILTOENCODE is true)

    define('_TC_INTARTICLE', 'Intressant artikel på %s');

    define('_TC_INTARTFOUND', 'HçÓ çÓ en intressant artikel som jag har hittat på %s');

    // for multibyte languages (ignored when _TC_DONE_MAILTOENCODE is false)

    define('_TC_MB_INTARTICLE', '');

    define('_TC_MB_INTARTFOUND', '');

    // %s represents your site name

    define('_TC_THISCOMESFROM', 'Denna artikel kommer fréÏ %s');

    define('_TC_URLFORSTORY', 'Addressen f‹Ó denna artikel çÓ:');
}

if (!defined('FOR_XOOPS_LANG_CHECKER') && !function_exists('tc_convert_wrap_to_ie')) {
    function tc_convert_wrap_to_ie($str)
    {
        return $str;
    }
}
