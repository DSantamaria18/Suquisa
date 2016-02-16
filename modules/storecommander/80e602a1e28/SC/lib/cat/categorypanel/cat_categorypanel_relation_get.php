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

$idlist = Tools::getValue('idlist');
$id_lang = intval(Tools::getValue('id_lang'));
$cntProducts = count(explode(',', $idlist));
$used = array();

$sql = "SELECT distinct cp.id_category FROM " . _DB_PREFIX_ . "category_product cp
			WHERE cp.id_product IN (" . psql($idlist) . ")";
$res = Db::getInstance()->ExecuteS($sql);

foreach ($res as $row) {
    $used[] = $row['id_category'];
}

$cdefault = "";
if ($cntProducts == 1) {
    if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
        $default_shop = SCI::getSelectedShop();
        if (empty($default_shop)) {
            $product = new Product($idlist);
            $default_shop = $product->id_shop_default;
        }

        $sql = "SELECT p.id_category_default FROM " . _DB_PREFIX_ . "product_shop p
					WHERE p.id_product IN (" . psql($idlist) . ") AND id_shop=" . (int)$default_shop;
        $res = Db::getInstance()->getRow($sql);
    } else {
        $sql = "SELECT p.id_category_default FROM " . _DB_PREFIX_ . "product p
					WHERE p.id_product IN (" . $idlist . ")";
        $res = Db::getInstance()->getRow($sql);
    }
    $cdefault = $res['id_category_default'];
} else {
    if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
        $sql = "SELECT DISTINCT(ps.id_category_default)
                FROM " . _DB_PREFIX_ . "product p
                    INNER JOIN " . _DB_PREFIX_ . "product_shop ps ON (p.id_product=ps.id_product AND ps.id_shop=p.id_shop_default)
				WHERE p.id_product IN (" . psql($idlist) . ") ";
        $res = Db::getInstance()->ExecuteS($sql);
        if(!empty($res) && count($res)==1)
            $cdefault = $res[0]['id_category_default'];
    } else {
        $sql = "SELECT DISTINCT(p.id_category_default)
                FROM " . _DB_PREFIX_ . "product p
				WHERE p.id_product IN (" . psql($idlist) . ") ";
        $res = Db::getInstance()->ExecuteS($sql);
        if(!empty($res) && count($res)==1)
            $cdefault = $res[0]['id_category_default'];
    }
}

echo join(',', $used) . '|' . $cdefault;