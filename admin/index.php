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
//  ------------------------------------------------------------------------ //
// Author: Tobias Liegl (AKA CHAPI)                                          //
// Site: http://www.chapi.de                                                 //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //
// Hacker: GIJ=CHECKMATE (AKA GIJOE)                                         //
// Site: http://www.peak.ne.jp/xoops/                                        //
// ------------------------------------------------------------------------- //

// for Duplicatable V2.1
$mydirname = basename(dirname(__DIR__));
if (!preg_match('/^(\D+)(\d*)$/', $mydirname, $regs)) {
    echo('invalid dirname: ' . htmlspecialchars($mydirname, ENT_QUOTES | ENT_HTML5));
}
$mydirnumber = '' === $regs[2] ? '' : (int)$regs[2];

// includes
require dirname(__DIR__, 3) . '/include/cp_header.php';
require_once '../include/constants.inc.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once dirname(__DIR__) . '/class/tinyd.textsanitizer.php';
require_once dirname(__DIR__) . '/include/gtickets.php';

// also reading language files of modinfo & main
if (file_exists("../language/{$xoopsConfig['language']}/modinfo.php")) {
    include "../language/{$xoopsConfig['language']}/modinfo.php";

    include "../language/{$xoopsConfig['language']}/main.php";
} else {
    include '../language/english/modinfo.php';

    include '../language/english/main.php';
}

// emulates mb functions
if (!function_exists('mb_convert_encoding')) {
    function mb_convert_encoding($str)
    {
        return $str;
    }
}
if (!function_exists('mb_internal_encoding')) {
    function mb_internal_encoding($str)
    {
        return 'UTF-8';
    }
}

// these initializing code is provisional. they will be removed
$globals = [
    'op' => '',
'id' => 0,
];
foreach ($globals as $global => $default) {
    if (isset($_GET[$global])) {
        $$global = $_GET[$global];
    } elseif (isset($_POST[$global])) {
        $$global = $_POST[$global];
    } else {
        $$global = $default;
    }
}
$id = (int)$id;
// end of initialization

// submit redirection
if (!empty($_POST['preview']) && 'add' == $op) {
    $op = 'submit';
}
if (!empty($_POST['preview']) && 'editit' == $op) {
    $op = 'edit';
}
if (!empty($_POST['moveto']) && 'update' == $op) {
    $op = 'moveto';
}
if (!empty($_POST['cancel'])) {
    redirect_header('index.php?op=show', 0, _CANCEL);

    exit;
}

// utility variables
$mymodpath = XOOPS_ROOT_PATH . "/modules/$mydirname";
$mymodurl = XOOPS_URL . "/modules/$mydirname";
$wrap_path = XOOPS_ROOT_PATH . "/modules/$mydirname/content";
$mytablename = $xoopsDB->prefix("tinycontent{$mydirnumber}");
$myts = &TinyDTextSanitizer::getInstance();

// ------------------------------------------------------------------------- //
// Switch Statement for the different operations                             //
// ------------------------------------------------------------------------- //
$xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();
switch ($op) {
    // ------------------------------------------------------------------------- //
    // Show Content Page -> Overview                                             //
    // ------------------------------------------------------------------------- //
    default:
        $mymenu_fake_uri = $_SERVER['REQUEST_URI'] . '?op=show';
        // no break
    case 'show':
        xoops_cp_header();
        include __DIR__ . '/mymenu.php';

        if (check_browser_can_use_spaw()) {
            $can_use_spaw = true;

            $submitlink_with_spaw = "(<a href='index.php?op=submit&amp;usespaw=1' style='font-size:xx-small;'>SPAW</a>)";
        } else {
            $can_use_spaw = false;

            $submitlink_with_spaw = '';
        }

        // get all instances of TinyD using newblocks table
        $rs = $xoopsDB->query('SELECT mid FROM ' . $xoopsDB->prefix('newblocks') . " WHERE func_file='tinycontent_navigation.php'");
        $whr_mid = 'mid IN (';
        while (list($mid) = $xoopsDB->fetchRow($rs)) {
            $whr_mid .= (int)$mid . ',';
        }
        $whr_mid .= '0)';
        $rs = $xoopsDB->query('SELECT mid,dirname,name FROM ' . $xoopsDB->prefix('modules') . " WHERE $whr_mid ORDER BY weight,mid");
        $dest_tinyd_options = "<option value=''>--</option>\n";
        while (list($mid, $dirname, $name) = $xoopsDB->fetchRow($rs)) {
            if ($dirname == $mydirname) {
                continue;
            }

            if (!$xoopsUser->isAdmin($mid)) {
                continue;
            }

            $name4disp = htmlspecialchars($name, ENT_QUOTES);

            $dest_tinyd_options .= "<option value='$mid'>$name4disp</option>\n";
        }

        echo '
		<h4>' . $xoopsModule->getVar('name') . "</h4>
		<div align='right' width='95%'>
			<b>" . _TC_TH_VISIBLE . '</b>:' . _TC_VISIBLE . ' &nbsp; 
			<b>' . _TC_TH_SUBMENU . '</b>:' . _TC_SUBMENU . ' &nbsp; 
			<b>' . _TC_TH_ENABLECOM . '</b>:' . _TC_ENABLECOM . "
		</div>
		<form action='index.php' name='MainForm' method='post'>
		" . $xoopsGTicket->getTicketHtml(__LINE__) . "
		<table border='0' cellpadding='0' cellspacing='1' width='95%' class='outer'>
		<tr>
			<th>" . _TC_STORYID . '</th>
			<th>' . _TC_HOMEPAGE . '</th>
			<th>' . _TC_LINKNAME . '</th>
			<th>' . _TC_LINKID . '</th>
			<th>' . _TC_TH_VISIBLE . '</th>
			<th>' . _TC_TH_SUBMENU . '</th>
			<th>' . _TC_TH_ENABLECOM . '</th>
			<th>' . _TC_CONTENTTYPE . "</th>
			<th style='text-align:right;'>" . _TC_ACTION . "</th>
		</tr>\n";

        $result = $xoopsDB->query("SELECT storyid,blockid,title,visible,homepage,link,submenu,nocomments,nohtml,UNIX_TIMESTAMP(last_modified) FROM $mytablename ORDER BY blockid");

        while (list($id, $weight, $title, $visible, $homepage, $link, $submenu, $nocomments, $nohtml, $last_modified) = $xoopsDB->fetchRow($result)) {
            $title4show = htmlspecialchars($title, ENT_QUOTES | ENT_HTML5);

            $visible_checked = $visible ? 'checked' : '';

            $submenu_checked = $submenu ? 'checked' : '';

            $comments_checked = $nocomments ? '' : 'checked';

            if ($link > 0) {
                // page wrap

                $line_class = 'even';

                $op_for_edit = 'elink';

                $opname_for_edit = _TC_ELINK;

                $opname_for_delete = _TC_DELLINK;

                $link_to_spaw = '';

                $content_type = "WRAP$link";

                $extended_link = '';
            } else {
                // db content

                $line_class = 'odd';

                $op_for_edit = 'edit';

                $opname_for_edit = _TC_EDIT;

                $opname_for_delete = _TC_DELETE;

                if ($can_use_spaw) {
                    $link_to_spaw = "(<a href='?op=edit&amp;id=$id&amp;usespaw=1' style='font-size:xx-small;'>SPAW</a>)";
                } else {
                    $link_to_spaw = '';
                }

                switch ($nohtml) {
                    case '18':
                        $content_type = 'Text_Wiki (+bb)';
                        $extended_link = "(<a href='?op=edit&amp;id=$id&amp;useplain=1' style='font-size:xx-small;'>PLAIN</a>)";
                        break;
                    case '16':
                        $content_type = 'Text_Wiki';
                        $extended_link = "(<a href='?op=edit&amp;id=$id&amp;useplain=1' style='font-size:xx-small;'>PLAIN</a>)";
                        break;
                    case '10':
                        $content_type = 'PHP (+bb)';
                        $extended_link = "(<a href='?op=edit&amp;id=$id&amp;useplain=1' style='font-size:xx-small;'>PLAIN</a>)";
                        break;
                    case '8':
                        $content_type = 'PHP';
                        $extended_link = "(<a href='?op=edit&amp;id=$id&amp;useplain=1' style='font-size:xx-small;'>PLAIN</a>)";
                        break;
                    case '3':
                        $content_type = 'TEXT (-bb)';
                        $extended_link = '';
                        break;
                    case '2':
                        $content_type = 'HTML (-bb)';
                        $extended_link = $link_to_spaw;
                        break;
                    case '1':
                        $content_type = 'TEXT (+bb)';
                        $extended_link = '';
                        break;
                    case '0':
                        $content_type = 'HTML (+bb)';
                        $extended_link = $link_to_spaw;
                        break;
                    default:
                        $content_type = 'unknown';
                        $extended_link = '';
                }
            }

            echo "
		<tr class='$line_class'>
			<td align='right'>$id<input type='hidden' name='id[]' value='$id'></td>
			<td align='center'><input type='radio' name='homepage' value='$id' " . ($homepage ? 'checked' : '') . "></td>
			<td><a href='../index.php?id=$id'>$title4show</a></td>
			<td align='center'><input type='text' name='blockid[$id]' size='3' maxlength='8' value='$weight' style='text-align:right;'></td>
			<td align='center'><input type='checkbox' name='visible[$id]' $visible_checked></td>
			<td align='center'><input type='checkbox' name='submenu[$id]' $submenu_checked></td>
			<td align='center'><input type='checkbox' name='comments[$id]' $comments_checked></td>
			<td>$content_type</td>
			<td align='right'><a href='index.php?op=$op_for_edit&amp;id=$id'>$opname_for_edit</a> $extended_link | <a href='index.php?op=delete&amp;id=$id'>$opname_for_delete</a> | <input type='checkbox' name='checked_ids[$id]'><br>" . formatTimestamp($last_modified, 'm') . "</td>
		</tr>\n";
        }

        echo "
		<tr>
			<th colspan='9' style='text-align:right;'>
				" . _TC_CHECKED_ITEMS_ARE . "
				<input type='submit' name='moveto' value=" . _TC_BUTTON_MOVETO . " disabled='disabled'>
				<select name='dest_tinyd' onchange='document.MainForm.moveto.disabled=false;'>
					$dest_tinyd_options
				</select>
			</th>
		</tr>
	</table>
	<br>
	<div align='center'>
		<input type='hidden' name='op' value='update'>
		<input type='submit' name='submit' value=" . _SUBMIT . ">
		<input type='reset'>
	</div>
	</form>
	<table border='0' cellpadding='0' cellspacing='5'><tr>
	<td>
		<table border='0' cellpadding='0' cellspacing='1' class='outer'>
		<tr>
			<td class='odd'><a href='?op=submit'>" . _TC_ADDCONTENT . "</a> $submitlink_with_spaw</td>
		</tr>
		</table>
	</td>
	<td>
		<table border='0' cellpadding='0' cellspacing='1' class='outer'>
		<tr>
			<td class='even'><a href='?op=nlink'>" . _TC_ADDLINK . "</a></td>
		</tr>
		</table>
	</td>\n";

        echo "
		</table>
	</td>
	</tr></table>\n";

        xoops_cp_footer();
        break;
    // ------------------------------------------------------------------------- //
    // Update Content -> Show Content Page                                       //
    // ------------------------------------------------------------------------- //
    case 'update':

        // Ticket Check
        if (!$xoopsGTicket->check()) {
            redirect_header(XOOPS_URL . '/', 3, $xoopsGTicket->getErrors());
        }

        if (!is_array($_POST['id'])) {
            break;
        }
        $homepage = empty($_POST['homepage']) ? 0 : (int)$_POST['homepage'];
        foreach ($_POST['id'] as $storyid) {
            $storyid = (int)$storyid;

            if (0 == $homepage) {
                $hp_flag = 1;

                $homepage = $storyid;
            } else {
                $hp_flag = $storyid == $homepage ? 1 : 0;
            }

            $blockid = empty($_POST['blockid'][$storyid]) ? 0 : (int)$_POST['blockid'][$storyid];

            $visible = empty($_POST['visible'][$storyid]) ? 0 : 1;

            $nocomments = empty($_POST['comments'][$storyid]) ? 1 : 0;

            $submenu = empty($_POST['submenu'][$storyid]) ? 0 : 1;

            $sql = "UPDATE $mytablename SET blockid='$blockid',visible='$visible',homepage='$hp_flag',nocomments='$nocomments',submenu='$submenu',last_modified=last_modified WHERE storyid='$storyid'";

            $xoopsDB->query($sql) || die(_TC_ERRORINSERT);
        }
        redirect_header('index.php?op=show', 1, _TC_DBUPDATED);
        exit;
        break;
    // ------------------------------------------------------------------------- //
    // Show add or edit content Page                                             //
    // ------------------------------------------------------------------------- //
    case 'submit':
    case 'edit':

        xoops_cp_header();
        include __DIR__ . '/mymenu.php';

        // initialization
        if (!empty($_POST['preview'])) {
            $globals = [
                'id' => 0,
'title' => '',
'message' => '',
'visible' => 0,
'nohtml' => 0,
'nosmiley' => 0,
'nobreaks' => 0,
'nocomments' => 0,
'submenu' => 0,
'last_modified' => 0,
'created' => 0,
'html_header' => '',
            ];

            foreach ($globals as $global => $default) {
                if (isset($_POST[$global])) {
                    $$global = $myts->stripSlashesGPC($_POST[$global]);
                } else {
                    $$global = $default;
                }
            }

            $storyid = (int)$id;

            // write posted data into sesion

            $_SESSION['tinyd_preview_post'] = [
                'message' => $message,
                'nohtml' => (int)$nohtml,
                'nosmiley' => (int)$nosmiley,
                'nobreaks' => (int)$nobreaks,
            ];

        /* $content_cache = "{$mydirname}_preview_" . time() ;
        $fp = fopen( XOOPS_CACHE_PATH . '/' . $content_cache , 'w' ) ;
        if( $fp === false ) {
            unset( $_POST['preview'] ) ;
        } else {
            fwrite( $fp , $message , 65536 ) ;
            fclose( $fp ) ;
        }*/
        } elseif ('edit' == $op) {
            $result = $xoopsDB->query("SELECT storyid,title,text,visible,nohtml,nosmiley,nobreaks,nocomments,submenu,UNIX_TIMESTAMP(last_modified),UNIX_TIMESTAMP(created),html_header FROM $mytablename WHERE storyid='$id'");

            [$storyid, $title, $message, $visible, $nohtml, $nosmiley, $nobreaks, $nocomments, $submenu, $last_modified, $created, $html_header] = $xoopsDB->fetchRow($result);
        } else {
            [$storyid, $title, $message, $visible, $nohtml, $nosmiley, $nobreaks, $nocomments, $submenu, $last_modified, $created, $html_header] = [0, '', '', 1, 0, 0, 1, 0, 1, 0, 0, ''];
        }

        if ('edit' == $op) {
            $form_title = _TC_EDITCONTENT;

            $next_op = 'editit';
        } else {
            $form_title = _TC_ADDCONTENT;

            $next_op = 'add';
        }

        // get configs
        $tarea_width = empty($xoopsModuleConfig['tc_tarea_width']) ? 35 : (int)$xoopsModuleConfig['tc_tarea_width'];
        $header_tarea_height = empty($xoopsModuleConfig['tc_header_tarea_height']) ? 0 : (int)$xoopsModuleConfig['tc_header_tarea_height'];
        $body_tarea_height = empty($xoopsModuleConfig['tc_tarea_height']) ? 37 : (int)$xoopsModuleConfig['tc_tarea_height'];

        // title and textarea selection
        $js_confirm = 'if(MainForm.message.value!="") return confirm("' . _TC_JS_CONFIRMDISCARD . '");';
        echo "
		<div width='100%'>
			<span style='font-size:normal; font-weight: bold;'>
				" . $xoopsModule->getVar('name') . "
			</span>
			 &nbsp; 
			<span style='font-size:xx-small'>
				<a href='?op=$op&amp;id=$id' onclick='$js_confirm'>BB</a> &nbsp;
				<a href='?op=$op&amp;id=$id&amp;usespaw=1' onclick='$js_confirm'>SPAW</a> &nbsp;
				<a href='?op=$op&amp;id=$id&amp;useplain=1' onclick='$js_confirm'>PLAIN</a>
			</span>
		</div>\n";

        // Form target
        if (!empty($_GET['usespaw'])) {
            $form_target = 'index.php?usespaw=1';
        } elseif (!empty($_GET['useplain'])) {
            $form_target = 'index.php?useplain=1';
        } else {
            $form_target = 'index.php';
        }

        // beggining of xoopsForm
        $form = new XoopsThemeForm($form_title, 'MainForm', $form_target);

        // title
        $form->addElement(new XoopsFormText(_TC_LINKNAME, 'title', 50, 255, htmlspecialchars($title, ENT_QUOTES)));

        // html header
        if ($header_tarea_height > 0) {
            $h_area = new XoopsFormTextArea(_TC_HTML_HEADER, 'html_header', htmlspecialchars($html_header, ENT_QUOTES), $header_tarea_height, $tarea_width);

            $h_area->setExtra("style='width: {$tarea_width}em;'");

            $form->addElement($h_area);
        } else {
            $form->addElement(new XoopsFormHidden('html_header', htmlspecialchars($html_header, ENT_QUOTES)));
        }

        // content body
        $spaw_flag = false;
        if (!empty($_GET['usespaw'])) {
            // SPAW Config

            require XOOPS_ROOT_PATH . '/common/spaw/spaw_control.class.php';

            if (check_browser_can_use_spaw()) {
                ob_start();

                $sw = new SPAW_Wysiwyg('message', $message);

                $sw->show();

                $form->addElement(new XoopsFormLabel(_TC_CONTENT, ob_get_contents()));

                ob_end_clean();

                $spaw_flag = true;
            }
        }
        if (!$spaw_flag) {
            if (empty($_GET['useplain'])) {
                $t_area = new XoopsFormDhtmlTextArea(_TC_CONTENT, 'message', htmlspecialchars($message, ENT_QUOTES), $body_tarea_height, $tarea_width);
            } else {
                $t_area = new XoopsFormTextArea(_TC_CONTENT . "<br><br><br><br><a href='$mymodurl/admin/text_wiki_sample.php?lang={$xoopsConfig['language']}' target='_blak'>Text_Wiki Sample</a>", 'message', htmlspecialchars($message, ENT_QUOTES), $body_tarea_height, $tarea_width);
            }

            $t_area->setExtra("style='width: {$tarea_width}em;'");

            $form->addElement($t_area);
        }

        // options
        $option_tray = new XoopsFormElementTray(_OPTIONS, '<br>');
        // smiley
        $smiley_checkbox = new XoopsFormCheckBox('', 'nosmiley', $nosmiley);
        $smiley_checkbox->addOption(1, _DISABLESMILEY);
        $option_tray->addElement($smiley_checkbox);
        // nobreaks
        if ($spaw_flag) {
            $form->addElement(new XoopsFormHidden('nobreaks', 1));
        } else {
            $breaks_checkbox = new XoopsFormCheckBox('', 'nobreaks', $nobreaks);

            $breaks_checkbox->addOption(1, _TC_DISABLEBREAKS);

            $option_tray->addElement($breaks_checkbox);
        }
        // visible
        $visible_checkbox = new XoopsFormCheckBox('', 'visible', $visible);
        $visible_checkbox->addOption(1, _TC_VISIBLE);
        $option_tray->addElement($visible_checkbox);
        // submenu
        $submenu_checkbox = new XoopsFormCheckBox('', 'submenu', $submenu);
        $submenu_checkbox->addOption(1, _TC_SUBMENU);
        $option_tray->addElement($submenu_checkbox);
        // comments
        $comments_checkbox = new XoopsFormCheckBox('', 'comments', !$nocomments);
        $comments_checkbox->addOption(1, _TC_ENABLECOM);
        $option_tray->addElement($comments_checkbox);
        $form->addElement($option_tray);
        // end of options

        // content type
        $htmltype_select = new XoopsFormSelect(_TC_CONTENT_TYPE, 'nohtml', $nohtml);
        $htmltype_select->addOption(0, _TC_TYPE_HTML);
        $htmltype_select->addOption(2, _TC_TYPE_HTMLNOBB);
        $htmltype_select->addOption(1, _TC_TYPE_TEXTWITHBB);
        $htmltype_select->addOption(3, _TC_TYPE_TEXTNOBB);
        $htmltype_select->addOption(8, _TC_TYPE_PHPHTML);
        $htmltype_select->addOption(10, _TC_TYPE_PHPWITHBB);
        $htmltype_select->addOption(16, _TC_TYPE_PEARWIKI);
        $htmltype_select->addOption(18, _TC_TYPE_PEARWIKIWITHBB);
        $form->addElement($htmltype_select);

        // last_modified
        $lm_tray = new XoopsFormElementTray(_TC_LASTMODIFIED, '&nbsp;');
        $lm_tray->addElement(new XoopsFormLabel('', formatTimestamp($last_modified)));
        $lm_checkbox = new XoopsFormCheckBox('', 'dont_update_last_modified', 0);
        $lm_checkbox->addOption(1, _TC_DONTUPDATELASTMODIFIED);
        $lm_tray->addElement($lm_checkbox);
        $form->addElement($lm_tray);

        // created
        $form->addElement(new XoopsFormLabel(_TC_CREATED, formatTimestamp($created)));

        // buttons
        $submit_tray = new XoopsFormElementTray('', ' &nbsp; &nbsp; ');
        $submit_tray->addElement(new XoopsFormButton('', 'preview', _PREVIEW, 'submit'));
        $submit_tray->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        if ('edit' == $op) {
            $submit_tray->addElement(new XoopsFormButton('', 'saveas', _TC_SAVEAS, 'submit'));
        }
        $submit_tray->addElement(new XoopsFormButton('', 'cancel', _CANCEL, 'submit'));
        $form->addElement($submit_tray);

        // hiddens
        $form->addElement(new XoopsFormHidden('op', $next_op));
        $form->addElement(new XoopsFormHidden('id', $storyid));
        $form->addElement(new XoopsFormHidden('last_modified', $last_modified));
        // Ticket
        $GLOBALS['xoopsGTicket']->addTicketXoopsFormElement($form, __LINE__);

        /*	echo '
        <!-- tinyMCE -->
        <script language="javascript" type="text/javascript" src="/common/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
        <script language="javascript" type="text/javascript">
          tinyMCE.init({
             mode : "textareas"
          });
        </script>
        <!-- /tinyMCE -->' ;*/

        // end of xoopsForm
        $form->display();

        xoops_cp_footer();

        // preview popup
        if (!empty($_POST['preview'])) {
            // Ticket Check

            if (!$xoopsGTicket->check()) {
                redirect_header(XOOPS_URL . '/', 3, $xoopsGTicket->getErrors());
            }

            echo '
		<script type="text/javascript">
		<!--//
		preview_window = openWithSelfMain( "' . $mymodurl . '/preview.php" , "popup" , 680 , 450 ) ;
		//-->
		</script>';
        }

        break;
    // ------------------------------------------------------------------------- //
    // INSERT or UPDATE content to database                                      //
    // ------------------------------------------------------------------------- //
    case 'add':
    case 'editit':

        // Ticket Check
        if (!$xoopsGTicket->check()) {
            redirect_header(XOOPS_URL . '/', 3, $xoopsGTicket->getErrors());
        }

        $title4save = $myts->addSlashes($_POST['title']);
        $html_header4save = $myts->addSlashes($_POST['html_header']);
        $text4save = $myts->addSlashes($_POST['message']);
        $visible = empty($_POST['visible']) ? 0 : 1;
        $nohtml = empty($_POST['nohtml']) ? 0 : (int)$_POST['nohtml'];
        $nosmiley = empty($_POST['nosmiley']) ? 0 : 1;
        $nobreaks = empty($_POST['nobreaks']) ? 0 : 1;
        $nocomments = empty($_POST['comments']) ? 1 : 0;
        $submenu = empty($_POST['submenu']) ? 0 : 1;

        // hp flag is set if there are no records which has flag of homepage
        $result = $xoopsDB->query("SELECT COUNT(*) FROM $mytablename WHERE homepage>0");
        [$count_home] = $xoopsDB->fetchRow($result);
        $hp_flag = $count_home > 0 ? 0 : 1;

        $sql_set = "SET title='$title4save',text='$text4save',visible='$visible',nohtml='$nohtml',nosmiley='$nosmiley',nobreaks='$nobreaks',nocomments='$nocomments',link='0',submenu='$submenu',html_header='$html_header4save'";

        if ('add' == $op || !empty($_POST['saveas'])) {
            $sql = "INSERT INTO $mytablename $sql_set,created=NOW(),homepage='$hp_flag'";
        } else {
            // not to update last_modified

            if (!empty($_POST['dont_update_last_modified'])) {
                $sql_set .= ',last_modified=last_modified';
            }

            // change homepage only when it should be turned on

            if ($hp_flag) {
                $sql_set .= ",homepage='$hp_flag'";
            }

            $id = empty($_POST['id']) ? 0 : (int)$_POST['id'];

            $sql = "UPDATE $mytablename $sql_set WHERE storyid='$id'";
        }

        $result = $xoopsDB->query($sql) or die(_TC_ERRORINSERT);
        redirect_header('index.php?op=show', 1, _TC_DBUPDATED);
        exit;
        break;
    // ------------------------------------------------------------------------- //
    // Show new link & edit link Page                                            //
    // ------------------------------------------------------------------------- //
    case 'nlink':
    case 'elink':

        xoops_cp_header();
        include __DIR__ . '/mymenu.php';

        echo '<h4>' . $xoopsModule->getVar('name') . '</h4>';

        if (is_writable($wrap_path)) {
            // Upload File

            echo "<form name='form_name2' id='form_name2' action='index.php' method='post' enctype='multipart/form-data'>";

            echo "<table cellspacing='1' width='100%' class='outer'>";

            echo "<tr><th colspan='2'>" . _TC_ULFILE . '</th></tr>';

            echo "<tr valign='top' align='left'><td class='head' width='30%'>" . _TC_SFILE . "</td><td class='even'><input type='file' name='fileupload' id='fileupload' size='50'></td></tr>";

            echo "<tr valign='top' align='left'><td class='head'><input type='hidden' name='MAX_FILE_SIZE' id='op' value='500000'><input type='hidden' name='op' id='op' value='upload'></td><td class='even'><input type='submit' name='submit' value='" . _TC_UPLOAD . "'></td></tr>";

            echo '</table>';

            printf(_TC_FMT_WRAPPATHPERMON, $wrap_path);

            echo $xoopsGTicket->getTicketHtml(__LINE__);

            echo '</form>';

            // Delete File

            $form = new XoopsThemeForm(_TC_DELFILE, 'DelForm', 'index.php');

            $address_select = new XoopsFormSelect(_TC_URL, 'address');

            $dir_handle = dir($wrap_path);

            while ($file = $dir_handle->read()) {
                if (is_file("$wrap_path/$file") && 'index.php' != $file) {
                    $address_select->addOption($file, htmlspecialchars($file, ENT_QUOTES));
                }
            }

            $dir_handle->close();

            $form->addElement($address_select);

            $form->addElement(new XoopsFormHidden('op', 'delfile'));

            $form->addElement(new XoopsFormButton('', 'submit', _TC_DELETE, 'submit'));

            $form->display();
        } else {
            echo '<p>' . sprintf(_TC_FMT_WRAPPATHPERMOFF, $wrap_path) . '</p>';
        }

        // initialization
        if ('elink' == $op) {
            $result = $xoopsDB->query("SELECT storyid,title,visible,nocomments,address,submenu,link,UNIX_TIMESTAMP(last_modified) FROM $mytablename WHERE storyid='$id'");

            [$storyid, $title, $visible, $nocomments, $address, $submenu, $link, $last_modified] = $xoopsDB->fetchRow($result);

            $form_name = _TC_EDITLINK;

            $next_op = 'linkeditit';
        } else {
            [$storyid, $title, $visible, $nocomments, $address, $submenu, $link, $last_modified] = [0, '', 1, 0, '', 1, 1, 0];

            $form_name = _TC_ADDLINK;

            $next_op = 'addlink';
        }

        // beggining of xoopsForm for PageWrapping
        $form = new XoopsThemeForm($form_name, 'MainForm', 'index.php');

        // title
        $form->addElement(new XoopsFormText(_TC_LINKNAME, 'title', 50, 255, htmlspecialchars($title, ENT_QUOTES)));

        // a file should be wrapped
        $address_select = new XoopsFormSelect(_TC_URL, 'address', $address);
        $dir_handle = dir($wrap_path);
        while ($file = $dir_handle->read()) {
            if (is_file("$wrap_path/$file") && 'index.php' != $file) {
                $address_select->addOption($file, htmlspecialchars($file, ENT_QUOTES));
            }
        }
        $dir_handle->close();
        $form->addElement($address_select);

        // base path for wrapping
        $wraproot_radio = new XoopsFormRadio(_TC_WRAPROOT, 'wraproot', $link);
        $wraproot_radio->addOption(TC_WRAPTYPE_NORMAL, sprintf(_TC_FMT_WRAPROOTTC, $mymodpath));
        $wraproot_radio->addOption(TC_WRAPTYPE_CONTENTBASE, sprintf(_TC_FMT_WRAPROOTPAGE, $wrap_path));
        $wraproot_radio->addOption(TC_WRAPTYPE_USEREWRITE, sprintf(_TC_FMT_WRAPBYREWRITE, $wrap_path));
        $wraproot_radio->addOption(TC_WRAPTYPE_CHANGESRCHREF, sprintf(_TC_FMT_WRAPCHANGESRCHREF, $wrap_path));
        $form->addElement($wraproot_radio);

        // options
        $option_tray = new XoopsFormElementTray(_OPTIONS, '<br>');
        // visible
        $visible_checkbox = new XoopsFormCheckBox('', 'visible', $visible);
        $visible_checkbox->addOption(1, _TC_VISIBLE);
        $option_tray->addElement($visible_checkbox);
        // submenu
        $submenu_checkbox = new XoopsFormCheckBox('', 'submenu', $submenu);
        $submenu_checkbox->addOption(1, _TC_SUBMENU);
        $option_tray->addElement($submenu_checkbox);
        // comments
        $comments_checkbox = new XoopsFormCheckBox('', 'comments', !$nocomments);
        $comments_checkbox->addOption(1, _TC_ENABLECOM);
        $option_tray->addElement($comments_checkbox);
        $form->addElement($option_tray);
        // end of options

        // last_modified
        $lm_tray = new XoopsFormElementTray(_TC_LASTMODIFIED, '&nbsp;');
        $lm_tray->addElement(new XoopsFormLabel('', formatTimestamp($last_modified)));
        $lm_checkbox = new XoopsFormCheckBox('', 'dont_update_last_modified', 0);
        $lm_checkbox->addOption(1, _TC_DONTUPDATELASTMODIFIED);
        $lm_tray->addElement($lm_checkbox);
        $form->addElement($lm_tray);

        // buttons
        $submit_tray = new XoopsFormElementTray('', ' &nbsp; &nbsp; ');
        $submit_tray->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $submit_tray->addElement(new XoopsFormButton('', 'cancel', _CANCEL, 'submit'));
        $form->addElement($submit_tray);

        // hiddens
        $form->addElement(new XoopsFormHidden('op', $next_op));
        $form->addElement(new XoopsFormHidden('id', $storyid));
        $form->addElement(new XoopsFormHidden('last_modified', $last_modified));
        // Ticket
        $GLOBALS['xoopsGTicket']->addTicketXoopsFormElement($form, __LINE__);

        // end of xoopsForm
        $form->display();

        xoops_cp_footer();

        break;
    // ------------------------------------------------------------------------- //
    // INSERT or UPDATE a PageWrap to database                                   //
    // ------------------------------------------------------------------------- //
    case 'addlink':
    case 'linkeditit':

        // Ticket Check
        if (!$xoopsGTicket->check()) {
            redirect_header(XOOPS_URL . '/', 3, $xoopsGTicket->getErrors());
        }

        // security fix (thx JM2)
        $_POST['address'] = str_replace('..', '', $_POST['address']);

        $title4save = $myts->addSlashes($_POST['title']);
        $address4save = $myts->addSlashes($_POST['address']);
        $visible = empty($_POST['visible']) ? 0 : 1;
        $nocomments = empty($_POST['comments']) ? 1 : 0;
        $submenu = empty($_POST['submenu']) ? 0 : 1;
        $link = empty($_POST['wraproot']) ? 1 : (int)$_POST['wraproot'];

        // hp flag is set if there are no records which has flag of homepage
        $result = $xoopsDB->query("SELECT COUNT(*) FROM $mytablename WHERE homepage>0");
        [$count_home] = $xoopsDB->fetchRow($result);
        $hp_flag = $count_home > 0 ? 0 : 1;

        // fetch text for search from wrapped page
        $wrapped_file = "$wrap_path/{$_POST['address']}";
        $ext = mb_strtolower(mb_substr(mb_strrchr($wrapped_file, '.'), 1));
        $allowed_exts = ['html', 'htm', 'phtml', 'php', 'php3', 'php4', 'txt'];
        if (in_array($ext, $allowed_exts, true)) {
            $fp = fopen($wrapped_file, 'rb');

            if (!$fp) {
                redirect_header('index.php?op=nlink', 2, _TC_FILENOTFOUND);

                exit;
            }

            $text = addslashes(tc_convert_wrap_to_ie(strip_tags(fread($fp, 65536 * 2))));

            fclose($fp);
        } else {
            $text = '';
        }

        $sql_set = "SET title='$title4save',address='$address4save',visible='$visible',nocomments='$nocomments',submenu='$submenu',link='$link',text='$text',nohtml='0',nosmiley='0',nobreaks='0'";

        if ('addlink' == $op) {
            $sql = "INSERT INTO $mytablename $sql_set,created=NOW(),homepage='$hp_flag'";
        } else {
            // not to update last_modified

            if (!empty($_POST['dont_update_last_modified'])) {
                $sql_set .= ',last_modified=last_modified';
            }

            // change homepage only when it should be turned on

            if ($hp_flag) {
                $sql_set .= ",homepage='$hp_flag'";
            }

            $id = empty($_POST['id']) ? 0 : (int)$_POST['id'];

            $sql = "UPDATE $mytablename $sql_set WHERE storyid='$id'";
        }

        $result = $xoopsDB->query($sql) or die(_TC_ERRORINSERT);
        redirect_header('index.php?op=show', 2, _TC_DBUPDATED);
        exit;
        break;
    // ------------------------------------------------------------------------- //
    // Upload File                                                //
    // ------------------------------------------------------------------------- //
    case 'upload':

        // Ticket Check
        if (!$xoopsGTicket->check()) {
            redirect_header(XOOPS_URL . '/', 3, $xoopsGTicket->getErrors());
        }

        $source = $_FILES['fileupload']['tmp_name'];
        $fileupload_name = $_FILES['fileupload']['name'];
        if ('none' != $source && '' != $source) {
            $dest = "$wrap_path/$fileupload_name";

            if (file_exists($dest)) {
                redirect_header('index.php?op=nlink', 5, _TC_ERROREXIST);

                exit;
            }  

            if (copy($source, $dest)) {
                redirect_header('index.php?op=nlink', 2, _TC_UPLOADED);

                exit;
            }  

            redirect_header('index.php?op=nlink', 5, _TC_ERRORUPL);

            exit;

            unlink($source);
        }

        break;
    // ------------------------------------------------------------------------- //
    // Delete File - Confirmation Question                                    //
    // ------------------------------------------------------------------------- //
    case 'delfile':
        xoops_cp_header();
        include __DIR__ . '/mymenu.php';

        // security fix (thx JM2)
        $_POST['address'] = str_replace('..', '', $_POST['address']);

        xoops_confirm(['address' => $_POST['address'], 'op' => 'delfileok'] + $xoopsGTicket->getTicketArray(__LINE__), 'index.php', _TC_RUSUREDELF, _YES);
        xoops_cp_footer();
        break;
    // ------------------------------------------------------------------------- //
    // Delete it definitely                                                      //
    // ------------------------------------------------------------------------- //
    case 'delfileok':

        // Ticket Check
        if (!$xoopsGTicket->check()) {
            redirect_header(XOOPS_URL . '/', 3, $xoopsGTicket->getErrors());
        }

        // security fix (thx JM2)
        $_POST['address'] = str_replace('..', '', $_POST['address']);

        unlink("$wrap_path/{$_POST['address']}");
        redirect_header('index.php?op=nlink', 2, _TC_FDELETED);
        exit;
        break;
    // ------------------------------------------------------------------------- //
    // Delete Content - Confirmation Question                                    //
    // ------------------------------------------------------------------------- //
    case 'delete':
        xoops_cp_header();
        include __DIR__ . '/mymenu.php';
        xoops_confirm(['id' => (int)$_GET['id'], 'op' => 'deleteit'] + $xoopsGTicket->getTicketArray(__LINE__), 'index.php', _TC_RUSUREDEL, _YES);
        xoops_cp_footer();
        break;
    // ------------------------------------------------------------------------- //
    // Delete it definitely                                                      //
    // ------------------------------------------------------------------------- //
    case 'deleteit':
        // Ticket Check
        if (!$xoopsGTicket->check()) {
            redirect_header(XOOPS_URL . '/', 3, $xoopsGTicket->getErrors());
        }

        $id = empty($_POST['id']) ? 0 : (int)$_POST['id'];
        $result = $xoopsDB->query("DELETE FROM $mytablename WHERE storyid='$id'");
        xoops_comment_delete($xoopsModule->getVar('mid'), $id);
        redirect_header('index.php?op=show', 1, _TC_DBUPDATED);
        exit;
        break;
    // ------------------------------------------------------------------------- //
    // Export to the other TinyD
    // ------------------------------------------------------------------------- //
    case 'moveto':
        // Ticket Check
        if (!$xoopsGTicket->check()) {
            redirect_header(XOOPS_URL . '/', 3, $xoopsGTicket->getErrors());
        }

        $destModule = $moduleHandler->get((int)$_POST['dest_tinyd']);

        // error check
        if (empty($_POST['checked_ids']) || !is_object($destModule)) {
            redirect_header('index.php?op=show', 1, _TC_DBUPDATED);

            exit;
        }

        $dest_dirname = $destModule->getVar('dirname');
        if (!preg_match('/^(\D+)(\d*)$/', $dest_dirname, $regs)) {
            echo('invalid dirname: ' . htmlspecialchars($dest_dirname, ENT_QUOTES | ENT_HTML5));
        }
        $dest_dirnumber = '' === $regs[2] ? '' : (int)$regs[2];
        $dest_tablename = $xoopsDB->prefix("tinycontent{$dest_dirnumber}");

        $src_mid = $xoopsModule->getVar('mid');
        $dest_mid = $destModule->getVar('mid');

        // authority check
        if (!$xoopsUser->isAdmin($dest_mid)) {
            redirect_header(XOOPS_URL . '/', 1, _NOPERM);

            exit;
        }

        foreach ($_POST['checked_ids'] as $src_id => $val) {
            if (!$val) {
                continue;
            }

            $rs = $xoopsDB->query("SELECT * FROM $mytablename WHERE storyid='" . (int)$src_id . "'");

            if (!($rows = $xoopsDB->fetchArray($rs))) {
                continue;
            }

            $set_sql = '';

            foreach ($rows as $colname => $colval) {
                if ('storyid' == $colname || 'homepage' == $colname) {
                    continue;
                }

                $set_sql .= "$colname='" . addslashes($colval) . "',";
            }

            $set_sql = mb_substr($set_sql, 0, -1);

            $ins_rs = $xoopsDB->query("INSERT INTO $dest_tablename SET $set_sql");

            $dest_id = $xoopsDB->getInsertId();

            if (!$ins_rs || $dest_id <= 0) {
                redirect_header('index.php?op=show', 5, 'The target module should be updated');

                exit;
            }

            // delete the record

            $del_rs = $xoopsDB->query("DELETE FROM $mytablename WHERE storyid='" . (int)$src_id . "'");

            // moving comments

            $sql = 'UPDATE ' . $xoopsDB->prefix('xoopscomments') . " SET com_modid='$dest_mid',com_itemid='$dest_id' WHERE com_modid='$src_mid' AND com_itemid='$src_id'";

            $xoopsDB->query($sql);
        }

        redirect_header('index.php?op=show', 1, _TC_DBUPDATED);
        exit;
        break;
}

// checks browser compatibility with the control
function check_browser_can_use_spaw()
{
    return true;    // for nobunobu's spaw 2005-5-10
    $browser = $_SERVER['HTTP_USER_AGENT'];

    // check if msie

    if (eregi('MSIE[^;]*', $browser, $msie)) {
        // get version

        if (eregi("[0-9]+\.[0-9]+", $msie[0], $version)) {
            // check version

            if ((float)$version[0] >= 5.5) {
                // finally check if it's not opera impersonating ie

                if (!eregi('opera', $browser)) {
                    return true;
                }
            }
        }
    }

    return false;
}
