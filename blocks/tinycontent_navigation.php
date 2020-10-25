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

if (!defined('XOOPS_ROOT_PATH')) {
    exit;
}
$mydirname = basename(dirname(__DIR__));
if (!preg_match('/^(\D+)(\d*)$/', $mydirname, $regs)) {
    echo('invalid dirname: ' . htmlspecialchars($mydirname, ENT_QUOTES | ENT_HTML5));
}
$mydirnumber = '' === $regs[2] ? '' : (int)$regs[2];

require_once XOOPS_ROOT_PATH . "/modules/$mydirname/include/constants.inc.php";

eval('function tinycontent' . $mydirnumber . '_block_nav()
{
	return tinyd_block_nav_base( "' . $mydirname . '" , \'' . $mydirnumber . '\' ) ;
}
');

if (!function_exists('tinyd_block_nav_base')) {
    function tinyd_block_nav_base($mydirname, $mydirnumber)
    {
        // get my config

        $moduleHandler = xoops_getHandler('module');

        $configHandler = xoops_getHandler('config');

        $module = $moduleHandler->getByDirname($mydirname);

        $config = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

        $navblock_target = empty($config['tc_navblock_target']) ? 1 : (int)$config['tc_navblock_target'];

        if (empty($config['tc_modulesless_dir'])) {
            $block['mod_url'] = XOOPS_URL . "/modules/$mydirname";

            $tc_rewrite_dir = TC_REWRITE_DIR;
        } else {
            $block['mod_url'] = XOOPS_URL . '/' . $config['tc_modulesless_dir'];

            $tc_rewrite_dir = '';
        }

        $myts = MyTextSanitizer::getInstance();

        $db = XoopsDatabaseFactory::getDatabaseConnection();

        $whr_submenu = 2 == $navblock_target ? 'submenu=1' : '1';

        $result = $db->query('SELECT storyid,title,link,UNIX_TIMESTAMP(last_modified) FROM ' . $db->prefix("tinycontent{$mydirnumber}") . " WHERE visible=1 AND $whr_submenu ORDER BY blockid");

        while (list($id, $title, $link, $last_modified) = $db->fetchRow($result)) {
            if (!empty($config['tc_force_mod_rewrite']) || TC_WRAPTYPE_USEREWRITE == $link) {
                $href = $tc_rewrite_dir . sprintf(TC_REWRITE_FILENAME_FMT, $id);
            } elseif (TC_WRAPTYPE_CONTENTBASE == $link) {
                $href = "content/index.php?id=$id";
            } else {
                $href = "index.php?id=$id";
            }

            $block['links'][] = [
                'href' => $href,
                'id' => $id,
                'title' => htmlspecialchars($title, ENT_QUOTES | ENT_HTML5),
                'date' => formatTimestamp($last_modified),
                'last_modified' => $last_modified,
            ];
        }

        return $block;
    }
}
?>
