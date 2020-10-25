<?php

if (defined('FOR_XOOPS_LANG_CHECKER') || !defined('TINYCONTENT_AM_LOADED')) {
    define('TINYCONTENT_AM_LOADED', 1);

    //Admin Page Titles

    define('_TC_ADMINTITLE', 'Tiny Content');

    // SPAW

    define('_TC_SPAWLANG', 'en');

    //Table Titles

    define('_TC_ADDCONTENT', 'Inserir novo Conteúdo');

    define('_TC_EDITCONTENT', 'Editar Conteúdo');

    define('_TC_ADDLINK', 'Adicionar Página Pronta (formato HTML por ex.)');

    define('_TC_EDITLINK', 'Modificar Página Pronta');

    define('_TC_ULFILE', 'Enviar Arquivo');

    define('_TC_SFILE', 'Procurar');

    define('_TC_DELFILE', 'Remover Arquivo');

    //Table Data

    define('_TC_HOMEPAGE', 'Início');

    define('_TC_LINKNAME', 'Link do Título');

    define('_TC_STORYID', 'ID');

    define('_TC_VISIBLE', 'Vísivel');

    define('_TC_TH_VISIBLE', 'Vis');

    define('_TC_ENABLECOM', 'Habilitar Comentários');

    define('_TC_TH_ENABLECOM', 'Com');

    define('_TC_HTML_HEADER', 'HTML header');

    define('_TC_CONTENT', 'Conteúdo');

    define('_TC_YES', 'Sim');

    define('_TC_NO', 'Não');

    define('_TC_URL', 'Selecionar arquivo');

    define('_TC_UPLOAD', 'Enviar');

    define('_TC_DISABLEBREAKS', 'Desabilitar conversão LineBreak (Ativar somente se usar HTML)');

    define('_TC_SUBMENU', 'Exibir em Submenu');

    define('_TC_TH_SUBMENU', 'Sub');

    define('_TC_DISP_YES', 'Exibir');

    define('_TC_DISP_NO', 'Do Not Display');

    define('_TC_CONTENT_TYPE', 'Tipo de Página');

    define('_TC_TYPE_HTML', 'Conteúdo HTML (bb code habilitar)'); // nohtml=0
    define('_TC_TYPE_HTMLNOBB', 'Conteúdo HTML (bb code desabilitar)'); // nohtml=2
    define('_TC_TYPE_TEXTWITHBB', 'Conteúdo do Texto (bb code habilitar)'); // nohtml=1
    define('_TC_TYPE_TEXTNOBB', 'Conteúdo do Texto (bb code desabilitar)'); // nohtml=3
    define('_TC_TYPE_PHPHTML', 'Códigos PHP (bb code desabilitar)'); // nohtml=8
    define('_TC_TYPE_PHPWITHBB', 'Códigos PHP (bb code habilitar)'); // nohtml=10
    define('_TC_TYPE_PEARWIKI', 'PEAR Wiki (bb code desabilitar)'); // nohtml=16
    define('_TC_TYPE_PEARWIKIWITHBB', 'PEAR Wiki (bb code habilitar)'); // nohtml=18
    define('_TC_TYPE_PUKIWIKI', 'PukiWiki (bb code desabilitar)'); // nohtml=32 (resv)
    define('_TC_TYPE_PUKIWIKIWITHBB', 'PukiWiki (bb code habilitar)'); // nohtml=34 (resv)
    define('_TC_CHECKED_ITEMS_ARE', 'Registros conferidos:');

    define('_TC_BUTTON_MOVETO', 'Exportar (Mover)');

    define('_TC_LASTMODIFIED', 'Última Modificação');

    define('_TC_DONTUPDATELASTMODIFIED', 'Não realizar atualização automática');

    define('_TC_CREATED', 'Feito por');

    define('_TC_SAVEAS', 'Salvar como');

    define('_TC_LINKID', 'Prioridade');

    define('_TC_CONTENTTYPE', 'Tipo');

    define('_TC_ACTION', 'Ação');

    define('_TC_EDIT', 'Editar');

    define('_TC_DELETE', 'Remover');

    define('_TC_ELINK', 'Modificar');

    define('_TC_DELLINK', 'Cortar');

    define('_TC_WRAPROOT', 'Base do arquivo pronto');

    define('_TC_FMT_WRAPROOTTC', 'Mesmo como módulo de TinyContent<br> (%s) <br>');

    define('_TC_FMT_WRAPROOTPAGE', 'Mesmo como página pronta.<br> (%s) <br> usa mod_rewrite se puder.<br>');

    define('_TC_FMT_WRAPBYREWRITE', 'use mod_rewrite (experimental)<br / > transfira o HTML e outros em %s <br> não esqueça de mod_rewrite em <br>');

    define('_TC_FMT_WRAPCHANGESRCHREF', 'reescreva atributos de html (experimental)<br> esta opção reescreve ligações relativas a ligações absolutas.<br> Isto reconhece qualquer tipo de comando provavelmente como fonte de HTML <br>');

    define('_TC_DISABLECOM', 'Desabilitar comentários');

    define('_TC_DBUPDATED', 'Banco de dados atualizado com sucesso!');

    define('_TC_ERRORINSERT', 'Erro na atualização do Banco de Dados!');

    define('_TC_RUSUREDEL', 'Você tem certeza que quer excluit este conteúdo? <br> serão removidos todos os comentários junto com o conteúdo');

    define('_TC_RUSUREDELF', 'Você tem certeza que deseja remover este arquivo?');

    define('_TC_UPLOADED', 'Arquivo atualizado com Sucesso!');

    define('_TC_FDELETED', 'Arquivo Excluído com Sucesso!');

    define('_TC_ERROREXIST', 'Erro. O mesmo arquivo já existe');

    define('_TC_ERRORUPL', 'Erro no envio do arquivo! (tente outra vez!)');

    define(
        '_TC_FMT_WRAPPATHPERMOFF',
        "<span style='font-size:xx-small;'>O diretório por conteúdo (%s) não é permitido ser escrito para através de httpd. <br>Se você gostaria de transferir ou apagar arquivos por HTTP, mude a permissão de escritura em<br> recomenda-se transferir ou só apagar arquivos por ftp para segurança</span>"
    );

    define('_TC_FMT_WRAPPATHPERMON', "<span style='font-size:xx-small;'>Recomenda-se que não transfira por HTTP. Tente transferir os arquivos por FTP.</span>");

    define('_TC_ALTER_TABLE', 'Alterar Tabela');

    define('_TC_JS_CONFIRMDISCARD', 'Descartar Mudanças. OK?');
}
