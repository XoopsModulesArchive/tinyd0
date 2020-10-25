<?php
// Module Info Tiny_Event

if (defined('FOR_XOOPS_LANG_CHECKER') || !defined('TINYCONTENT_MI_LOADED')) {
    define('TINYCONTENT_MI_LOADED', 1);

    // The name of this module

    define('_MI_TINYCONTENT_NAME', 'TinyD');

    // A brief description of this module

    define('_MI_TINYCONTENT_DESC', '手軽にコンテンツの作れるモジュール');

    // Name for Menu Block

    define('_MI_TC_BNAME1', 'TinyD%s メニュー');

    define('_MI_TC_BNAME2', 'TinyD%s 内容表示');

    define('_MI_TC_BDESC1', 'ナビゲーションメニュー');

    define('_MI_TC_BDESC2', '各種コンテンツをブロックとして表示する [summary]タグ利用可能');

    // Admin Menu

    define('_TC_MD_ADMENU1', 'コンテンツの追加');

    define('_TC_MD_ADMENU2', 'ページラップの追加');

    define('_TC_MD_ADMENU3', 'コンテンツ管理');

    define('_TC_MD_ADMENU_MYBLOCKSADMIN', 'ブロック・アクセス権限');

    // WYSIWYG Defines for v1.4

    //define('_MI_WYSIWYG','WYSIWYGエディタ(SPAW)を使用する');

    //define('_MI_WYSIWYG_DESC','ここが有効でも、IE5.5以上でないと機能しません');

    define('_MI_COMMON_HTMLHEADER', '全コンテンツ共通HTMLヘッダ');

    define('_MI_COMMON_HTMLHEADER_DESC', 'コンテンツ・ページラップの両方について、ここで指定されたHTMLヘッダが追加されます。ご利用のテーマ内にxoops_module_headerの記述があることを確認してください');

    define('_MI_TAREA_WIDTH', '各種編集エリアの横幅');

    define('_MI_TAREA_WIDTH_DESC', '');

    define('_MI_HEADER_TAREA_HEIGHT', 'ヘッダ編集エリアの高さ');

    define('_MI_HEADER_TAREA_HEIGHT_DESC', '');

    define('_MI_TAREA_HEIGHT', 'コンテンツ編集エリアの高さ');

    define('_MI_TAREA_HEIGHT_DESC', '');

    define('_MI_FORCE_MOD_REWRITE', 'すべてのコンテンツでmod_rewriteを使う');

    define('_MI_FORCE_MOD_REWRITE_DESC', '.htaccess 等でmod_rewriteがonになっている必要があります');

    define('_MI_MODULESLESS_DIR', 'modules/のないrewriteモードでのディレクトリ名');

    define('_MI_MODULESLESS_DIR_DESC', '「すべてのコンテンツでmod_rewriteを使う」とした上で、XOOPS_ROOT_PATH/.htaccessに特定の記述が必要です<br>使わない場合は空欄にして下さい。');

    define('_MI_SPACE2NBSP', '連続したスペースを&amp;nbsp;に変換する（改行変換時）');

    define('_MI_DISPLAY_PRINT_ICON', '「印刷用画面」アイコンを表示する');

    define('_MI_DISPLAY_FRIEND_ICON', '「友達へ紹介する」アイコンを表示する');

    define('_MI_USE_TAF_MODULE', 'Tell a Friendモジュールを利用する');

    define('_MI_DISPLAY_PAGENAV', 'ページナビゲーション');

    define('_MI_DISPLAY_PAGENAV_NONE', '表示しない');

    define('_MI_DISPLAY_PAGENAV_DISP', '表示コンテンツ全てを対象とする');

    define('_MI_DISPLAY_PAGENAV_SUB', 'サブメニュー指定されたコンテンツを対象とする');

    define('_MI_DISPLAY_PAGENAV_PERSUB', 'サブメニュー指定されたコンテンツで区切る');

    define('_MI_NAVBLOCK_TARGET', 'TinyDメニューブロックでの表示対象');

    define('_MI_NAVBLOCK_TARGET_DISP', '表示コンテンツ全てのタイトル');

    define('_MI_NAVBLOCK_TARGET_SUB', 'サブメニュー指定されたコンテンツのタイトル');

    //***********************************************************************//

    // No language config below!!! Do not change this!!!                     //

    //  (TinyDではこの定数は使用していません)                                //

    //***********************************************************************//

    define('_MI_TINYCONTENT_PREFIX', 'tinycontent');

    define('_MI_DIR_NAME', 'tinycontent');
}
