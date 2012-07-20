<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: chili_bbcode_include.php
| Authors: slawekneo, lelebart
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
if ($inforum=preg_match("/\/forum\//i", FUSION_REQUEST)) { global $data; }
if(($chili_count=substr_count($text, "[php")) != 0 ) {
	for ($i=0; $i < $chili_count; $i++) {
		$text = preg_replace('#\[php\](.*?)\[/php\]#sie', "'[chili=php]\\1[/chili]'", $text);
	}
} unset($chili_count);
if(($chili_count=substr_count($text, "[geshi=html4strict")) != 0 ) {
	for ($i=0; $i < $chili_count; $i++) {
		$text = preg_replace('#\[geshi=html4strict\](.*?)\[/geshi\]#sie', "'[chili=html]\\1[/chili]'", $text);
	}
} unset($chili_count);
if(($chili_count=substr_count($text, "[geshi=javascript")) != 0 ) {
	for ($i=0; $i < $chili_count; $i++) {
		$text = preg_replace('#\[geshi=javascript\](.*?)\[/geshi\]#sie', "'[chili=js]\\1[/chili]'", $text);
	}
} unset($chili_count);
if(($chili_count=substr_count($text, "[geshi=")) != 0 ) {
	for ($i=0; $i < $chili_count; $i++) {
		$text = preg_replace('#\[geshi=(.*?)\](.*?)\[/geshi\]#sie', "'[chili=\\1]\\2[/chili]'", $text);
	}
} unset($chili_count);
if(($chili_count=substr_count($text, "[chili=")) != 0 ) {
	if(($inprint=substr_count(FUSION_SELF,"print.php")) != 1) {
		if(!defined("CHILI_FIRST_LOAD")) {
			$to_head = "<script type='text/javascript'>\n/* <![CDATA[ */\n";
			$to_head .= "var chilijq               = document.createElement('script');\n";
			$to_head .= "chilijq.src               = '".INCLUDES."bbcodes/chili/jquery.chili-2.2.js';\n";
			$to_head .= "var chilirecipes          = document.createElement('script');\n";
			$to_head .= "chilirecipes.src          = '".INCLUDES."bbcodes/chili/recipes.js';\n";
			$to_head .= "chilijq.onloadDone        = false;\n"; 
			$to_head .= "chilijq.onload = function(){\n";
			$to_head .= "\tchilijq.onloadDone      = true;\n";
			$to_head .= "\tChiliBook.automatic     = false;\n";
			$to_head .= "\tChiliBook.recipeLoading = false;\n";
			$to_head .= "\tChiliBook.lineNumbers   = true;\n";
			$to_head .= "}\n";
			$to_head .= "var cilihead              = document.getElementsByTagName('head')[0];\n";
			$to_head .= "cilihead.appendChild(chilijq);\n";
			$to_head .= "cilihead.appendChild(chilirecipes);\n";
			$to_head .= "var chiliLocale_04        = '".$locale['chili_04']."';\n";
			$to_head .= "var chiliLocale_05        = '".$locale['chili_05']."';\n";
			$to_head .= "var chiliLocale_06        = '".$locale['chili_06']."';\n";
			$to_head .= "var chiliLocale_07        = '".$locale['chili_07']."';\n";
			$to_head .= "var chilifunc             = document.createElement('script');\n";
			$to_head .= "chilifunc.src             = '".INCLUDES."bbcodes/chili/functions.js';\n";
			$to_head .= "cilihead.appendChild(chilifunc);\n";
			$to_head .= "/* ]]> */\n</script>\n";
			add_to_head($to_head);
			define("CHILI_FIRST_LOAD", TRUE);
		}
	}
	$chili_match_list = ""; $i=1; $chili_langs = array();
	require INCLUDES."bbcodes/chili/chili_settings.php";
	if(isset($chili_langs) && is_array($chili_langs) && ($chili_count_langs=count($chili_langs)) != 0) {
		foreach($chili_langs as $lang => $cdata) {
			if($cdata['visable']) {
				$chili_match_list .= ($i > 1 ? "|" : ""); 
				$chili_match_list .= $lang;
				$i++;
			}
		}
	}
	$chili_match = (!empty($chili_match_list)? $chili_match_list : "php|html|css|js|mysql|lotusscript|java|delphi|csharp|cplusplus");
	for ($i=0; $i < $chili_count; $i++) {
		$code_save = ($inforum && isset($data['post_id']) ? "<span title=\'".$locale['chili_09']."\'><a href=\'".INCLUDES."bbcodes/chili_bbcode_save.php?thread_id=".$_GET['thread_id']."&amp;post_id=".$data['post_id']."&amp;code_id=".$i."\'><img src=\'".INCLUDES."bbcodes/images/code_save.png\' alt=\'".$locale['chili_09']."\' title=\'".$locale['chili_09']."\' style=\'border:none\' /></a></span>&nbsp;&nbsp;" : "");
		if($inprint == '1') {
			$match_replace = "'<pre style=\'white-space:nowrap;\'>";
			$match_replace .= "<code class=\'\\1\' style=\'white-space:nowrap;\'>'.formatcode('\\3').'</code>";
			$match_replace .= "</pre>'";
		} else {
			$id = (isset($data['post_id']) ? $data['post_id']."a".$i : md5(get_microtime())."a".$i);
			$match_replace  = "'<div class=\'tbl-border tbl2\' style=\'width:400px\'>".$code_save."";
			$match_replace .= "<strong>".$locale['chili_10']." '.(!\$chili_count_langs ? '' : \$chili_langs['\\1']['show']).'</strong>&nbsp;";
			$match_replace .= "<span class=\'chili_button\' style=\'display:none;\'>";
			$match_replace .= "[<a id=\'chili_open_".$id."\' name=\'".$id."\' class=\'side\'>";
			$match_replace .= "<span class=\'chili_replace\'>".$locale['chili_04']."</span></a>]</span>";
			$match_replace .= "</div>";
			$match_replace .= "<div class=\'tbl-border tbl1\' style=\'width:400px;overflow:auto;\' id=\'chili_forum_code_".$id."\'>";
			$match_replace .= "<pre style=\'white-space:nowrap;\' class=\'ln-'.trim('\\2').'\'>";
			$match_replace .= "<code class=\'\\1\' id=\'chili_forum_code_to_".$id."\' style=\'white-space:nowrap;\'>'.formatcode('\\3').'";
			$match_replace .= "</code></pre></div>";
			$match_replace .= "<div class=\'tbl-border tbl2\' style=\'width:400px;white-space:nowrap;display:none;\' ";
			$match_replace .= "id=\'chili_forum_code_exec_".$id."\'>".$locale['chili_08']."</div>'";
		}
		$text = preg_replace("^\[chili=(".$chili_match.")([\s][0-9]*|)\](.*?)\[/chili\]^sie", $match_replace, $text, 1);
	}
}
?>