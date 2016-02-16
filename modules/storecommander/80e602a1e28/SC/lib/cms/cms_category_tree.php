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
	
	if(version_compare(_PS_VERSION_, '1.4.0.0', '<'))
	{
		if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
		 		header("Content-type: application/xhtml+xml"); 
		} else {
		 		header("Content-type: text/xml");
		}
		echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"); 
		echo '<tree id="0">';
		echo "<item ".
						" id=\"0\"".
						" text=\""._l('Home')."\"".
						" im0=\"catalog.png\"".
						" im1=\"catalog.png\"".
						" im2=\"catalog.png\">";
		echo '</item>'."\n";
		echo '</tree>';
		echo '';
		exit;
	}

	$sql = "SELECT c.id_category FROM "._DB_PREFIX_."category c
					LEFT JOIN "._DB_PREFIX_."category_lang cl ON (cl.id_category=c.id_category AND cl.id_lang=".intval($sc_agent->id_lang).")
					WHERE cl.name LIKE '%".psql(_l('SC Recycle Bin'))."'";
	$res=Db::getInstance()->ExecuteS($sql);
	if (count($res)==0)
	{
		$newcategory=new Category();
		$newcategory->id_parent=1;
		$newcategory->level_depth=1;
		$newcategory->active=0;
		if (version_compare(_PS_VERSION_, '1.4.0.0', '>='))
		{
			// bug PS1.4 - set position
			$_GET['id_parent']=1;
			$newcategory->position=Category::getLastPosition(1);
		}
		foreach($languages AS $lang)
		{
			$newcategory->link_rewrite[$lang['id_lang']]='category';
			$newcategory->name[$lang['id_lang']]='SC Recycle Bin';
			if ($lang['iso_code']=='fr')
				$newcategory->name[$lang['id_lang']]='SC Corbeille';
		}
		$newcategory->save();
	}

	function getLevelFromDB($parent_id)
	{
		global $id_lang;
		if (version_compare(_PS_VERSION_, '1.4.0.0', '<'))
		{
			$sql = "SELECT c.active,c.id_category,name FROM "._DB_PREFIX_."category c
							LEFT JOIN "._DB_PREFIX_."category_lang cl ON (cl.id_category=c.id_category AND cl.id_lang=".intval($id_lang).")
							WHERE c.id_parent=".intval($parent_id)."
							ORDER BY cl.name";
		}else{
			$sql = "SELECT c.active,c.id_category,name FROM "._DB_PREFIX_."category c
							LEFT JOIN "._DB_PREFIX_."category_lang cl ON (cl.id_category=c.id_category AND cl.id_lang=".intval($id_lang).")
							WHERE c.id_parent=".intval($parent_id)."
							ORDER BY c.position";
		}
		$res=Db::getInstance()->ExecuteS($sql);
		foreach($res as $k => $row){
			$style='';
			if (hideCategoryPosition($row['name'])=='SoColissimo')
				continue;
			if (hideCategoryPosition($row['name'])=='')
			{
				$sql2 = "SELECT c.active,c.id_category,name FROM "._DB_PREFIX_."category c
								LEFT JOIN "._DB_PREFIX_."category_lang cl ON (cl.id_category=c.id_category AND cl.id_lang=".intval(2).")
								WHERE c.id_category=".$row['id_category'];
				$res2=Db::getInstance()->getRow($sql2);
				$style='style="background:lightblue" ';
			}
			$icon=($row['active']?'catalog.png':'catalog_edit.png');
			if (in_array(hideCategoryPosition($row['name']),array('SC Recycle Bin', 'SC Corbeille')))
				$icon='folder_delete.png';
			echo "<item ".($style!='' ? $style:'').
									" id=\"".$row['id_category']."\"".($parent_id==0?' open="1"':'').
									" text=\"".($style==''?formatText(hideCategoryPosition($row['name'])):_l('To Translate:').' '.formatText(hideCategoryPosition($res2['name'])))."\"".
									" im0=\"".$icon."\"".
									" im1=\"".$icon."\"".
									" im2=\"".$icon."\">";
			getLevelFromDB($row['id_category']);
			echo '</item>'."\n";
		}
	}

	if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
	 		header("Content-type: application/xhtml+xml"); 
	} else {
	 		header("Content-type: text/xml");
	}
	echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"); 
	echo '<tree id="0">';
	getLevelFromDB(0);
	echo '</tree>';
