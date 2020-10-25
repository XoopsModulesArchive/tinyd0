<?php

if (defined('FOR_XOOPS_LANG_CHECKER') || !defined('TINYCONTENT_MB_LOADED')) {
    define('TINYCONTENT_MB_LOADED', 1);

    define('_TC_FMT_DEFAULT_COMMENT_TITLE', 'Re: %s');

    define('_TC_FILENOTFOUND', 'ファイルが見つかりません。URLを確認して下さい');

    define('_TC_PRINTERFRIENDLY', 'プリンタ出力用画面');

    define('_TC_SENDSTORY', '友達に伝える');

    define('_TC_NEXTPAGE', '次のページ');

    define('_TC_PREVPAGE', '前のページ');

    define('_TC_TOPOFCONTENTS', 'コンテンツのトップ');

    // whether parameter for "mailto:" is already rawurlencoded

    define('_TC_DONE_MAILTOENCODE', true);

    // %s is your site name. for single byte languages (ignored when _TC_DONE_MAILTOENCODE is true)

    define('_TC_INTARTICLE', '%sで見つけた興味深い記事');

    define('_TC_INTARTFOUND', 'このサイトを見て下さい %s');

    // for multibyte languages (ignored when _TC_DONE_MAILTOENCODE is false)
    define('_TC_MB_INTARTICLE', '%97%C7%82%A2%83T%83C%83g%82%F0%8C%A9%82%C2%82%AF%82%BD%82%CC%82%C5%8F%D0%89%EE%82%B5%82%DC%82%B7');    // 「良いサイトを見つけたので紹介します」のSJIS文字列を rawurlencode() したもの
    define('_TC_MB_INTARTFOUND', '%83%54%83%43%83%67%82%CCURL');    // 「サイトのURL」のSJIS文字列を rawurlencode() したもの

    // %s represents your site name

    define('_TC_THISCOMESFROM', 'サイト名: %s');

    define('_TC_URLFORSTORY', 'この記事のURL:');
}

if (!defined('FOR_XOOPS_LANG_CHECKER') && !function_exists('tc_convert_wrap_to_ie')) {
    function tc_convert_wrap_to_ie($str)
    {
        return mb_convert_encoding($str, mb_internal_encoding(), 'auto');
    }
}
