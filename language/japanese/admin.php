<?php

if (defined('FOR_XOOPS_LANG_CHECKER') || !defined('TINYCONTENT_AM_LOADED')) {
    define('TINYCONTENT_AM_LOADED', 1);

    //Admin Page Titles

    define('_TC_ADMINTITLE', 'Tiny Content');

    // SPAW

    define('_TC_SPAWLANG', 'jp');

    //Table Titles

    define('_TC_ADDCONTENT', '新規コンテンツの追加');

    define('_TC_EDITCONTENT', 'コンテンツの編集');

    define('_TC_ADDLINK', 'ページラップの追加');

    define('_TC_EDITLINK', 'ページラップの変更');

    define('_TC_ULFILE', 'ファイルのアップロード');

    define('_TC_SFILE', 'ローカルファイルの選択');

    define('_TC_DELFILE', 'ファイルの削除');

    //Table Data

    define('_TC_HOMEPAGE', 'HP');

    define('_TC_LINKNAME', 'タイトル');

    define('_TC_STORYID', 'ID');

    define('_TC_VISIBLE', '表示を許可する');

    define('_TC_TH_VISIBLE', '表示');

    define('_TC_ENABLECOM', 'コメント可能');

    define('_TC_TH_ENABLECOM', 'Com');

    define('_TC_HTML_HEADER', 'HTMLヘッダ');

    define('_TC_CONTENT', 'コンテンツ');

    define('_TC_YES', 'YES');

    define('_TC_NO', 'NO');

    define('_TC_URL', 'ファイルの選択');

    define('_TC_UPLOAD', 'アップロード');

    define('_TC_DISABLEBREAKS', '改行を＜br＞に変換しない');

    define('_TC_SUBMENU', 'サブメニューに表示する');

    define('_TC_TH_SUBMENU', 'Sub');

    define('_TC_DISP_YES', '表示する');

    define('_TC_DISP_NO', '表示しない');

    define('_TC_CONTENT_TYPE', 'コンテンツタイプ');

    define('_TC_TYPE_HTML', 'HTMLコンテンツ (bb code有効)'); // nohtml=0
    define('_TC_TYPE_HTMLNOBB', 'HTMLコンテンツ (bb code無効)'); // nohtml=2
    define('_TC_TYPE_TEXTWITHBB', 'テキストコンテンツ (bb code有効)'); // nohtml=1
    define('_TC_TYPE_TEXTNOBB', 'テキストコンテンツ (bb code無効)'); // nohtml=3
    define('_TC_TYPE_PHPHTML', 'PHPコード (bb code無効)'); // nohtml=8
    define('_TC_TYPE_PHPWITHBB', 'PHPコード (bb code有効)'); // nohtml=10
    define('_TC_TYPE_PEARWIKI', 'PEAR Wiki (bb code無効)'); // nohtml=16
    define('_TC_TYPE_PEARWIKIWITHBB', 'PEAR Wiki (bb code有効)'); // nohtml=18
    define('_TC_TYPE_PUKIWIKI', 'PukiWiki (bb code無効)'); // nohtml=32
    define('_TC_TYPE_PUKIWIKIWITHBB', 'PukiWiki (bb code有効)'); // nohtml=34 ……な～んて、独立したPukiWikiレンダーがあったら良いなあ。

    define('_TC_CHECKED_ITEMS_ARE', '右端がチェックされた記事を:');

    define('_TC_BUTTON_MOVETO', '移動');

    define('_TC_LASTMODIFIED', '最終更新日時');

    define('_TC_DONTUPDATELASTMODIFIED', '自動更新しない');

    define('_TC_CREATED', '作成日時');

    define('_TC_SAVEAS', '別レコードとして保存');

    define('_TC_LINKID', '表示順');

    define('_TC_CONTENTTYPE', 'Type');

    define('_TC_ACTION', 'アクション');

    define('_TC_EDIT', '編集');

    define('_TC_DELETE', '削除');

    define('_TC_ELINK', '変更');

    define('_TC_DELLINK', '切断');

    define('_TC_WRAPROOT', 'ページラップの基点');

    define('_TC_FMT_WRAPROOTTC', 'TinyDモジュールディレクトリ<br> (%s) <br>');

    define('_TC_FMT_WRAPROOTPAGE', 'ラップしたページと同じディレクトリ<br> (%s) <br>mod_rewriteが使えない時はこちらをお使い下さい<br>ブロックには向いていません<br>');

    define('_TC_FMT_WRAPBYREWRITE', 'mod_rewriteによる書き換え（実験中）<br> %s にアップして下さい<br>ただし、mod_rewriteを有効にする必要があります<br>ブロックには対応していません<br>');

    define('_TC_FMT_WRAPCHANGESRCHREF', 'HTMLタグ書き換え（パターン練込中）<br> ラップされたHTMLファイルの相対リンクを絶対リンクに書き換えます<br>HTMLソースコードに似た文章は誤認識してしまう恐れがあります<br>');

    define('_TC_DISABLECOM', 'コメント不可');

    define('_TC_DBUPDATED', 'データベースを更新しました');

    define('_TC_ERRORINSERT', 'データベースの更新に失敗しました');

    define('_TC_RUSUREDEL', '本当にコンテンツを削除してよろしいですか？<br>このコンテンツにつけられたコメントもすべて消えます。');

    define('_TC_RUSUREDELF', '本当にファイルを削除してよろしいですか？');

    define('_TC_UPLOADED', 'ファイルのアップロードが完了しました');

    define('_TC_FDELETED', 'フィルの削除が終わりました');

    define('_TC_ERROREXIST', '同名のファイルがあるためアップロード出来ません');

    define('_TC_ERRORUPL', 'ファイルのコピーに失敗しました');

    define('_TC_FMT_WRAPPATHPERMOFF', "<span style='font-size:xx-small;'>ページラップ用ディレクトリ(%s)は書込禁止となってます。<br>ファイルのアップロードや削除をここから行いたい場合は、書込を許可して下さい。<br>（Unixの場合はパーミッションを777か707にします）<br>おすすめは、書込禁止のままで、ページラップ用ディレクトリにFTPでファイルをアップロードする方法です。</span>");

    define('_TC_FMT_WRAPPATHPERMON', "<span style='font-size:xx-small;'>この画面からファイルのアップロードを行う方法はあまり推奨できません。可能なら、ページラップ用ディレクトリ(%s)を書込禁止(755)として、FTPでファイルをアップロードして下さい。</span>");

    define('_TC_ALTER_TABLE', 'テーブル構造更新');

    define('_TC_JS_CONFIRMDISCARD', '編集内容が破棄されますがよろしいですか？');
}
