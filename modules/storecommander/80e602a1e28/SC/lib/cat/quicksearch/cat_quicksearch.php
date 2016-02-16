
<div id="search">
	<form id="searchbox" action="" method="GET" onSubmit="return false;">		
		<div id="quicksearch">
			<input id="search_query" class="ac_input" value="" type="search" name="search_query" placeholder="<?php
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
 echo _l('Search')?>" onClick="this.select();" />
		</div>
		<div id="menuObj" class="align_right" dir="ltr"></div>
		<input type="submit" style="display:none" class="autocomplete"/>
	</form>
</div>
<script type="text/javascript">
id_product_attributeToSelect=0;
$('document').ready(function(){
		myAutoCompleteURL="index.php?ajax=1&act=cat_quicksearch_get";
		$("#search_query").autocomplete("index.php?ajax=1&act=cat_quicksearch_get",{
				minChars: 1,
				max: 20,
				width: 500,
				cacheLength:0,
				selectFirst: false,
				scroll: false,
				blockSubmit:true,
				dataType: "json",
				formatItem: function(data, i, max, value, term){
					return value;
				},
				parse: function(data){
						var mytab = new Array();
						for (var i = 0; i < data.length; i++){
							mytab[mytab.length]={
								data: data[i],
								value: data[i].cname+' > '+data[i].pname
							};
						}
						return mytab;
				},
				extraParams:{
					ajaxSearch: 1
				}
		})
		.result(function(event, data, formatted){
				lastProductSelID=0;
				catselection=0;
				if (typeof data!='undefined')
				{
					cat_tree.openItem(data.id_category);
					cat_tree.selectItem(data.id_category,false);
					catselection=data.id_category;
					displayProducts('id_product_attributeToSelect='+Number(data.id_product_attribute)+';lastProductSelID=0;idxProductID=cat_grid.getColIndexById("id");oldFilters["id"]="'+data.id_product+'";cat_grid.getFilterElement(idxProductID).value="'+data.id_product+'";cat_grid.filterByAll();cat_grid.selectRowById('+data.id_product+',false,true,true);');
				}
				return false;
		})

	filterQuickSearch = new dhtmlXMenuObject("menuObj");
	qsXMLMenuData=''+
	'<menu>'+
	'<item id="filters" text="<?php echo _l('Filters')?>" img="lib/img/filter.png" imgdis="lib/img/filter.png">'+
		'<item id="id_product" type="checkbox" checked="true" text="<?php echo _l('id_product')?>"></item>'+
		'<item id="id_product_attribute" type="checkbox" checked="true" text="<?php echo _l('id_product_attribute')?>"></item>'+
		'<item id="name" type="checkbox" checked="true" text="<?php echo _l('Name')?>"></item>'+
		'<item id="reference" type="checkbox" checked="true" text="<?php echo _l('Reference')?>"></item>'+
		'<item id="supplier_reference" type="checkbox" checked="true" text="<?php echo _l('Supplier Reference')?>"></item>'+
		'<item id="ean" type="checkbox" checked="true" text="<?php echo _l('EAN13')?>"></item>'+
<?php
if (version_compare(_PS_VERSION_, '1.4.0.2', '>='))
{ ?>
		'<item id="upc" type="checkbox" checked="true" text="<?php echo _l('UPC')?>"></item>'+
<?php
} ?>
	'</item>'+
	'</menu>';
	filterQuickSearch.loadStruct(qsXMLMenuData);
	function onMenuClick(id, state, zoneId, casState){
		state=Number(!state);
		myAutoCompleteURL="index.php?ajax=1&act=cat_quicksearch_get"+
							"&id_product="+(id=='id_product'?state:Number(filterQuickSearch.getCheckboxState('id_product')))+
							"&id_product_attribute="+(id=='id_product_attribute'?state:Number(filterQuickSearch.getCheckboxState('id_product_attribute')))+
							"&name="+(id=='name'?state:Number(filterQuickSearch.getCheckboxState('name')))+
							"&reference="+(id=='reference'?state:Number(filterQuickSearch.getCheckboxState('reference')))+
							"&supplier_reference="+(id=='supplier_reference'?state:Number(filterQuickSearch.getCheckboxState('supplier_reference')))+
							"&ean="+(id=='ean'?state:Number(filterQuickSearch.getCheckboxState('ean')))+
							(id=='upc'?"&upc="+state:"&upc="+Number(filterQuickSearch.getCheckboxState('upc')));
		return true;
	}
	filterQuickSearch.attachEvent("onCheckboxClick",onMenuClick);
	if (isIPAD)
	{
		$('#search').css('width','150px');
		$('#searchbox').css('width','150px');
		$('#menuObj').css('width','100px');
		$('#menuObj').css('display','inline');
		$('#search_query').css('width','100px');
		$('#search_query').css('display','inline');
	}
});
</script>
