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
	$id_shop=(int)Tools::getValue('id_shop',SCI::getSelectedShop());
	$with_segment=(int)Tools::getValue('with_segment', "1");
	$forceDisplayAllCategories=(int)Tools::getValue('forceDisplayAllCategories',0);
	$forExport=(int)Tools::getValue('forExport',0);
	
	$sql = "SELECT c.id_category,c.id_parent FROM "._DB_PREFIX_."category c
					LEFT JOIN "._DB_PREFIX_."category_lang cl ON (cl.id_category=c.id_category AND cl.id_lang=".intval($sc_agent->id_lang).")
					WHERE cl.name LIKE '%SC Recycle Bin' OR cl.name LIKE '%".psql(_l('SC Recycle Bin'))."'";
	$res=Db::getInstance()->ExecuteS($sql);
	$bincategory=0;
	if (count($res)==0)
	{
		$newcategory=new Category();
		$newcategory->id_parent=1;
		$newcategory->level_depth=1;
		$newcategory->active=0;
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
		{
			$newcategory->position=Category::getLastPosition(1,0);
		}elseif (version_compare(_PS_VERSION_, '1.4.0.0', '>='))
		{
			// bug PS1.4 - set position
			$_GET['id_parent']=1;
			$newcategory->position=Category::getLastPosition(1);
		}
		foreach($languages AS $lang)
		{
			$newcategory->link_rewrite[$lang['id_lang']]='category';
			$newcategory->name[$lang['id_lang']]='SC Recycle Bin';
		}
		$newcategory->save();
	}else{
		// fix bug in db
		if ($res[0]['id_category'] == $res[0]['id_parent'])
			Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'category SET id_parent = 1 WHERE id_category = '.(int)$res[0]['id_category']);
		$bincategory=$res[0]['id_category'];
	}

// ####################################

	$root_cat = array();
	if(version_compare(_PS_VERSION_, '1.5.0.0', '>='))
	{
		$shops = Shop::getShops(false);
		foreach ($shops as $shop)
		{
			$root_cat[] = $shop['id_category'];
		}
	}
	
	$binPresent=false;
	function getLevelFromDB($parent_id)
	{
		global $id_lang,$id_shop,$binPresent,$forceDisplayAllCategories,$root_cat,$id_root;
		if (version_compare(_PS_VERSION_, '1.4.0.0', '<'))
		{
			$sql = "SELECT c.active,c.id_category,name, c.id_parent FROM "._DB_PREFIX_."category c
							LEFT JOIN "._DB_PREFIX_."category_lang cl ON (cl.id_category=c.id_category AND cl.id_lang=".intval($id_lang).")
							WHERE c.id_parent=".(int)$parent_id."
							ORDER BY cl.name";
		}elseif (version_compare(_PS_VERSION_, '1.5.0.0', '<')){
			$sql = "SELECT c.active,c.id_category,name, c.id_parent FROM "._DB_PREFIX_."category c
							LEFT JOIN "._DB_PREFIX_."category_lang cl ON (cl.id_category=c.id_category AND cl.id_lang=".intval($id_lang).")
							WHERE c.id_parent=".(int)$parent_id."
							GROUP BY c.id_category
							ORDER BY c.position";
		}else{
			$sql = "SELECT c.active,c.id_category,name, c.id_parent FROM "._DB_PREFIX_."category c
							LEFT JOIN "._DB_PREFIX_."category_lang cl ON (cl.id_category=c.id_category AND cl.id_lang=".intval($id_lang)." ".($id_shop>0?"AND cl.id_shop=".(int)$id_shop:"").")
							".( !$forceDisplayAllCategories && $id_shop && (int)$parent_id > 0 ? "LEFT JOIN "._DB_PREFIX_."category_shop cs ON (cs.id_category=c.id_category)" : '')."
							WHERE c.id_parent=".(int)$parent_id."
							".( !$forceDisplayAllCategories && $id_shop && (int)$parent_id > 0 ? " AND cs.id_shop=".(int)$id_shop : '')."
							GROUP BY c.id_category
							".( !$forceDisplayAllCategories && $id_shop && (int)$parent_id > 0 ? "ORDER BY cs.position" : 'ORDER BY c.position')."
							";
		}
		$res=Db::getInstance()->ExecuteS($sql);
		foreach($res as $k => $row){
			$style='';
			if (hideCategoryPosition($row['name'])=='SoColissimo')
				continue;
			if (hideCategoryPosition($row['name'])=='')
			{
				$sql2 = "SELECT name FROM "._DB_PREFIX_."category_lang 
									WHERE id_lang=".intval(Configuration::get('PS_LANG_DEFAULT'))." 
										AND id_category=".(int)$row['id_category'];
				$res2=Db::getInstance()->getRow($sql2);
				$style='style="background:lightblue" ';
			}
			$icon=($row['active']?'catalog.png':'folder_grey.png');
			if (hideCategoryPosition($row['name'])=='SC Recycle Bin')
			{
				$icon='folder_delete.png';
				$binPresent=true;
				if (!_r("ACT_CAT_DELETE_PRODUCT_COMBI"))
					continue;
			}
			
			$is_root = false;
			if($row["id_parent"]==0)
				$is_root = true;

			$is_home = false;
			if(version_compare(_PS_VERSION_, '1.5.0.0', '>=') && in_array($row['id_category'], $root_cat))
			{
				$icon='folder_table.png';
				$is_home = true;
			}
			
			$not_deletable = false;
			if($is_home || $is_root)
				$not_deletable = true;
			
			echo "<item ".($style!='' ? $style:'').
									" id=\"".$row['id_category']."\"".($parent_id==0 || $icon=='folder_table.png'?' open="1"':'').
									" im0=\"".$icon."\"".
									" im1=\"".$icon."\"".
									" im2=\"".$icon."\"".
									(hideCategoryPosition($row['name'])=='SC Recycle Bin' ? " tooltip=\""._l('Products and categories in recycle bin from all shops')."\"":"").
									"><itemtext><![CDATA[".(hideCategoryPosition($row['name'])=='SC Recycle Bin'?_l('SC Recycle Bin'):($style==''?formatText(hideCategoryPosition($row['name'])):_l('To Translate:').' '.formatText(hideCategoryPosition($res2['name']))))."]]></itemtext>";
			echo '  	<userdata name="not_deletable">'.intval($not_deletable).'</userdata>';
			if(hideCategoryPosition($row['name'])=='SC Recycle Bin')
				echo '  	<userdata name="is_recycle_bin">1</userdata>';
			else
				echo '  	<userdata name="is_recycle_bin">0</userdata>';
			echo '  	<userdata name="is_home">'.intval($is_home).'</userdata>';
			echo '  	<userdata name="is_root">'.intval($is_root).'</userdata>';
			echo ' 		<userdata name="is_segment">0</userdata>';
			echo ' 		<userdata name="parent_root">'.$id_root.'</userdata>';
			getLevelFromDB($row['id_category']);
			echo '</item>'."\n";
		}
	}	

	if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
	 		header("Content-type: application/xhtml+xml"); 
	} else {
	 		header("Content-type: text/xml");
	}
	$id_root=0;
	$ps_root = 0;//SCI::getConfigurationValue("PS_ROOT_CATEGORY");
	if(version_compare(_PS_VERSION_, '1.5.0.0', '>='))
	{
		$sql_root = "SELECT *
				FROM "._DB_PREFIX_."category
				WHERE id_parent = 0";
		$res_root=Db::getInstance()->ExecuteS($sql_root);
		if(!empty($res_root[0]["id_category"]))
			$ps_root = $res_root[0]["id_category"];
	}
	if(!empty($ps_root))
		$id_root = $ps_root;
	if (SCMS && $id_shop > 0)
	{
		$shop = new Shop($id_shop);
		$categ = new Category($shop->id_category);
		$id_root = $categ->id_parent;
	}
	
	echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"); 
	echo '<tree id="0">';
	//echo ' 		<userdata name="parent_root">'.$id_root.'</userdata>';
	
	if(version_compare(_PS_VERSION_, '1.4.0.0', '>='))
	{
		$array_cats = array();
		$array_children_cats = array();
		
		if(version_compare(_PS_VERSION_, '1.5.0.0', '>=') && !SCMS)
		{
			$id_shop = (int)Configuration::get('PS_SHOP_DEFAULT');
		}
		
		$sql = "SELECT c.*, cl.name, c.position ".(version_compare(_PS_VERSION_, '1.5.0.0', '>=') && !empty($id_shop)?", cs.position":"")."
				FROM "._DB_PREFIX_."category c
				LEFT JOIN "._DB_PREFIX_."category_lang cl ON (cl.id_category=c.id_category AND cl.id_lang=".intval($id_lang).")
				".(version_compare(_PS_VERSION_, '1.5.0.0', '>=') && !empty($id_shop)?" INNER JOIN "._DB_PREFIX_."category_shop cs ON (cs.id_category=c.id_category AND cs.id_shop='".(int)$id_shop."') ":"")."
				GROUP BY c.id_category
				ORDER BY c.`nleft` ASC";
		//echo $sql;die();
		$res=Db::getInstance()->ExecuteS($sql);
		foreach($res as $k => $row)
		{
			$array_cats[$row["id_category"]]=$row;
			
			if(!isset($array_children_cats[$row["id_parent"]]))
				$array_children_cats[$row["id_parent"]] = array();
			$array_children_cats[$row["id_parent"]][str_pad($row["position"], 5, "0", STR_PAD_LEFT).str_pad($row["id_category"], 12, "0", STR_PAD_LEFT)] = $row["id_category"];
		}
		/*echo $id_root."\n";
		print_r($array_children_cats);die();*/
		function getLevelFromDB_PHP($id_parent, $limit_to_shop=false)
		{
			global $id_lang,$id_shop,$binPresent,$forceDisplayAllCategories,$root_cat,$array_cats,$array_children_cats,$id_root;
			/*	echo $id_parent."\n";
				print_r($array_children_cats[$id_parent]);die();*/
	
			if(!empty($array_children_cats[$id_parent]))
			{
				ksort($array_children_cats[$id_parent]);
				foreach($array_children_cats[$id_parent] as $k => $id)
				{
					$row = $array_cats[$id];

					if(version_compare(_PS_VERSION_, '1.5.0.0', '>='))
					{
						if(!SCMS)
							$id_shop = (int)Configuration::get('PS_SHOP_DEFAULT');
						if(!empty($id_shop))
						{
							$in_shop = false;
							if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
							{
								$sql_shop = "SELECT s.name, s.id_shop
									FROM "._DB_PREFIX_."category_shop cs
										INNER JOIN "._DB_PREFIX_."shop s ON (cs.id_shop=s.id_shop)
									WHERE cs.id_category=".(int)$row['id_category']."
									ORDER BY s.name";
								$res_shop=Db::getInstance()->executeS($sql_shop);
								foreach($res_shop as $shop)
								{
									if(!empty($shop["id_shop"]) && !empty($id_shop) && $shop["id_shop"]==$id_shop)
										$in_shop = true;
								}
							}
							if(!$in_shop && !empty($limit_to_shop) /*&& SCI::getSelectedShop()>0*/)
								continue;
						}
					}
					
					$style='';
					if (hideCategoryPosition($row['name'])=='SoColissimo')
						continue;
					if (hideCategoryPosition($row['name'])=='')
					{
						$sql2 = "SELECT name FROM "._DB_PREFIX_."category_lang
										WHERE id_lang=".intval(Configuration::get('PS_LANG_DEFAULT'))."
											AND id_category=".$row['id_category'];
						$res2=Db::getInstance()->getRow($sql2);
						$style='style="background:lightblue" ';
					}
					$icon=($row['active']?'catalog.png':'folder_grey.png');
					if (hideCategoryPosition($row['name'])=='SC Recycle Bin')
					{
						$icon='folder_delete.png';
						$binPresent=true;
						if (!_r("ACT_CAT_DELETE_PRODUCT_COMBI"))
							continue;
					}
						
					$is_root = false;
					if($row["id_parent"]==0)
						$is_root = true;
				
					$is_home = false;
					if(version_compare(_PS_VERSION_, '1.5.0.0', '>=') && in_array($row['id_category'], $root_cat))
					{
						$icon='folder_table.png';
						$is_home = true;
					}
						
					$not_deletable = false;
					if($is_home || $is_root)
						$not_deletable = true;
						
					
					echo "<item ".($style!='' ? $style:'').
					" id=\"".$row['id_category']."\"".($row["id_parent"]==0 || $icon=='folder_table.png'?' open="1"':'').
					" im0=\"".$icon."\"".
					" im1=\"".$icon."\"".
					" im2=\"".$icon."\"".
					(hideCategoryPosition($row['name'])=='SC Recycle Bin' ? " tooltip=\""._l('Products and categories in recycle bin from all shops')."\"":"").
					">\n<itemtext><![CDATA[".(hideCategoryPosition($row['name'])=='SC Recycle Bin'?_l('SC Recycle Bin'):($style==''?formatText(hideCategoryPosition($row['name'])):_l('To Translate:').' '.formatText(hideCategoryPosition($res2['name']))))."]]></itemtext>\n";
					echo '  	<userdata name="not_deletable">'.intval($not_deletable).'</userdata>'."\n";
					if(hideCategoryPosition($row['name'])=='SC Recycle Bin')
						echo '  	<userdata name="is_recycle_bin">1</userdata>'."\n";
					else
						echo '  	<userdata name="is_recycle_bin">0</userdata>'."\n";
					echo '  	<userdata name="is_home">'.intval($is_home).'</userdata>'."\n";
					echo '  	<userdata name="is_root">'.intval($is_root).'</userdata>'."\n";
					echo ' 		<userdata name="is_segment">0</userdata>';
					echo ' 		<userdata name="parent_root">'.$id_root.'</userdata>';
					getLevelFromDB_PHP($row['id_category'], $limit_to_shop);
					echo '</item>'."\n";
				}
			}
		}
		
		getLevelFromDB_PHP($id_root, true);
	}
	else
		getLevelFromDB($id_root);
	if (SCMS && !$binPresent && _r("ACT_CAT_DELETE_PRODUCT_COMBI"))
	{
		$icon='folder_delete.png';
		echo "<item ".
								" id=\"".$bincategory."\"".
								" text=\""._l('SC Recycle Bin')."\"".
								" im0=\"".$icon."\"".
								" im1=\"".$icon."\"".
								" im2=\"".$icon."\"".
								" tooltip=\""._l('Products and categories in recycle bin from all shops')."\">";
			echo '  	<userdata name="not_deletable">1</userdata>';
			echo '  	<userdata name="is_recycle_bin">1</userdata>';
			echo '  	<userdata name="is_home">0</userdata>';
			echo '  	<userdata name="is_root">0</userdata>';
			echo ' 		<userdata name="is_segment">0</userdata>';
			echo ' 		<userdata name="parent_root">'.$id_root.'</userdata>';
			if(version_compare(_PS_VERSION_, '1.4.0.0', '>='))
				getLevelFromDB_PHP($bincategory, true);
			else
				getLevelFromDB($bincategory);
		echo	"</item>\n";
	}
	if(SCSG && $with_segment)
		SegmentHook::getSegmentLevelFromDB(0, "catalog");
	echo '</tree>';
