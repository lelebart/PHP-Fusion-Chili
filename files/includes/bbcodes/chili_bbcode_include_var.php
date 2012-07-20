<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: chili_bbcode_include_var.php
| Author: slawekneo
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

$chili_button_list = ""; $i=1; $chili_langs = array();
require INCLUDES."bbcodes/chili/chili_settings.php";
if(isset($chili_langs) && is_array($chili_langs) && count($chili_langs) != 0) {
	foreach($chili_langs as $lang => $cdata) {
		if($cdata['visable']) {
			$chili_button_list .= ($i > 1 ? "<br />\n" : ""); 
			$chili_button_list .= "<input type='button' value='".$cdata['show']."' class='button' style='width:100px' onclick=\"addText('".$textarea_name."', '[chili=".$lang."]', '[/chili]', '".$inputform_name."');return false;\" />\n";
			$i++;
		}
	}
}

$__BBCODE__[] = 
array(
	"description"		=>	$locale['chili_01'],
	"value"				=>	"chili",
	"bbcode_start"		=>	"[chili=".$locale['chili_02']."]",
	"bbcode_end"		=>	"[/chili]",
	"usage"				=>	"[chili=".$locale['chili_02']."]".$locale['chili_03']."[/chili]",
	'onclick'			=>	"return overlay(this, 'bbcode_chili_".$textarea_name."', 'rightbottom');",
	'onmouseover'		=>	"",
	'onmouseout'		=>	"",
	'html_start'		=>	"<div id='bbcode_chili_".$textarea_name."' class='tbl1' style='display: none; border:1px solid black; position: absolute; width: auto; height: auto; text-align: center' onclick=\"overlayclose('bbcode_chili_".$textarea_name."');\">",
	'includejscript'	=>	"",
	'calljscript'		=>	"",
	'phpfunction'		=>	"",
	'html_middle'		=>	$chili_button_list,
	'html_end'			=>	"</div>"
);
?>