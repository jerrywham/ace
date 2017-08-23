<?php if(!defined("PLX_ROOT")) exit; 
$aThemes = array("chrome"=>"Chrome","clouds"=>"Clouds","crimson_editor"=>"Crimson Editor","dawn"=>"Dawn","dreamweaver"=>"Dreamweaver","eclipse"=>"Eclipse","gitHub"=>"GitHub","iplastic"=>"IPlastic","solarized_light"=>"Solarized Light","textmate"=>"TextMate","tomorrow"=>"Tomorrow","xcode"=>"XCode","kuroir"=>"Kuroir","katzenmilch"=>"KatzenMilch","sql_server"=>"SQL Server","ambiance"=>"Ambiance","chaos"=>"Chaos","clouds_midnight"=>"Clouds Midnight","cobalt"=>"Cobalt","gruvbox"=>"Gruvbox","green_on_black"=>"Green on Black","idle_fingers"=>"idle Fingers","krtheme"=>"krTheme","merbivore"=>"Merbivore","merbivore_soft"=>"Merbivore Soft","mono_industrial"=>"Mono Industrial","monokai"=>"Monokai","pastel_on_dark"=>"Pastel on dark","solarized_dark"=>"Solarized Dark","terminal"=>"Terminal","tomorrow_night"=>"Tomorrow Night","tomorrow_night_blue"=>"Tomorrow Night Blue","tomorrow_night_bright"=>"Tomorrow Night Bright","tomorrow_night_80s"=>"Tomorrow Night 80s","twilight"=>"Twilight","vibrant_ink"=>"Vibrant Ink");

	if(!empty($_POST)) {
		$plxPlugin->setParam("theme", $_POST["theme"], "string");
		$plxPlugin->setParam("fontsize", $_POST["fontsize"], "numeric");
		$plxPlugin->setParam("statiques", (isset($_POST["statiques"]) || $_POST["statiques"]=='on' ? 1 : 0), "numeric");
		$plxPlugin->setParam("articles", (isset($_POST["articles"]) || $_POST["articles"]=='on'? 1:0), "numeric");
		$plxPlugin->setParam("categories", (isset($_POST["categories"]) || $_POST["categories"]=='on'? 1:0), "numeric");
		$plxPlugin->setParam("commentaires", (isset($_POST["commentaires"]) || $_POST["commentaires"]=='on'? 1:0), "numeric");
		$plxPlugin->setParam("settings", (isset($_POST["settings"]) || $_POST["settings"]=='on'? 1:0), "numeric");
		$plxPlugin->setParam("css", (isset($_POST["css"]) || $_POST["css"]=='on'? 1:0), "numeric");
		$plxPlugin->saveParams();
		header("Location: parametres_plugin.php?p=ace");
		exit;
	}
?>
<h2><?php $plxPlugin->lang("L_TITLE") ?></h2>
<p><?php $plxPlugin->lang("L_DESCRIPTION") ?></p>
<form action="parametres_plugin.php?p=ace" method="post" style="font-size:16px;">
	<label><?php $plxPlugin->lang("L_ACE_THEME") ?> : 
		<?php plxUtils::printSelect('theme',$aThemes,$plxPlugin->getParam('theme'));?></label>
	<label><?php $plxPlugin->lang("L_FONT_SIZE") ?> : <?php plxUtils::printInput('fontsize',($plxPlugin->getParam("fontsize") <= 0 ? 16 : intval($plxPlugin->getParam("fontsize"))),'text','2-2') ?></label>
	<label><?php $plxPlugin->lang("L_USE_FOR_ARTICLES") ?> : <?php plxUtils::printInput('articles',($plxPlugin->getParam("articles") == 1 ? 'on' : ''),'checkbox','50-255',false,'','',($plxPlugin->getParam("articles") == 1 ? 'checked="checked"' : '')) ?></label>
	<label><?php $plxPlugin->lang("L_USE_FOR_STATIC_PAGES") ?> : <?php plxUtils::printInput('statiques',($plxPlugin->getParam("statiques") == 1 ? 'on' : ''),'checkbox','50-255',false,'','',($plxPlugin->getParam("statiques") == 1 ? 'checked="checked"' : '')) ?></label>
	<label><?php $plxPlugin->lang("L_USE_FOR_CATEGORIES") ?> : <?php plxUtils::printInput('categories',($plxPlugin->getParam("categories") == 1 ? 'on' : ''),'checkbox','50-255',false,'','',($plxPlugin->getParam("categories") == 1 ? 'checked="checked"' : '')) ?></label>
	<label><?php $plxPlugin->lang("L_USE_FOR_COMMENTS") ?> : <?php plxUtils::printInput('commentaires',($plxPlugin->getParam("commentaires") == 1 ? 'on' : ''),'checkbox','50-255',false,'','',($plxPlugin->getParam("commentaires") == 1 ? 'checked="checked"' : '')) ?></label>
	<label><?php $plxPlugin->lang("L_USE_FOR_SETTINGS") ?> : <?php plxUtils::printInput('settings',($plxPlugin->getParam("settings") == 1 ? 'on' : ''),'checkbox','50-255',false,'','',($plxPlugin->getParam("settings") == 1 ? 'checked="checked"' : '')) ?></label>
	<label><?php $plxPlugin->lang("L_USE_FOR_CSS") ?> : <?php plxUtils::printInput('css',($plxPlugin->getParam("css") == 1 ? 'on' : ''),'checkbox','50-255',false,'','',($plxPlugin->getParam("css") == 1 ? 'checked="checked"' : '')) ?></label>
	<br />
	<input type="submit" name="submit" value="Enregistrer"/>
</form>
