<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       < http://xoops.eti.br >                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------- //
// Author: Tobias Liegl (AKA CHAPI)                                          //
// Site: http://www.chapi.de                                                 //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //
// Hacker: GIJ=CHECKMATE (AKA GIJOE)                                         //
// Site: http://www.peak.ne.jp/xoops/                                        //
// ------------------------------------------------------------------------- //

require dirname(__DIR__, 3) . '/mainfile.php';
require_once dirname(__DIR__) . '/class/tinyd.textsanitizer.php';
require_once dirname(__DIR__) . '/include/render_function.inc.php';
require_once dirname(__DIR__) . '/include/constants.inc.php';

// for "Duplicatable"
$mydirname = basename(dirname(__DIR__));
if (!preg_match('/^(\D+)(\d*)$/', $mydirname, $regs)) {
    echo('invalid dirname: ' . htmlspecialchars($mydirname, ENT_QUOTES | ENT_HTML5));
}
$mydirnumber = '' === $regs[2] ? '' : (int)$regs[2];

//
// import from common.php
//
if (file_exists(__DIR__ . '/../xoops_version.php')) {
    $moduleHandler = xoops_getHandler('module');

    $xoopsModule = $moduleHandler->getByDirname($mydirname);

    // unset($url_arr);

    if (!$xoopsModule || !$xoopsModule->getVar('isactive')) {
        require_once XOOPS_ROOT_PATH . '/header.php';

        echo '<h4>' . _MODULENOEXIST . '</h4>';

        require_once XOOPS_ROOT_PATH . '/footer.php';

        exit();
    }

    $modulepermHandler = xoops_getHandler('groupperm');

    if ($xoopsUser) {
        if (!$modulepermHandler->checkRight('module_read', $xoopsModule->getVar('mid'), $xoopsUser->getGroups())) {
            redirect_header(XOOPS_URL . '/user.php', 1, _NOPERM);

            exit();
        }
    } else {
        if (!$modulepermHandler->checkRight('module_read', $xoopsModule->getVar('mid'), XOOPS_GROUP_ANONYMOUS)) {
            redirect_header(XOOPS_URL . '/user.php', 1, _NOPERM);

            exit();
        }
    }

    if (file_exists(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/main.php')) {
        require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/main.php';
    } else {
        if (file_exists(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/english/main.php')) {
            require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/english/main.php';
        }
    }

    if (1 == $xoopsModule->getVar('hasconfig') || 1 == $xoopsModule->getVar('hascomments') || 1 == $xoopsModule->getVar('hasnotification')) {
        $xoopsModuleConfig = $configHandler->getConfigsByCat(0, $xoopsModule->getVar('mid'));
    }
}
//
// end of import from common.php
//

// utility variables
$mymodpath = XOOPS_ROOT_PATH . "/modules/$mydirname";
$mytablename = $xoopsDB->prefix("tinycontent{$mydirnumber}");

// get id of homepage
$result = $xoopsDB->query("SELECT storyid,link FROM $mytablename WHERE visible='1' ORDER BY homepage DESC, blockid");
if ($xoopsDB->getRowsNum($result) < 1) {
    redirect_header(XOOPS_URL, 2, _TC_FILENOTFOUND);

    exit;
}
[$homepage_id, $homepage_link_type] = $xoopsDB->fetchRow($result);

// check if $_GET['id'] is specified
$id = empty($_GET['id']) ? 0 : (int)$_GET['id'];
if ($id <= 0) {
    redirect_header(XOOPS_URL, 2, _TC_FILENOTFOUND);

    exit;
}

// main query
$result = $xoopsDB->query("SELECT storyid,title,text,visible,nohtml,nosmiley,nobreaks,nocomments,link,address,UNIX_TIMESTAMP(last_modified) AS last_modified,html_header FROM $mytablename WHERE storyid='$id' AND visible");
if (false === ($result_array = $xoopsDB->fetchArray($result))) {
    redirect_header(XOOPS_URL, 2, _TC_FILENOTFOUND);

    exit;
}

// disable comment feature of XOOPS
// $result_array['nocomments'] = 1 ;

// branch if op=print
if (isset($_GET['op']) && 'print' == $_GET['op']) {
    require dirname(__DIR__) . '/include/print.inc.php';
} else {
    include '../include/display.inc.php';
}
