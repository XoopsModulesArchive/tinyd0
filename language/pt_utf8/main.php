<?php

if (defined('FOR_XOOPS_LANG_CHECKER') || !defined('tc_convert_wrap_to_ie')) {
    define('TINYCONTENT_MB_LOADED', 1);

    define('_TC_FMT_DEFAULT_COMMENT_TITLE', 'Re: %s');

    define('_TC_FILENOTFOUND', 'Arquivo não achado! Por favor confira a URL!');

    define('_TC_PRINTERFRIENDLY', 'Imprimir');

    define('_TC_SENDSTORY', 'Enviar para um Amigo');

    define('_TC_NEXTPAGE', 'Próximo');

    define('_TC_PREVPAGE', 'Anterior');

    define('_TC_TOPOFCONTENTS', 'Mais visualizados');

    // whether parameter for "mailto:" is already rawurlencoded

    define('_TC_DONE_MAILTOENCODE', false);

    // %s is your site name. for single byte languages (ignored when _TC_DONE_MAILTOENCODE is true)

    define('_TC_INTARTICLE', 'Mais interessados %s');

    define('_TC_INTARTFOUND', 'Isto é muito interessante achei %s');

    // for multibyte languages (ignored when _TC_DONE_MAILTOENCODE is false)

    define('_TC_MB_INTARTICLE', '');

    define('_TC_MB_INTARTFOUND', '');

    // %s represents your site name

    define('_TC_THISCOMESFROM', 'Este artigo vem de %s');

    define('_TC_URLFORSTORY', 'A URL para este artigo é:');
}
if (!defined('FOR_XOOPS_LANG_CHECKER') && !function_exists('tc_convert_wrap_to_ie')) {
    function tc_convert_wrap_to_ie($str)
    {
        return $str;
    }
}
