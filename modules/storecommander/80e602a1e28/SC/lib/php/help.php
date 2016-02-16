<?php
/**
 * Store Commander
 *
 * @category administration
 * @author Store Commander - support@storecommander.com
 * @version 2015-09-15
 * @uses Prestashop modules
 * @since 2009
 * @copyright Copyright &copy; 2009-2015, Store Commander
 * @license commercial
 * All rights reserved! Copying, duplication strictly prohibited
 *
 * *****************************************
 * *           STORE COMMANDER             *
 * *   http://www.StoreCommander.com       *
 * *            V 2015-09-15               *
 * *****************************************
 *
 * Compatibility: PS version: 1.1 to 1.6.1
 *
 **/

$helpLink=array();
$helpfrtag='?locale=16';
$helpentag='?locale=1';

$helpLink['fr']['home']='http://support.storecommander.com/home'.$helpfrtag;
$helpLink['en']['home']='http://support.storecommander.com/home'.$helpentag;

$helpLink['fr']['homedoc']='http://support.storecommander.com/entries/21516822-nouvelle-documentation-complete-sur-store-commander'.$helpfrtag;
$helpLink['en']['homedoc']='http://support.storecommander.com/entries/21533786-brand-new-documentation-on-store-commander'.$helpentag;

$helpLink['fr']['csvimport']=$helpLink['fr']['homedoc'];
$helpLink['en']['csvimport']=$helpLink['en']['homedoc'];

$helpLink['fr']['csvimportauto']=$helpLink['fr']['homedoc'];
$helpLink['en']['csvimportauto']=$helpLink['en']['homedoc'];

$helpLink['fr']['csvexport']=$helpLink['fr']['homedoc'];
$helpLink['en']['csvexport']=$helpLink['en']['homedoc'];

$helpLink['fr']['csvexport_install']='http://support.storecommander.com/entries/22080036-l-outil-d-export-csv-necessite-la-creation-de-fichiers'.$helpfrtag;
$helpLink['en']['csvexport_install']='http://support.storecommander.com/entries/22081736-the-csv-export-tool-requires-folders-to-be-created'.$helpentag;

$helpLink['fr']['cat_toolbar_cat']=$helpLink['fr']['home'];
$helpLink['en']['cat_toolbar_cat']=$helpLink['en']['home'];

$helpLink['fr']['cat_toolbar_prod']=$helpLink['fr']['home'];
$helpLink['en']['cat_toolbar_prod']=$helpLink['en']['home'];

$helpLink['fr']['cat_toolbar_prod_prop']=$helpLink['fr']['home'];
$helpLink['en']['cat_toolbar_prod_prop']=$helpLink['en']['home'];

$helpLink['fr']['history']='http://support.storecommander.com/forums/21026878-mises-a-jour'.$helpfrtag;
$helpLink['en']['history']='http://support.storecommander.com/forums/21006971-updates'.$helpentag;


function getHelpLink($page)
{
	global $helpLink,$user_lang_iso;
	if (!sc_array_key_exists($page,$helpLink['en'])) $page='home';
	if ($user_lang_iso=='fr')
	{
		return $helpLink['fr'][$page];
	}else{
		return $helpLink['en'][$page];
	}
}