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
	$view=Tools::getValue('view','grid_light');
	$grids=array(
		'grid_light' => 		'id,id_lang,meta_title',
		'grid_description' => 'id'
		);

	if (version_compare(_PS_VERSION_, '1.4.0.0', '>='))
	{
		$grids=array(
			'grid_light' => 		'id,id_lang,active,position,meta_title',
			'grid_description' => 'id,content,active'
			);
	}

	sc_ext::readCustomGridsConfigXML('gridConfig');
	$cols=explode(',',$grids[$view]);

	function getColIndex($col)
	{
		global $cols;
		$tmp=array_flip($cols);
		return (sc_array_key_exists($col,$tmp) ? $tmp[$col] : -1 );
	}

	// Languages
	$arrLanguages=array();
	if (in_array('id_lang',$cols))
	{
		foreach($languages as $row){
			$arrLanguages[$row['id_lang']]=$row['iso_code'];
		}
	}


	$colSettings=array();
	$colSettings['id']=array('text' => _l('ID'),'width'=>40,'align'=>'left','type'=>'ro','sort'=>'int','color'=>'','filter'=>'#text_filter');
	$colSettings['id_lang']=array('text' => _l('Lang'),'width'=>40,'align'=>'left','type'=>'ro','sort'=>'int','color'=>'','filter'=>'#select_filter_strict');
	$colSettings['name']=array('text' => _l('Name'),'width'=>200,'align'=>'left','type'=>'edtxt','sort'=>'str','color'=>'','filter'=>'#text_filter');
	$colSettings['position']=array('text' => _l('Pos.'),'width'=>35,'align'=>'right','type'=>'ed','sort'=>'int','color'=>'','filter'=>'#text_filter');
	$colSettings['active']=array('text' => _l('Active'),'width'=>45,'align'=>'center','type'=>'coro','sort'=>'int','color'=>'','filter'=>'#select_filter','options'=>array(0=>_l('No'),1=>_l('Yes')));
	$colSettings['link_rewrite']=array('text' => _l('link_rewrite'),'width'=>200,'align'=>'left','type'=>'edtxt','sort'=>'str','color'=>'','filter'=>'#text_filter');
	$colSettings['meta_title']=array('text' => _l('meta_title'),'width'=>200,'align'=>'left','type'=>'edtxt','sort'=>'str','color'=>'','filter'=>'#text_filter');
	$colSettings['meta_description']=array('text' => _l('meta_description'),'width'=>200,'align'=>'left','type'=>'txttxt','sort'=>'str','color'=>'','filter'=>'#text_filter');
	$colSettings['meta_keywords']=array('text' => _l('meta_keywords'),'width'=>200,'align'=>'left','type'=>'edtxt','sort'=>'str','color'=>'','filter'=>'#text_filter');
	$colSettings['content']=array('text' => _l('Description'),'width'=>300,'align'=>'left','type'=>'txt','sort'=>'na','color'=>'','filter'=>'#text_filter');
	sc_ext::readCustomGridsConfigXML('colSettings');

	function getColSettingsAsXML()
	{
		global $cols,$colSettings,$view;
		
		$xml='';
		foreach($cols AS $id => $col)
		{
			$xml.='<column id="'.$col.'"'.(sc_array_key_exists('format',$colSettings[$col])?' format="'.$colSettings[$col]['format'].'"':'').' width="'.($view=='grid_combination_price'&&$col=='id' ? $colSettings[$col]['width']+50:$colSettings[$col]['width']).'" align="'.$colSettings[$col]['align'].'" type="'.$colSettings[$col]['type'].'" sort="'.$colSettings[$col]['sort'].'" color="'.$colSettings[$col]['color'].'">'.$colSettings[$col]['text'];
			if (sc_array_key_exists('options',$colSettings[$col]))
			{
				foreach($colSettings[$col]['options'] AS $k => $v)
				{
					$xml.='<option value="'.str_replace('"','\'',$k).'"><![CDATA['.$v.']]></option>'; 
				}
			}
			$xml.='</column>'."\n";
		}
		return $xml;
	}

	function getFilterColSettings()
	{
		global $cols,$colSettings;
		
		$filters='';
		foreach($cols AS $id => $col)
		{
			$filters.=$colSettings[$col]['filter'].',';
		}
		$filters=trim($filters,',');
		return $filters;
	}

	function getPages($id_category)
	{
		global $tax,$id_lang,$pages,$cols,$view,$colSettings,$user_lang_iso,$fields,$fields_lang,$fieldsWithHTML,$arrLanguages;
		$link=new Link();

		$fields=array('active','position');
		$fields_lang=array('id_lang','link_rewrite','meta_title','meta_description','meta_keywords','content');
		$fieldsWithHTML=array('content');
		sc_ext::readCustomGridsConfigXML('updateSettings');
		$sqlPage='cms.id_cms';
		$sqlPageLang='';
		$blacklistfields=array();
		foreach($cols as $col)
		{
			if (in_array($col,$blacklistfields)) // calculated fields
				continue;
			if (in_array($col,$fields))
				$sqlPage.=',cms.'.$col;
			if (in_array($col,$fields_lang))
				$sqlPageLang.=',cl.'.$col;
		}
		$sqlPage=trim($sqlPage,',').',';
		$sqlPageLang=trim($sqlPageLang,',');
		
		/*
		if ($_GET['tree_mode']=='all' && $id_category==1)
		{
			$sql="SELECT ".$sqlProduct.$sqlProductLang.(_s('CAT_PROD_GRID_DISABLE_IMAGE')==0?",i.id_image":'').(($view=='grid_discount'||$view=='grid_large')&& version_compare(_PS_VERSION_, '1.4.0.0', '>=')?',sp.from,sp.to,sp.reduction,sp.reduction_type,sp.id_group':'')." FROM "._DB_PREFIX_."product p
			LEFT JOIN "._DB_PREFIX_."product_lang pl ON (pl.id_cms= p.id_cms AND pl.id_lang=".intval($id_lang).")".
			(_s('CAT_PROD_GRID_DISABLE_IMAGE')==0?" LEFT JOIN "._DB_PREFIX_."image i ON (i.id_cms= p.id_cms AND i.cover=1)":'').
			(($view=='grid_discount'||$view=='grid_large')&&version_compare(_PS_VERSION_, '1.4.0.0', '>=')?"LEFT JOIN "._DB_PREFIX_."specific_price sp ON (sp.id_cms= p.id_cms AND sp.id_currency=0 AND sp.id_country=0 AND sp.id_group=0)":'').
			" ORDER BY p.id_cms DESC";
		}else{
			if ($_GET['productsfrom']=='default') // by id_category_default
			{
				$sql="SELECT ".$sqlProduct."'-' AS position,".$sqlProductLang.(_s('CAT_PROD_GRID_DISABLE_IMAGE')==0?",i.id_image":'')." FROM "._DB_PREFIX_."product p
							LEFT JOIN "._DB_PREFIX_."product_lang pl ON (pl.id_cms= p.id_cms AND pl.id_lang=".intval($id_lang).")".
							(_s('CAT_PROD_GRID_DISABLE_IMAGE')==0?" LEFT JOIN "._DB_PREFIX_."image i ON (i.id_cms= p.id_cms AND i.cover=1)":'').
							" WHERE p.id_category_default=".intval($id_category);
			}else{
				$sql="SELECT ".$sqlProduct."cp.position,".$sqlProductLang.(_s('CAT_PROD_GRID_DISABLE_IMAGE')==0?",i.id_image":'').(($view=='grid_discount'||$view=='grid_large')&& version_compare(_PS_VERSION_, '1.4.0.0', '>=')?',sp.from,sp.to,sp.reduction,sp.reduction_type,sp.id_group':'')." FROM "._DB_PREFIX_."category_product cp
							LEFT JOIN "._DB_PREFIX_."product p ON (cp.id_cms= p.id_cms)
							LEFT JOIN "._DB_PREFIX_."product_lang pl ON (pl.id_cms= p.id_cms AND pl.id_lang=".intval($id_lang).") ".
							(_s('CAT_PROD_GRID_DISABLE_IMAGE')==0?" LEFT JOIN "._DB_PREFIX_."image i ON (i.id_cms= p.id_cms AND i.cover=1)":'').
							(($view=='grid_discount'||$view=='grid_large')&&version_compare(_PS_VERSION_, '1.4.0.0', '>=')?"LEFT JOIN "._DB_PREFIX_."specific_price sp ON (sp.id_cms= p.id_cms AND sp.id_currency=0 AND sp.id_country=0 AND sp.id_group=0)":'').
							"WHERE cp.id_category=".intval($id_category)."
								ORDER BY cp.position";
			}
		}*/
		global $dd;
				$sql="SELECT ".$sqlPage."".$sqlPageLang." FROM "._DB_PREFIX_."cms cms
							LEFT JOIN "._DB_PREFIX_."cms_lang cl ON (cl.id_cms= cms.id_cms AND cl.id_lang=".intval($id_lang).")";
		$dd=$sql;
		$res=Db::getInstance()->ExecuteS($sql);
		foreach($res as $cmsrow){
			// build xml
			echo "<row id=\"".$cmsrow['id_cms']."\">";
			foreach($cols AS $key => $col)
			{
				switch($col){
					case'id':
						echo 	"<cell>".$cmsrow['id_cms']."</cell>";
						break;
					case'id_lang':
						echo 	"<cell>".$arrLanguages[$cmsrow[$col]]."</cell>";
						break;
					default:
						if (sc_array_key_exists('buildDefaultValue',$colSettings[$col]) && $colSettings[$col]['buildDefaultValue']!='')
						{
							if ($colSettings[$col]['buildDefaultValue']=='ID')
								echo "<cell>ID".$cmsrow['id_cms']."</cell>";
						}else{
							if ($cmsrow[$col]=='' || $cmsrow[$col]==0 || $cmsrow[$col]==1) // opti perf is_numeric($cmsrow[$col]) || 
							{
								echo "<cell>".$cmsrow[$col]."</cell>";
							}else{
								echo "<cell><![CDATA[".$cmsrow[$col]."]]></cell>";
							}
						}
				}
			}
			echo "</row>\n";
		}
	}

	function getSubCategoriesProducts($parent_id)
	{
/*		$sql = "SELECT c.id_category FROM "._DB_PREFIX_."category c WHERE c.id_parent=".intval($parent_id);
		$res=Db::getInstance()->ExecuteS($sql);
		foreach($res as $row){
			getProducts($row['id_category']);
			getSubCategoriesProducts($row['id_category']);
		}*/
	}

	if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
	 		header("Content-type: application/xhtml+xml"); 
	} else {
	 		header("Content-type: text/xml");
	}
	echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"); 
	echo '<rows><head>';
	echo getColSettingsAsXML();
	if (in_array('description',$cols))
		echo '<beforeInit><call command="enableMultiline"><param>1</param></call></beforeInit>';
	echo '<afterInit><call command="attachHeader"><param>'.getFilterColSettings().'</param></call></afterInit>';
	echo '</head>';
	$pages=array();
	getPages(intval($_GET['idc']));
	if ($_GET['tree_mode']=='all' && intval($_GET['idc'])!=1) // sql optimised in function getSubCategoriesProducts for category 1
	{
		getSubCategoriesProducts(intval($_GET['idc']));
	}
	echo '<az><![CDATA['.$dd.']]></az>';
	echo '</rows>';
