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
$grids='id_specific_price,id_product,id_product_attribute,reference,name,id_group,from_quantity,price,reduction,from,to,id_country,id_currency';

if(SCMS)
	$grids='id_specific_price,id_product,id_product_attribute,reference,name,id_shop,id_shop_group,id_group,from_quantity,price,reduction,from,to,id_country,id_currency';

if(SCMS && version_compare(_PS_VERSION_, '1.6.0.11', '>='))
	$grids='id_specific_price,id_product,id_product_attribute,reference,name,id_shop,id_shop_group,id_group,from_quantity,price,reduction,reduction_tax,from,to,id_country,id_currency';
elseif(version_compare(_PS_VERSION_, '1.6.0.11', '>='))
	$grids='id_specific_price,id_product,id_product_attribute,reference,name,id_group,from_quantity,price,reduction,reduction_tax,from,to,id_country,id_currency';