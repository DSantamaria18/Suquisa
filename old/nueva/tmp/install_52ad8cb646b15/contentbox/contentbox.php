<?php
/*************************************
/* contentBox for prestashop
/* Made By Wozia Dev Team for emotionLoop
/* http://emotionloop.com
/* http://wozia.pt
/* http://contentbox.org/
/*
/***********************************/

if (!defined('_PS_VERSION_')) 
{
  exit;
}

class contentbox extends Module
{
	protected $maxImageSize = 9999999; //<- image size 
	public $hooks = array();
	
	
	//////////////////////////////////////
	//construct
	/////////////////////////////////////
	function __construct()
	{
		$this->name = 'contentbox';
		$this->tab = 'front_office_features';
		$this->version = '0.03';
		$this->author = 'EmotionLoop.com';
		$this->need_instance = 0;
		
		parent::__construct();

		$this->displayName = $this->l('contentBox');
		$this->description = $this->l('Place your content everywhere!');

		$get_hooks = HookCore::getHooks();

		list($v1,$v2,$v3) = explode( '.', _PS_VERSION_ );
		//magic code to add on the fly all the hooks
		
		if ( (int)$v1 == 1 && (int)$v2 == 4 )
		{ //version 1.4.X
			foreach( $get_hooks as $hook ) {
				//ignore the RightColumn hook
				$hook_name = 'hook'.ucwords($hook['name']);
				//if ( $hook_name == 'hookRightColumn' ) { continue; }
				if ( !empty( $hook['position'] ) ) {
				$this->hooks[] = strtolower ('hook'.$hook['name']);
				}
			}
		}
		if ( (int)$v1 == 1 && (int)$v2 == 5 )
		{ //version 1.5.X
			foreach( $get_hooks as $hook ) {
				$test_hook = ( strpos($hook['name'],'display') === 0 )? true : false;
				if ( !empty( $test_hook ) ) {
					$hook_name = str_replace( 'display','hook',$hook['name'] );
					if ( $hook_name == 'hookdisplayRightColumn' ) { continue; }
					 $this->hooks[] = strtolower('hook'.$hook['name']);
				}
			}
		}
	}
	
		
	public function __call($method, $args)
	{
		//if hook exists
		if(function_exists($method)) { 
			return call_user_func_array($method, $args);
		}
		
		//check if it is one other hook
		$test_dynamic_hooks = ( in_array( strtolower ($method) , $this->hooks ) )? true : false;
		if ( !empty( $test_dynamic_hooks ) ) {
			return $this->hookdisplayRightColumn($args[0]);   
		}
	}
	
	///////////////////////////////////////////////////////////////////////////
	// needed for prestashop 1.4.9
	// in this version call is ignored by method_exists() on Module::hookExec()
	//////////////////////////////////////////////////////////////////////////
	function hookRightColumn($params){return $this->hookdisplayRightColumn($params);}
	function hookLeftColumn($params){return $this->hookdisplayRightColumn($params);}
	function hookCenter($params){ return $this->hookdisplayRightColumn($params);}
	function hookFooter($params){ return $this->hookdisplayRightColumn($params);}
	function hookHome($params){return $this->hookdisplayRightColumn($params);}
	function hookTop($params){return $this->hookdisplayRightColumn($params);}
	function hookHeader($params){return $this->hookdisplayRightColumn($params);}
	function hookCustomerAccount($params){return $this->hookdisplayRightColumn($params);}
	function hookCreateAccountForm($params){return $this->hookdisplayRightColumn($params);}
	function hookCreateAccount($params){return $this->hookdisplayRightColumn($params);}
	function hookCreateAccountTop($params){return $this->hookdisplayRightColumn($params);}
	function hookAdminCustomers($params){return $this->hookdisplayRightColumn($params);}
	function hookOrderConfirmation($params){return $this->hookdisplayRightColumn($params);}
	function hookUpdateOrderStatus($params){return $this->hookdisplayRightColumn($params);}
	function hookProductFooter($params){return $this->hookdisplayRightColumn($params);}
	function hookPaymentReturn($params){return $this->hookdisplayRightColumn($params);}
	function hookBackBeforePayment($params){return $this->hookdisplayRightColumn($params);}
	function hookShoppingCartExtra($params){return $this->hookdisplayRightColumn($params);}
	function hookPayment($params){return $this->hookdisplayRightColumn($params);}
	function hookCancelProduct($params){return $this->hookdisplayRightColumn($params);}
	function hookNewOrder($params){return $this->hookdisplayRightColumn($params);}
	function hookShoppingCart($params){return $this->hookdisplayRightColumn($params);}
	function hookOrderReturn($params){return $this->hookdisplayRightColumn($params);}
	function hookMyAccountBlock($params){return $this->hookdisplayRightColumn($params);}
	function hookExtraRight($params){return $this->hookdisplayRightColumn($params);}
	function hookExtraLeft($params){return $this->hookdisplayRightColumn($params);}
	function hookAuthentication($params){return $this->hookdisplayRightColumn($params);}
	function hookProductTabContent($params){return $this->hookdisplayRightColumn($params);}
	function hookProductTab($params){return $this->hookdisplayRightColumn($params);}
	function hookProductOutOfStock($params){return $this->hookdisplayRightColumn($params);}
	function hookUpdateQuantity($params){return $this->hookdisplayRightColumn($params);}
	function hookSearch($params){return $this->hookdisplayRightColumn($params);}
	function hookExtraCarrier($params){return $this->hookdisplayRightColumn($params);}
	function hookProductActions($params){return $this->hookdisplayRightColumn($params);}
	///////////////////////////////////////////////////////////////////////////
	// needed for prestashop 1.4.9
	//////////////////////////////////////////////////////////////////////////
	
	//////////////////////////////////////
	//install
	/////////////////////////////////////
	public function install()
	{
		if (!parent::install())
			return false;
		if (!$this->registerHook('leftColumn'))
			return false;
		return true;
	}

	
	//////////////////////////////////////
	//the default hook -> hookRightColumn
	/////////////////////////////////////
	function hookdisplayRightColumn($params)
	{
		//try to access the content file (content.xml)
		if (file_exists(dirname(__FILE__).'/content.xml'))
		{
			//load content.xml contents
			if ($xml = simplexml_load_file(dirname(__FILE__).'/content.xml'))
			{
				global $cookie, $smarty;
				$lang = (isset($cookie->id_lang) && $cookie->id_lang !='')? $cookie->id_lang : '4';
				$smarty->assign(array(
					'content' => $xml->{'content_'.$lang}
				));
				return $this->display(__FILE__, 'contentbox.tpl');
			}
		}
		return false;
	}
	
	//////////////////////////////////////
	//grab contents and check for file permissions
	/////////////////////////////////////
	function getContent()
	{
		$this->_html = '<h2>'.$this->displayName.'</h2>';
		
		//test images folder permissions
		if ( !is_writable(dirname(__FILE__)."/imgs/") ) {
			$this->_html .= $this->displayError( 'FOLDER PERMISSIONS ERROR: <br/>writing access denied on '.dirname(__FILE__).'/imgs/ <br/> ' );
		}
		
		
		//remove images
		if(isset($_POST['deleteImage']) && $_POST['deleteImage'] != ''){
			$tmp_file = strip_tags($_POST['deleteImage']);
			unlink(dirname(__FILE__).'/imgs/'.$tmp_file);
		}		
		//check for form submit
		if (isset($_POST['submitUpdate']))
		{
			$forbidden = array('submitUpdate');
			$newXml = '<?xml version=\'1.0\' encoding=\'utf-8\' ?>'."\n";
			$newXml .= '<html>'."\n";
			foreach ($_POST AS $key => $field)
			{
				if (_PS_MAGIC_QUOTES_GPC_)
					$field = stripslashes($field);
				if ($line = $this->putContent($newXml, $key, $field, $forbidden, 'header'))
					$newXml .= $line;
			}
			$newXml .= "\n</html>\n";

			if ($fd = @fopen(dirname(__FILE__).'/content.xml', 'w'))
			{
				if (!@fwrite($fd, $newXml))
					$this->_html .= $this->_errorText(1);
				if (!@fclose($fd))
					$this->_html .= $this->_errorText(2);
			}
			else
				$this->_html .= $this->_errorText(3);
		}
			if (isset($_FILES['module_img']) AND isset($_FILES['module_img']['tmp_name']) AND !empty($_FILES['module_img']['tmp_name']))
			{
				Configuration::set('PS_IMAGE_GENERATION_METHOD', 1);
				if(file_exists(dirname(__FILE__)."/imgs/" . $_FILES["module_img"]["name"])){
					$tmp_name = explode('.',$_FILES["module_img"]["name"]);
					$tmp_ext = end($tmp_name);
					array_pop($tmp_name);
					$tmp_name = implode('.',$tmp_name);
					$tmp_new_img_name = dirname(__FILE__)."/imgs/".$tmp_name;
					
					$control_loop = false;
					$tmp_i = 1;
					while ($control_loop == false){
						if(file_exists($tmp_new_img_name.'('.$tmp_i.').'.$tmp_ext )){
							++ $tmp_i;
						}else{ 
							$_FILES["module_img"]["name"] = $tmp_name.'('.$tmp_i.').'.$tmp_ext; 
							$control_loop = true;
						}
					}
				}
				
				if ($error = checkImage($_FILES['module_img'], $this->maxImageSize))
						 $this->_html .= $this->displayError( $error );
				elseif (!imageResize($_FILES['module_img']['tmp_name'], dirname(__FILE__).'/imgs/'.$_FILES["module_img"]["name"]))
					$this->_html .= $this->_errorText(4);
			}
			
		$this->_displayForm();

		return $this->_html;
	}
	
	//////////////////////////////////////
	//preocess some standart errors
	/////////////////////////////////////
	private function _errorText($error=0){
		$result = '';
		switch($error){
			case 1 :{ $result .= 'Unable to save contents.';}; break;
			case 2 :{ $result .= 'Problem saving the contents.';}; break;
			case 3 :{ $result .= 'Unable to handle file.<br />Please check the text ".xml" file\'s writing permissions.';}; break;
			case 4 :{ $result .= 'An error occurred during the image upload.';}; break;
			default:{}; break;
		}
		return $this->displayError($this->l($result));
	
	}
	
	//////////////////////////////////////
	//Admin form
	/////////////////////////////////////
	private function _displayForm()
	{
		global $cookie;
		/* Languages preliminaries */
		$defaultLanguage = intval(Configuration::get('PS_LANG_DEFAULT'));
		$languages = Language::getLanguages(false);
		$iso = Language::getIsoById($defaultLanguage);
		$divLangName = 'module_content';
		/* xml loading */

		$xml = false;
		if (file_exists(dirname(__FILE__).'/content.xml'))
				if (!$xml = @simplexml_load_file(dirname(__FILE__).'/content.xml'))
					$this->_html .= $this->displayError($this->l('Your text file is empty.'));

		$this->_html .='
		';		

		$this->_html .= '<br />
		<form method="post" action="'.$_SERVER['REQUEST_URI'].'" enctype="multipart/form-data">
			<fieldset>
				<legend><img src="'.$this->_path.'logo.gif" alt="" title="" /> '.$this->displayName.'</legend>
				<label>'.$this->l('Module\'s Content').'</label>
				<div class="margin-form">';
			foreach ($languages as $language)
				{
					$this->_html .= '
					<div id="module_content_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;">
						<textarea class="rte autoload_rte"  cols="100" rows="30" id="content_'.$language['id_lang'].'" name="content_'.$language['id_lang'].'">'.($xml ? stripslashes(htmlspecialchars($xml->{'content_'.$language['id_lang']})) : '').'</textarea>
					</div>
					
					';
				 }

				$this->_html .= $this->displayFlags($languages, $defaultLanguage, $divLangName, 'module_content', true);
				
				$this->_html .= '
				</div><div class="clear pspace"></div>
				<label>'.$this->l('Module\'s Images').'</label>
				<div class="margin-form">
				';
				///////////
				$this->_html .= $this->getImages();
				///////////
				$this->_html .= '
				</div>
				<div class="clear pspace"></div>
				
				<label>'.$this->l('Image Upload').'</label>
				<div class="margin-form">
					<input type="file" name="module_img" />
				</div>
				<div class="clear pspace"></div>
				<div class="margin-form clear"><input type="submit" name="submitUpdate" value="'.$this->l('Update ( Save )').'" class="button" /></div>
			</fieldset>
		</form>
		<form method="post" action="'.$_SERVER['REQUEST_URI'].'" id="deleteForm">
			<input type="hidden" name="deleteImage" id="deleteImage" value="">
		</form>
		<script>
		$(".imgUrl").click(function(){
			var path_var = "'.$this->_path.'";
			var img = $(this).parent().attr("rel");
			prompt("Image Url",path_var+img);
		});
		$(".imgDelete").click(function(){
			var img = $(this).parent().attr("rel").replace("imgs/","");
			$("#deleteImage").val(img);
			var answer = confirm ("'.$this->l('Do you really want to delete this file?').'");
			if (answer){$("#deleteForm").submit()}
		});
		</script>';
		// TinyMCE
		global $cookie;
		$iso = Language::getIsoById((int)($cookie->id_lang));
		$isoTinyMCE = (file_exists(_PS_ROOT_DIR_.'/js/tiny_mce/langs/'.$iso.'.js') ? $iso : 'en');
		$ad = dirname($_SERVER["PHP_SELF"]);
		$this->_html .=  '
			<script type="text/javascript">	
			var iso = \''.$isoTinyMCE.'\' ;
			var pathCSS = \''._THEME_CSS_DIR_.'\' ;
			var ad = \''.$ad.'\' ;
			</script>
			<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tiny_mce/tiny_mce.js"></script>
			<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tinymce.inc.js"></script>';
			
		$this->_html .= '<script language="javascript" type="text/javascript">
			$(document).ready(function(){

				//small hack for PS 1.5
				if ( window.tinySetup ) {
					tinySetup({
						editor_selector :"autoload_rte"
					});
				}
			});
				
				function convertWord(type, content)
				{
					switch (type)
					{
						case "before":
							break;
						case "after":
							break;
					}
					return content;
				}
		</script>
		<script language="javascript">id_language = Number('.$defaultLanguage.');</script>
		';
	}
	
	//////////////////////////////////////
	//get all the images and <br />
	//create the image selection block
	/////////////////////////////////////
	private function getImages(){
		$tmp_files_info = array();
		$result = '<div>';

		$handle = opendir(_PS_MODULE_DIR_.basename(dirname(__FILE__)).'/imgs/');
		
		while (false !== ($file = readdir($handle))) {
			$tmp_files_info[$file]= $file;
		}
		closedir($handle);
		unset($tmp_files_info['..'],$tmp_files_info['.']);
		asort($tmp_files_info);
		
		$tmp_i = 0;
		foreach($tmp_files_info as $image){
			$tmp_line_extra = ($tmp_i >= 3)? '</div><div style="clear:both;"></div><div>':'';
			
			$result .='<div class="imgContainer" style="" rel="imgs/'.$image.'">
			<div class="imgUrl"><img src="'.$this->_path.'url.png" alt="URL"/></div>
			<div class="imgDelete"><img src="'.$this->_path.'close.png" alt="DELETE"/></div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td style="height:90px;" valign="middle">
				<img src="'.$this->_path.'imgs/'.$image.'" style="max-width:100px; max-height:100px" />
				</td>
			  </tr>
			</table>
			<div class="imgName">'.$image.'</div></div>'.$tmp_line_extra; 
			$tmp_i =($tmp_line_extra != '')? 0:++ $tmp_i;
		}
		
		$result .= '<div style="clear:both;"></div></div>';
		$result .= '
		<style>
			.imgContainer{float:left; width:150px; min-height:100px; border:solid 1px #000; text-align:center; position:relative; background-color:#FFF; margin:3px; display:block;vertical-align: middle;}
			.imgUrl{position:absolute; top:0px; left:0px; width:22px; cursor:pointer;}
			.imgDelete{position:absolute; top:0px; right:0px; width:22px; cursor:pointer;}
			.imgName{position:absolute; width:100%; bottom:0px; background-color:#000; color:#FFF;}
		</style>
		';
		return $result; 
	}
	
	//////////////////////////////////////
	//pass your content to the xml format
	/////////////////////////////////////
	function putContent($xml_data, $key, $field, $forbidden)
	{
		foreach ($forbidden AS $line)
			if ($key == $line)
				return 0;
		$field = htmlspecialchars($field);
		if (!$field)
			return 0;
		return ("\n".'		<'.$key.'>'.$field.'</'.$key.'>');
	}

}
?>
