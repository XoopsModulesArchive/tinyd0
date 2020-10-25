<?php

// Module Info Tiny Content
if (defined('FOR_XOOPS_LANG_CHECKER') || !defined('TINYCONTENT_MI_LOADED')) {
    define('TINYCONTENT_MI_LOADED', 1);

    // The name of this module

    define('_MI_TINYCONTENT_NAME', 'TinyD');

    // A brief description of this module

    define('_MI_TINYCONTENT_DESC', 'Criando conteúdo feito tão fácil quanto pode ser.');

    // Name for Menu Block

    define('_MI_TC_BNAME1', 'TinyD %s Menu');

    define('_MI_TC_BNAME2', 'TinyD %s Conteúdo');

    define('_MI_TC_BDESC1', 'Construindo a navegação');

    define('_MI_TC_BDESC2', 'Mostre um conteúdo como um bloco. [resumo] tag válida');

    // Admin Menu

    define('_TC_MD_ADMENU1', 'Inserir Conteúdo');

    define('_TC_MD_ADMENU2', 'Adicionar conteúdo pronto');

    define('_TC_MD_ADMENU3', 'Editar/Remover Conteúdo');

    define('_TC_MD_ADMENU_MYBLOCKSADMIN', 'Blocos/Grupos');

    // WYSIWYG Defines for v1.4

    //define('_MI_WYSIWYG','Use Wysiwyg Editor?');

    //define('_MI_WYSIWYG_DESC','');

    define('_MI_COMMON_HTMLHEADER', 'Cabeçalhos HTML header');

    define('_MI_COMMON_HTMLHEADER_DESC', 'Cheque a tag xoops_module_header existe em seu tema');

    define('_MI_TAREA_WIDTH', 'Largura do TextAreas');

    define('_MI_TAREA_WIDTH_DESC', '');

    define('_MI_HEADER_TAREA_HEIGHT', 'Altura do TextArea para cabeçalho HTML');

    define('_MI_HEADER_TAREA_HEIGHT_DESC', '');

    define('_MI_TAREA_HEIGHT', 'Altura de TextArea para body');

    define('_MI_TAREA_HEIGHT_DESC', '');

    define('_MI_FORCE_MOD_REWRITE', 'usar mod_rewrite par este módulo');

    define('_MI_FORCE_MOD_REWRITE_DESC', 'Não esqueça de mod_rewrite renomeiar o .htaccess.rewrite para .htaccess');

    define('_MI_MODULESLESS_DIR', 'Nome do diretório com módulos/menos modo?');

    define('_MI_MODULESLESS_DIR_DESC', 'implementação experimental. você deveria somar alguns artigos específicos em XOOPS_ROOT_PATH /. htaccess < br / > deixe espaço em branco normalmente');

    define('_MI_SPACE2NBSP', 'espaço dobrado é mudado como space+&amp;nbsp; (quando linebreak selecionado)');

    define('_MI_DISPLAY_PRINT_ICON', 'Ícone de exibições de "Impressora"');

    define('_MI_DISPLAY_FRIEND_ICON', 'Ícone de exibições de "Recomendo ao amigo"');

    define('_MI_USE_TAF_MODULE', 'Modo visitante "Fale para um Amigo" ');

    define('_MI_DISPLAY_PAGENAV', 'Navegação de Página');

    define('_MI_DISPLAY_PAGENAV_NONE', 'Não mostrar');

    define('_MI_DISPLAY_PAGENAV_DISP', 'Visualizar todos conteúdos');

    define('_MI_DISPLAY_PAGENAV_SUB', 'Só conteúdos de submenu');

    define('_MI_DISPLAY_PAGENAV_PERSUB', 'Divida através de submenu');

    define('_MI_NAVBLOCK_TARGET', 'Target para bloco de tinycontent');

    define('_MI_NAVBLOCK_TARGET_DISP', 'Títulos de conteúdos todos visíveis');

    define('_MI_NAVBLOCK_TARGET_SUB', 'Títulos de só conteúdos de submenu');

    //***********************************************************************//

    // No language config below!!! Do not change this!!! //

    // (These constants are not used in Duplicatable) //

    //***********************************************************************//

    define('_MI_TINYCONTENT_PREFIX', 'tinycontent');

    define('_MI_DIR_NAME', 'tinycontent');
}
