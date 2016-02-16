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

$id_lang=intval(Tools::getValue('id_lang'));

$dir = '../../export/';

$open_dir = opendir($dir) or die('Erreur');
echo '<div style="width: 500px; overflow: auto;">
	<ul style="padding-left: 16px; margin: 0px;">';
while($filename = @readdir($open_dir)) {
	if(!is_dir($dir.'/'.$filename) && $filename != '.' && $filename != '..' && $filename != 'index.php') {
		echo '<li style="font-family: Tahoma; font-size: 11px !important; line-height: 18px; color: #000000;">
				<a href="'.(isset($websiteURL) ? $websiteURL:'').$dir.$filename.'" traget="_blank" style="color: #000000;">'.$filename.'</a>
				 - '.number_format(filesize($dir.$filename)/1024,2).'Ko - '.(date ("Y-m-d H:i:s.", filemtime($dir.$filename))).'
				</li>';
	}
}
echo '</ul></div>';
closedir($open_dir);

?>