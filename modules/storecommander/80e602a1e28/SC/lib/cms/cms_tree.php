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
?>
<script type="text/javascript">
	// Create interface
	var dhxLayout = new dhtmlXLayoutObject(document.body, "2U");
	dhxLayout.cells('a').setText('<?php echo _l('Categories').' '.addslashes(Configuration::get('PS_SHOP_NAME'));?>');
	dhxLayout.cells('b').setText('<?php echo _l('Properties')?>');
	dhxLayout.cells('b').setWidth(getParamUISettings('start_cms_size_prop'));
	dhxLayout.attachEvent("onPanelResizeFinish", function(){
		saveParamUISettings('start_cms_size_prop', dhxLayout.cells('b').getWidth())
	});
	var dhxLayoutStatus = dhxLayout.attachStatusBar();
	dhxLayoutStatus.setText("<?php echo SC_COPYRIGHT.' '.(SC_DEMO?'- Demonstration':'- '._l('License').' '.SCLIMREF.' - '.$SC_SHOP_PRODUCTSCOUNT.' ').' - Version '.SC_VERSION.' (PS '._PS_VERSION_.')';?>");
	layoutStatusText = "<?php echo SC_COPYRIGHT.' '.(SC_DEMO?'- Demonstration':'- '._l('License').' '.SCLIMREF.' - '.$SC_SHOP_PRODUCTSCOUNT.' ').' - Version '.SC_VERSION.' (PS '._PS_VERSION_.')';?>";
	
<?php
	createMenu();
?>
	catselection=0;
	lastPageSelID=0;
	propertiesPanel='page';
	draggedPage=0;
	firstPageLoading=1;
	dragdropcache='';

<?php	//#####################################
			//############ Categories toolbar
			//#####################################
?>

	gridView='view';
	oldGridView='';
	cms = new dhtmlXLayoutObject(dhxLayout.cells("a"), "2U");
	cms.cells('a').setText('<?php echo _l('Categories')?>');
	cms.cells('b').setText('<?php echo _l('Pages')?>');
<?php
	if(version_compare(_PS_VERSION_, '1.4.0.0', '<'))
	{
		echo "cms.cells('a').collapse();";
	}else{
?>
	cms.attachEvent("onPanelResizeFinish", function(){
		$.cookie('cg_cms_treesize',cms.cells('a').getWidth(), { expires: 60 });
		});
	cms.cells('a').setWidth($.cookie('cg_cms_treesize'));

	cms_tb=cms.cells('a').attachToolbar();
	cms_tb.addButton("help", 0, "", "lib/img/help.png", "lib/img/help.png");
	cms_tb.setItemToolTip('help','<?php echo _l('Help')?>');
	cms_tb.addButton("add_ps", 0, "", "lib/img/add_ps.png", "lib/img/add_ps.png");
	cms_tb.setItemToolTip('add_ps','<?php echo _l('Create new category with the PrestaShop form')?>');
	cms_tb.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
	cms_tb.setItemToolTip('add','<?php echo _l('Create new category')?>');
	cms_tb.addButtonTwoState("withSubCateg", 0, "", "lib/img/chart_organisation_add.png", "lib/img/chart_organisation_add.png");
	cms_tb.setItemToolTip('withSubCateg','<?php echo _l('If enabled: display products from all subcategories')?>');
	cms_tb.addButton("refresh", 0, "", "lib/img/arrow_refresh.png", "lib/img/arrow_refresh.png");
	cms_tb.setItemToolTip('refresh','<?php echo _l('Refresh tree')?>');
	cms_tb.attachEvent("onClick",
		function(id){
			if (id=='help'){
				<?php echo "window.open('".getHelpLink('cms_toolbar_cat')."');"; ?>
			}
			if (id=='refresh'){
				lastPageSelID=0;
				displayTree();
			}
			if (id=='add'){
				if (catselection!=0)
				{
					var cname=prompt('<?php echo _l('Create a category:')?>');
					if (cname!=null)
						$.get("index.php?ajax=1&x=cms_category_update&action=insert&id_parent="+catselection+'&id_lang='+SC_ID_LANG+'&name='+escape(cname),function(id){
								cms_tree.insertNewChild(catselection,id,cname,0,'../../img/catalog_edit.png','../../img/catalog_edit.png','../../img/catalog_edit.png');
							});
				}else{
					alert('<?php echo _l('You need to select a parent category before creating a category')?>');
				}
			}
			if (id=='add_ps'){
				if (!dhxWins.isWindow("wNewCategory"))
				{
					wNewCategory = dhxWins.createWindow("wNewCategory", 50, 50, 1000, $(window).height()-75);
					wNewCategory.button('park').hide();
					wNewCategory.button('minmax').hide();
					wNewCategory.setText('<?php echo _l('Create the new category and close this window to refresh the tree')?>');
					wNewCategory.attachURL("<?php echo SC_PS_PATH_ADMIN_REL;?>index.php?tab=AdminCatalog&addcategory&id_parent="+catselection+"&token=<?php echo $sc_agent->getPSToken('AdminCatalog');?>");
					wNewCategory.attachEvent("onClose", function(win){
								displayTree();
								return true;
							});
				}
			}
		}
		);
	cms_tb.attachEvent("onStateChange", function(id,state){
			if (id=='withSubCateg'){
				if (state) {
					tree_mode='all';
				  cms_grid_tb.disableItem('setposition');
				}else{
					tree_mode='single';
				  cms_grid_tb.enableItem('setposition');
				}
				displayProducts();
			}
		});

<?php	//#####################################
			//############ cms_tree
			//#####################################
?>

	cms_tree=cms.cells('a').attachTree();
	cms_tree._name='tree';
	cms_tree.autoScroll=false;
	cms_tree.setImagePath('lib/js/imgs/');
	cms_tree.enableSmartXMLParsing(true);
	cms_tree.enableDragAndDrop(true);
	cms_tree.setDragBehavior("complex");
	cms_tree._dragBehavior="complex";
	cms_tree.enableDragAndDropScrolling(true);
	displayTree();


<?php	//#####################################
			//############ Context menu
			//#####################################
?>
	cms_cmenu_tree=new dhtmlXMenuObject();
	cms_cmenu_tree.renderAsContextMenu();
	function onTreeContextButtonClick(itemId){
		if (itemId=="gopsbo"){
			tabId=cms_tree.contextID;
			wModifyCategory = dhxWins.createWindow("wModifyCategory", 50, 50, 1000, $(window).height()-75);
			wModifyCategory.setText('<?php echo _l('Modify the category and close this window to refresh the tree')?>');
			wModifyCategory.attachURL("<?php echo SC_PS_PATH_ADMIN_REL;?>index.php?tab=AdminCatalog&updatecategory&id_category="+tabId+"&id_lang="+SC_ID_LANG+"&adminlang=1&token=<?php echo $sc_agent->getPSToken('AdminCatalog');?>");
			wModifyCategory.attachEvent("onClose", function(win){
						displayTree();
						return true;
					});
		}
		if (itemId=="goshop"){
			tabId=cms_tree.contextID;
			window.open('<?php echo SC_PS_PATH_REL;?>category.php?id_category='+tabId);
		}
		if (itemId=="expand"){
			tabId=cms_tree.contextID;
			cms_tree.openAllItems(tabId);
		}
		if (itemId=="collapse"){
			tabId=cms_tree.contextID;
			cms_tree.closeAllItems(tabId);
			if (tabId==1) cms_tree.openItem(1);
		}
		if (itemId=="enable"){
			tabId=cms_tree.contextID;
			todo=(cms_tree.getItemImage(tabId,0,false)=='catalog.png'?0:1);
			$.get("index.php?ajax=1&x=cms_category_update&action=enable&id_category="+tabId+'&enable='+todo,function(id){
					if (todo){
						cms_tree.setItemImage2(tabId,'catalog.png','catalog.png','catalog.png');
					}else{
						cms_tree.setItemImage2(tabId,'catalog_edit.png','catalog_edit.png','catalog_edit.png');
					}
				});
		}
	}
	cms_cmenu_tree.attachEvent("onClick", onTreeContextButtonClick);
	var contextMenuXML='<menu absolutePosition="auto" mode="popup" maxItems="8"  globalCss="contextMenu" globalSecondCss="contextMenu" globalTextCss="contextMenuItem">'+
		'<item text="Object" id="object" enabled="false"/>'+
		'<item text="<?php echo _l('Expand')?>" id="expand"/>'+
		'<item text="<?php echo _l('Collapse')?>" id="collapse"/>'+
		'<item text="<?php echo _l('See on shop')?>" id="goshop"/>'+
		'<item text="<?php echo _l('Edit in PrestaShop BackOffice')?>" id="gopsbo"/>'+
		'<item text="<?php echo _l('Enable / Disable')?>" id="enable"/>'+
	'</menu>';
	cms_cmenu_tree.loadStruct(contextMenuXML);
	cms_tree.enableContextMenu(cms_cmenu_tree);

<?php	//#####################################
			//############ Events
			//#####################################
?>
	cms_tree.attachEvent("onClick",function(idcategory){
			if (idcategory!=catselection)
			{
				catselection=idcategory;
				cms.cells('b').setText('<?php echo _l('Products').' '._l('of')?> '+cms_tree.getItemText(catselection));
				catDataProcessor.serverProcessor=catDataProcessorURLBase+'&id_category='+catselection;
				displayProducts();
				if (propertiesPanel=='accessories' && accessoriesFilter)
				{
					prop_tb._accessoriesGrid.clearAll(true);
					prop_tb._accessoriesGrid._rowsNum=0;
					displayAccessories('',0);
				}
			}
		});
	cms_tree.attachEvent("onDrop",function doOnDrop(idSource,idTarget,idBefore,sourceobject,targetTree){
			if (sourceobject._name=='tree')
				$.get("index.php?ajax=1&x=cms_category_update&action=move&idCateg="+idSource+"&idNewParent="+idTarget+"&idNextBrother="+idBefore+'&id_lang='+SC_ID_LANG, function(data){});
		});
	cms_tree.attachEvent("onBeforeContextMenu", function(itemId){
			cms_cmenu_tree.setItemText('object', 'ID'+itemId+': <?php echo _l('Category:')?> '+cms_tree.getItemText(itemId));
			return true;
		});
	cms_tree.attachEvent("onDrag",function(sourceid,targetid,sibling,sourceobject,targetobject){
		if (targetid==0) {targetid=1; return false;}
		if (sourceobject._name=='grid')
		{
			if (copytocateg)
			{
				targetobject.setItemStyle(targetid,'background-color:#fedead;');
				var products=cms_grid.getSelectedRowId();
				if (products==null && draggedProduct!=0) products=draggedProduct;
				draggedProduct=0;
				if (dragdropcache!=catselection+'-'+targetid+'-'+products)
				{
					$.post("index.php?ajax=1&x=cms_category_dropproductoncategory&mode=copy&id_lang="+SC_ID_LANG,{'displayProductsFrom':displayProductsFrom,'categoryTarget':targetid,'categorySource':catselection,'products':products},function(){
						if (propertiesPanel=='categories')
							displayCategories();
						});
					dragdropcache=catselection+'-'+targetid+'-'+products;
				}
			}else{
				targetobject.setItemStyle(targetid,'background-color:#fedead;');
				var products=cms_grid.getSelectedRowId();
				if (products==null && draggedProduct!=0) products=draggedProduct;
				if (dragdropcache!=catselection+'-'+targetid+'-'+products)
				{
				$.post("index.php?ajax=1&x=cms_category_dropproductoncategory&mode=move&id_lang="+SC_ID_LANG,{'categoryTarget':targetid,'categorySource':catselection,'products':products},function(){
					if (draggedProduct>0)
					{
						setTimeout('cms_grid.deleteRow(draggedProduct);',200);
					}else{
						setTimeout('cms_grid.deleteSelectedRows();',200);
					}
					if (propertiesPanel=='categories')
						displayCategories();
					draggedProduct=0;
					});
					dragdropcache=catselection+'-'+targetid+'-'+products;
				}
			}
			return false;
		}else{
			return true;
		}
		});
		
	cms_tree.attachEvent("onBeforeDrag",function(idsource){
			if (cms_tree._dragBehavior!="sibling")
			{
				cms_tree.setDragBehavior("complex");
				cms_tree._dragBehavior="complex";
			}
			return true;
		});

<?php	//#####################################
			//############ Display
			//#####################################
?>

	function displayTree(callback)
	{
		cms_tree.deleteChildItems(0);
		cms_tree.loadXML("index.php?ajax=1&x=cms_category_tree&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),function(){
				if (catselection!=0)
				{
					cms_tree.openItem(catselection);
					cms_tree.selectItem(catselection,true);
				}
				if (callback!='') eval(callback);
			});
	}
<?php
} // end if PS version < 1.4
?>
</script>
<?php

	require_once("lib/page/cms_grid.php");
	require_once('lib/page/cms_prop.php');
//	require_once('lib/panel/cms_quicksearch.php');
