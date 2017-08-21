<?php
class ace extends plxPlugin {

	public function __construct($default_lang) {
		# appel du constructeur de la classe plxPlugin (obligatoire)
		parent::__construct($default_lang);

		# limite l'accès à l'écran d'administration du plugin
		# PROFIL_ADMIN , PROFIL_MANAGER , PROFIL_MODERATOR , PROFIL_EDITOR , PROFIL_WRITER
		$this->setConfigProfil(PROFIL_ADMIN);
		
		# Déclaration d'un hook (existant ou nouveau)
		$this->addHook('AdminArticleFoot','AdminArticleFoot');
		$this->addHook('AdminCategoryFoot','AdminCategoryFoot');
		$this->addHook('AdminCommentFoot','AdminCommentFoot');
		$this->addHook('AdminCommentNewFoot','AdminCommentNewFoot');
		$this->addHook('AdminSettingsDisplayFoot','AdminSettingsDisplayFoot');
		$this->addHook('AdminSettingsEdittplFoot','AdminSettingsEdittplFoot');
		$this->addHook('AdminUser','AdminUser');
		$this->addHook('AdminProfil','AdminProfil');
		$this->addHook('AdminStaticFoot','AdminStaticFoot');
		$this->addHook('AdminPluginCss','AdminPluginCss');

		
	}

	# Activation / désactivation
	public function OnActivate() {
		# code à exécuter à l’activation du plugin
		$css = '.ace_editor {position: relative;min-width: 500px;min-height:500px;z-index: 0;}';
		file_put_contents(PLX_ROOT.PLX_CONFIG_PATH.'plugins/ace.admin.css',$css,FILE_APPEND);
	}
	public function OnDeactivate() {
		# code à exécuter à la désactivation du plugin
		if (file_exists(PLX_ROOT.PLX_CONFIG_PATH.'plugins/ace.admin.css')) {
			unlink(PLX_ROOT.PLX_CONFIG_PATH.'plugins/ace.admin.css');
		}
	}

	/**
	 * @param string id du champ dans lequel on veut utiliser ace, sans le prefixe "id_"
	 * @param string id du formulaire, sans le préfixe "id_"
	 * @param bool initialiser ace dans la page (à n'utiliser qu'une fois dans la même page)
	 * @param string mode à utiliser spécifiquement dans le champ malgré le réglage principal
	 * @return void
	 *
	 * @author Cyril MAGUIRE
	 */
	private function addAce($nameOfTextarea,$form='',$init=true,$mode='php')
	{
		$plxAdmin = plxAdmin::getInstance();
		if ($init === true) {
			echo '
			<script src="'.plxUtils::getRacine().$plxAdmin->aConf['racine_plugins'].'ace/src/emmet-core/emmet.js"></script>
			<script src="'.plxUtils::getRacine().$plxAdmin->aConf['racine_plugins'].'ace/src/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
			<script src="'.plxUtils::getRacine().$plxAdmin->aConf['racine_plugins'].'ace/src/src-noconflict/ext-emmet.js"></script>
			<script src="'.plxUtils::getRacine().$plxAdmin->aConf['racine_plugins'].'ace/src/src-noconflict/ext-language_tools.js"></script>
			<script>
    		ace.require("ace/ext/language_tools");
			var allLabels = document.getElementsByTagName("label");
			var labelLength = allLabels.length;
			for(i=0;i<labelLength;i++) {
				if (allLabels[i].htmlFor == "id_'.$nameOfTextarea.'") {
					var etiquette = allLabels[i].innerHTML + " <small>'.$this->getLang('L_KEYBINDING_MENU').' (win: \"Ctrl-Alt-h\", mac: \"Command-Alt-h\")</small>";
					allLabels[i].innerHTML = etiquette;
				}
			}
			</script>
			';
		}
		echo '
		<script type="text/javascript" charset="utf-8">
	        var area'.$nameOfTextarea.' = document.getElementById("id_'.$nameOfTextarea.'");
	        area'.$nameOfTextarea.'.style.display = "none";
	        var formulaire'.$nameOfTextarea.' = document.getElementById("'.$form.'");
	        var newarea'.$nameOfTextarea.' = document.createElement(\'div\');
	        newarea'.$nameOfTextarea.'.setAttribute(\'id\',\'id_'.$nameOfTextarea.'2\');
	        area'.$nameOfTextarea.'.parentNode.insertBefore(newarea'.$nameOfTextarea.',area'.$nameOfTextarea.');
	        newarea'.$nameOfTextarea.'.style.fontSize = "'.$this->getParam('fontsize').'px";

		    var editor'.$nameOfTextarea.' = ace.edit("id_'.$nameOfTextarea.'2");
    		editor'.$nameOfTextarea.'.session.setMode("ace/mode/'.$mode.'");
   	 		editor'.$nameOfTextarea.'.setTheme("ace/theme/'.$this->getParam('theme').'");
    		editor'.$nameOfTextarea.'.getSession().setUseWrapMode(true);
		    editor'.$nameOfTextarea.'.setOption("enableEmmet", true);
		    editor'.$nameOfTextarea.'.$blockScrolling = Infinity
		    // enable autocompletion and snippets
		    editor'.$nameOfTextarea.'.setOptions({
		        enableBasicAutocompletion: true,
		        enableSnippets: true,
		        enableLiveAutocompletion: true
		    });
		    // add command to lazy-load keybinding_menu extension
	        editor'.$nameOfTextarea.'.commands.addCommand({
	            name: "showKeyboardShortcuts",
	            bindKey: {win: "Ctrl-Alt-h", mac: "Command-Alt-h"},
	            exec: function(editor'.$nameOfTextarea.') {
	                ace.config.loadModule("ace/ext/keybinding_menu", function(module) {
	                    module.init(editor'.$nameOfTextarea.');
	                    editor'.$nameOfTextarea.'.showKeyboardShortcuts()
	                })
	            }
	        });
	        editor'.$nameOfTextarea.'.getSession().setValue(area'.$nameOfTextarea.'.value);
	        formulaire'.$nameOfTextarea.'.addEventListener(\'submit\', function(e){
		    	area'.$nameOfTextarea.'.value = editor'.$nameOfTextarea.'.getValue();
		    });
		</script>
		';
		
	}
	
	# HOOKS
	public function AdminArticleFoot(){
		if ($this->getParam('articles') == 1) {
			$this->addAce('chapo','form_article');
			$this->addAce('content','form_article',false);
		}
	}
	public function AdminCategoryFoot(){
		if ($this->getParam('categories') == 1) {
			$this->addAce('content','form_category');
		}
	}
	public function AdminCommentFoot(){
		if ($this->getParam('commentaires') == 1) {
			$this->addAce('content','form_comment');
		}
	}
	public function AdminCommentNewFoot(){
		if ($this->getParam('commentaires') == 1) {
			$this->addAce('content','form_comment');
		}
	}
	public function AdminSettingsDisplayFoot(){
		if ($this->getParam('settings') == 1) {
			$this->addAce('content','form_settings');
		}
	}
	public function AdminSettingsEdittplFoot(){
		if ($this->getParam('settings') == 1) {
			$this->addAce('content','form_edittpl');
		}
	}
	public function AdminUser(){
		if ($this->getParam('settings') == 1) {
			$this->addAce('content','form_user');
		}
	}
	public function AdminProfil(){
		if ($this->getParam('settings') == 1) {
			$this->addAce('content','form_profil');
		}
	}
	public function AdminStaticFoot(){
		if ($this->getParam('statiques') == 1) {
			$this->addAce('content','form_static');
		}
	}
	public function AdminPluginCss(){
		if ($this->getParam('css') == 1) {
			$this->addAce('frontend','form_file',true,'css');
			$this->addAce('backend','form_file',false,'css');
		}
	}
}





/* Pense-bête:
 * Récuperer des parametres du fichier parameters.xml
 *	$plxPlugin->getParam("<nom du parametre>")
 *	$plxPlugin-> setParam ("param1", 12345, "numeric")
 *	$plxPlugin->saveParams()
 *
 *	plxUtils::strCheck($string) : sanitize string
 *
 * 
 * Quelques constantes utiles: 
 * PLX_CORE
 * PLX_ROOT
 * PLX_CHARSET
 * PLX_CONFIG_PATH
 * PLX_PLUGINS
 *
 * Appel de HOOK
 *	eval($plxShow->callHook("ThemeEndHead","param1"))  ou eval($plxShow->callHook("ThemeEndHead",array("param1","param2")))
 *	ou $retour=$plxShow->callHook("ThemeEndHead","param1"));
 */
?>
