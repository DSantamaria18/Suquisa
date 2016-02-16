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
$id_lang=(int)Tools::getValue('id_lang');
$id_warehouse=(int)Tools::getValue('id_warehouse');
$history=(int)Tools::getValue('history',0);

$return = array(
	"type"=>"error",
	"message"=>"",
	"debug"=>""
);

if(!empty($id_warehouse))
{
	if(empty($history))
	{
		Db::getInstance()->execute('
				DELETE FROM `'._DB_PREFIX_.'stock_mvt`
				WHERE `id_stock` IN (SELECT id_stock FROM `'._DB_PREFIX_.'stock` WHERE id_warehouse="'.(int)$id_warehouse.'")');
		Db::getInstance()->execute('
				DELETE FROM `'._DB_PREFIX_.'stock` WHERE id_warehouse="'.(int)$id_warehouse.'"');
	}
	else
	{
		Db::getInstance()->execute('
				UPDATE `'._DB_PREFIX_.'stock` SET  physical_quantity=0, usable_quantity=0 WHERE id_warehouse="'.(int)$id_warehouse.'"');
	}
	
	addToHistory('warehouse','truncate','warehouse',(int)$id_warehouse,$id_lang,_DB_PREFIX_."stock",(int)$id_warehouse,false);
	
	$return = array(
			"type"=>"success",
			"message"=>"",
			"debug"=>""
	);
}


echo json_encode($return);