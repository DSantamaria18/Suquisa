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
	cms_grid=cms.cells('b').attachGrid();
	cms_grid._name='grid';
	cms_grid.enableDragAndDrop(true);
	cms_grid.setDragBehavior('child');
	cms_grid_tb=cms.cells('b').attachToolbar();
	cms_grid_tb.addButton("help", 0, "", "lib/img/help.png", "lib/img/help.png");
	cms_grid_tb.setItemToolTip('help','<?php echo _l('Help')?>');
	cms_grid_tb.addButton("setposition", 0, "", "lib/img/layers.png", "lib/img/layers_dis.png");
	cms_grid_tb.setItemToolTip('setposition','<?php echo _l('Save product positions in the grid as category positions')?>');
	cms_grid_tb.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning_dis.png");
	cms_grid_tb.setItemToolTip('selectall','<?php echo _l('Select all products')?>');
	cms_grid_tb.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
	cms_grid_tb.setItemToolTip('delete','<?php echo _l('This will permanently delete the selected products everywhere in the shop.')?>');
	cms_grid_tb.addButton("duplicate", 0, "", "lib/img/page_copy.png", "lib/img/page_copy.png");
	cms_grid_tb.setItemToolTip('duplicate','<?php echo _l('Duplicate 1 to').' '._s('CAT_PROD_DUPLICATE').' '._l('products')?>');
	cms_grid_tb.addButton("add_ps", 0, "", "lib/img/add_ps.png", "lib/img/add_ps.png");
	cms_grid_tb.setItemToolTip('add_ps','<?php echo _l('Create new product with the PrestaShop form')?>');
	cms_grid_tb.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
	cms_grid_tb.setItemToolTip('add','<?php echo _l('Create new product')?>');
	cms_grid_tb.addButtonTwoState('lightNavigation', 0, "", "lib/img/cursor.png", "lib/img/cursor.png");
	cms_grid_tb.setItemToolTip('lightNavigation','<?php echo _l('Light navigation (simple click on grid)')?>');
	cms_grid_tb.addButton("refresh", 0, "", "lib/img/arrow_refresh.png", "lib/img/arrow_refresh.png");
	cms_grid_tb.setItemToolTip('refresh','<?php echo _l('Refresh grid')?>');
	var opts = [['filters_reset', 'obj', '<?php echo _l('Reset filters')?>', ''],
							['separator1', 'sep', '', ''],
							['filters_cols_show', 'obj', '<?php echo _l('Show all columns')?>', ''],
							['filters_cols_hide', 'obj', '<?php echo _l('Hide all columns')?>', '']
							];
	cms_grid_tb.addButtonSelect("filters", 0, "", opts, "lib/img/filter.png", "lib/img/filter.png",false,true);
	cms_grid_tb.setItemToolTip('filters','<?php echo _l('Filter options')?>');
<?php
	$tmp=array();
	$clang=_l('Language');
	$optlang='';
	foreach($languages AS $lang){
		if ($lang['id_lang']==$sc_agent->id_lang)
		{
			$clang=$lang['iso_code'];
			$optlang='cat_lang_'.$lang['iso_code'];
		}
		$tmp[]="['cat_lang_".$lang['iso_code']."', 'obj', '".$lang['name']."', '']";
	}
	if (count($tmp) > 1)
	{
		echo 'var opts = ['.join(',',$tmp).'];';
?>
	cms_grid_tb.addButtonSelect('lang',0,'<?php echo $clang?>',opts,'lib/img/flag_blue.png','lib/img/flag_blue.png',false,true);
	cms_grid_tb.setItemToolTip('lang','<?php echo _l('Select catalog language')?>');
	cms_grid_tb.setListOptionSelected('lang', '<?php echo $optlang ?>');
<?php
	}
?>
	var gridnames=new Array();
	gridnames['grid_light']='<?php echo _l('Light view')?>';
	gridnames['grid_large']='<?php echo _l('Large view')?>';
	gridnames['grid_description']='<?php echo _l('Descriptions')?>';
<?php
	sc_ext::readCustomGridsConfigXML('gridnames');
?>
	var opts = [['grid_light', 'obj', gridnames['grid_light'], ''],
							['grid_large', 'obj', gridnames['grid_large'], '']
<?php
	if ((int)(_s('CAT_PROD_GRID_DESCRIPTION')))
		echo "							,['grid_description', 'obj', gridnames['grid_description'], '']";
	sc_ext::readCustomGridsConfigXML('toolbar');
?>
							];
	cms_grid_tb.addButtonSelect("gridview", 0, "<?php echo _l('Light view')?>", opts, "lib/img/table_gear.png", "lib/img/table_gear.png",false,true);
	cms_grid_tb.setItemToolTip('gridview','<?php echo _l('Grid view settings')?>');

	function gridToolBarOnClick(id){
			if (id.substr(0,5)=='grid_'){
				oldGridView=gridView;
				gridView=id;
				cms_grid_tb.setItemText('gridview',gridnames[id]);
				$(document).ready(function(){displayPages();});
			}
			if (id=='help'){
				<?php echo "window.open('".getHelpLink('cms_toolbar_prod')."');"; ?>
			}
			if (id=='filters_reset')
			{
				for(var i=0,l=cms_grid.getColumnsNum();i<l;i++)
				{
					if (cms_grid.getFilterElement(i)!=null) cms_grid.getFilterElement(i).value="";
				}
				cms_grid.filterByAll();
				cms_grid_tb.setListOptionSelected('filters','');
			}
			if (id=='filters_cols_show')
			{
				for(i=0,l=cms_grid.getColumnsNum() ; i < l ; i++)
				{
					cms_grid.setColumnHidden(i,false);
				}
				cms_grid_tb.setListOptionSelected('filters','');
			}
			if (id=='filters_cols_hide')
			{
				idxPageID=cms_grid.getColIndexById('id');
				idxPageIDLang=cms_grid.getColIndexById('id_lang');
				idxPageName=cms_grid.getColIndexById('name');
				for(i=0 , l=cms_grid.getColumnsNum(); i < l ; i++)
				{
					if (i!=idxPageID && i!=idxPageIDLang && i!=idxPageName)
					{
						cms_grid.setColumnHidden(i,true);
					}else{
						cms_grid.setColumnHidden(i,false);
					}
				}
				cms_grid_tb.setListOptionSelected('filters','');
			}
			flagLang=false; // changelang ; lang modified?
<?php
	$tmp=array();
	$clang=_l('Language');
	foreach($languages AS $lang){
		echo'
			if (id==\'cat_lang_'.$lang['iso_code'].'\')
			{
				if (propertiesPanel==\'descriptions\' && typeof prop_tb._descriptionsLayout!=\'undefined\')
					prop_tb._descriptionsLayout.cells(\'a\').getFrame().contentWindow.checkChange();
				SC_ID_LANG='.$lang['id_lang'].';
				cms_grid_tb.setItemText(\'lang\',\''.$lang['iso_code'].'\');
				flagLang=true;
			}
';
	}
?>
			if (flagLang){
				catDataProcessorURLBase="index.php?ajax=1&x=cat_catalog_update&id_lang="+SC_ID_LANG;
				catDataProcessor.serverProcessor=catDataProcessorURLBase+'&id_category='+catselection;
				cms_grid.clearAll();
				displayTree('displayPages('+(propertiesPanel=='descriptions'?'"setPropertiesPanel(\'descriptions\')"':'')+')');
				imagesDataProcessorURLBase="index.php?ajax=1&x=cat_image_update&id_lang="+SC_ID_LANG;
				if (typeof(imagesDataProcessor)!='undefined') imagesDataProcessor.serverProcessor=imagesDataProcessorURLBase;
			}
			if (id=='refresh'){
				displayPages();
			}
			if (id=='add'){
				if (catselection==0){
					alert('<?php echo _l('You need to select a category.')?>');
				}else{
					var newId = new Date().getTime();
					catDataProcessor.serverProcessor=catDataProcessorURLBase+'&id_category='+catselection;
					newRow=new Array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
					newRow=newRow.slice(0,cms_grid.getColumnsNum()-1);
					idxID=cms_grid.getColIndexById('id');
					idxName=cms_grid.getColIndexById('name');
					idxActive=cms_grid.getColIndexById('active');
					idxLinkRewrite=cms_grid.getColIndexById('link_rewrite');
					newRow[idxID]=newId;
					newRow[idxName]='new';
					if (idxActive) newRow[idxActive]='<?php echo _s('CAT_PROD_CREA_ACTIVE');?>';
					if (idxLinkRewrite) newRow[idxLinkRewrite]='cms';
					cms_grid.addRow(newId,newRow);
					cms_grid.showRow(newId);
				}
			}
			if (id=='add_ps'){
				if (catselection==0){
					alert('<?php echo _l('You need to select a category before creating a product')?>');
				}else{
					if (!dhxWins.isWindow("wNewPage"))
					{
						wNewPage = dhxWins.createWindow("wNewPage", 50, 50, 1000, $(window).height()-75);
						wNewPage.setText('<?php echo _l('Create the new product and close this window to refresh the grid')?>');
						wNewPage.attachURL("<?php echo SC_PS_PATH_ADMIN_REL;?>index.php?tab=AdminCatalog&addproduct&id_category="+catselection+"&token=<?php echo $sc_agent->getPSToken('AdminCatalog');?>");
						wNewPage.attachEvent("onClose", function(win){
									displayPages();
									return true;
								});
					}
				}
			}
			if (id=='duplicate'){
				if (catselection==0){
					alert('<?php echo _l('You need to select a category before creating a product')?>');
				}else{
					if (1)
					{
						arrSelRow=cms_grid.getSelectedRowId().split(',');
						nbSelRow=arrSelRow.length;
						if (cms_grid.getSelectedRowId()==null || nbSelRow > <?php echo _s('CAT_PROD_DUPLICATE')?>)
						{
							alert('<?php echo _l('Please select 1 to').' '._s('CAT_PROD_DUPLICATE').' '._l('pages')?>');
						}else{
							if (confirm('<?php echo _l('Do you want to copy images?')?>')){
								url1='<?php echo SC_PS_PATH_ADMIN_REL;?>index.php?tab=AdminCatalog&id_product=';
								url2='&duplicateproduct&token=<?php echo $sc_agent->getPSToken('AdminCatalog');?>';
							}else{
								url1='<?php echo SC_PS_PATH_ADMIN_REL;?>index.php?tab=AdminCatalog&id_product=';
								url2='&duplicateproduct&noimage=1&token=<?php echo $sc_agent->getPSToken('AdminCatalog');?>';
							}
							for(i = 1 ; i <= nbSelRow ; i++)
							{
								wDuplicatePage=Array();
								wDuplicatePage[i] = dhxWins.createWindow("wDuplicatePage"+i, 50+i*15, 50+i*15, 1000, $(window).height()-75);
								wDuplicatePage[i].setText('<?php echo _l('You can close this window when you get the confirmation of the duplication, don\\\'t forget to refresh the grid!')?>');
								wDuplicatePage[i].attachURL(url1+arrSelRow[i-1]+url2);
								pausecomp(800);
							}
						}
					}
				}
			}
			if (id=="delete"){
				if (confirm('<?php echo _l('Permanently delete the selected products everywhere in the shop.')?>'))
				{
					selection=cms_grid.getSelectedRowId();
					$.post('index.php?ajax=1&p=cat_product_del',{'productlist':cms_grid.getSelectedRowId()},function(data){
							if (selection!='' && selection!=null)
							{
								selArray=selection.split(',');
								for(i=0 ; i < selArray.length ; i++)
									cms_grid.deleteRow(selArray[i]);
							}
						});
				}
			}
			if (id=='selectall'){
			  cms_grid.enableSmartRendering(false);
			  cms_grid.selectAll();
			}
			if (id=='setposition'){
				idxPosition=cms_grid.getColIndexById('position');
				if (idxPosition && cms_grid.getRowsNum()>0 && catselection!=0)
				{
					var positions='';
					var idx=0;
					cms_grid.forEachRow(function(id){
							positions+=id+','+cms_grid.getRowIndex(id)+';';
							idx++;
						});
					$.post("index.php?ajax=1&x=cat_catalog_update&id_category="+catselection,{'!nativeeditor_status':'position','positions':positions},function(){
							idxPosition=cms_grid.getColIndexById('position');
							displayPages('cms_grid.sortRows('+idxPosition+', "int", "asc");');
						});
				}
			}
		}
	cms_grid_tb.attachEvent("onClick",gridToolBarOnClick);
	cms_grid_tb.attachEvent("onStateChange", function(id,state){
			if (id=='lightNavigation'){
				if (state) {
					cms_grid.enableLightMouseNavigation(true);
					lightMouseNavigation=1;
				}else{
					cms_grid.enableLightMouseNavigation(false);
					lightMouseNavigation=0;
				}
			}
		});

	// Pages grid definition
	cms_grid.setImagePath('lib/js/imgs/');
	cms_grid.setDateFormat("%Y-%m-%d","%Y-%m-%d");
	cms_grid.enableMultiselect(true);
	cms_grid.enableColumnMove(true);
	cms_grid_sb=cms.cells('b').attachStatusBar();
	gridToolBarOnClick(gridView);

	cms_grid.attachEvent("onBeforeDrag",function(idsource){
			if (cms_grid.getSelectedRowId()==null) draggedPage=idsource;
			if (cms_tree._dragBehavior!="child")
			{
				cms_tree.setDragBehavior("child");
				cms_tree._dragBehavior="child";
			}
			return true;
		});
	cms_grid.attachEvent("onDragIn",function(idsource){
			return true;
		});
	cms_grid.rowToDragElement=function(id){
          var text="";
          idxName=cms_grid.getColIndexById('name');
          if (cms_grid.getSelectedRowId()!=null)
          {
            var dragged=cms_grid.getSelectedRowId().split(',');
            if (dragged.length > 1){ // multi
	            for (var i=0; i < dragged.length; i++)
  	          {
                text += cms_grid.cells(dragged[i],idxName).getValue() + "<br/>";
              }
            }else{ // single
							text += cms_grid.cells(dragged,idxName).getValue() + "<br/>";
            }
          }else{ // single
						text += cms_grid.cells(draggedPage,idxName).getValue() + "<br/>";
          }
          return text;
        }
	// multiedition context menu
	cms_grid.attachEvent("onBeforeContextMenu", function(rowid,colidx,grid){
			lastColumnRightClicked=colidx;
			cms_cmenu.setItemText('object', '<?php echo _l('Page')._l(':')?> '+cms_grid.cells(rowid,cms_grid.getColIndexById('name')).getValue());
			// paste function
			if (lastColumnRightClicked==clipboardType)
			{
				cms_cmenu.setItemEnabled('paste');
			}else{
				cms_cmenu.setItemDisabled('paste');
			}
			var colType=cms_grid.getColType(colidx);
			if (colType=='ro')
			{
				cms_cmenu.setItemDisabled('copy');
				cms_cmenu.setItemDisabled('paste');
			}else{
				cms_cmenu.setItemEnabled('copy');
			}
			return true;
		});

	function onEditCell(stage,rId,cInd,nValue,oValue){
		var coltype=cms_grid.getColType(cInd);
		if (stage==1 && this.editor && this.editor.obj && coltype!='txt' && coltype!='txttxt') this.editor.obj.select();
		lastEditedCell=cInd;
		if (nValue!=oValue){
			cms_grid.setRowColor(rId,'BlanchedAlmond');
			idxActive=cms_grid.getColIndexById('active');
			idxMetaTitle=cms_grid.getColIndexById('meta_title');
			idxMetaDescription=cms_grid.getColIndexById('meta_description');
			idxMetaKeywords=cms_grid.getColIndexById('meta_keywords');
			idxLinkRewrite=cms_grid.getColIndexById('link_rewrite');
			if (cInd == idxMetaTitle){
				cms_grid.cells(rId,idxMetaTitle).setValue(cms_grid.cells(rId,idxMetaTitle).getValue().substr(0,<?php echo _s('CAT_META_TITLE_SIZE')?>));
			}
			if (cInd == idxMetaDescription){
				cms_grid.cells(rId,idxMetaDescription).setValue(cms_grid.cells(rId,idxMetaDescription).getValue().substr(0,<?php echo _s('CAT_META_DESC_SIZE')?>));
			}
			if (cInd == idxMetaKeywords){
				cms_grid.cells(rId,idxMetaKeywords).setValue(cms_grid.cells(rId,idxMetaKeywords).getValue().substr(0,<?php echo _s('CAT_META_KEYWORDS_SIZE')?>));
			}
			if (cInd == idxLinkRewrite){
				cms_grid.cells(rId,idxLinkRewrite).setValue(getLinkRewriteFromString(cms_grid.cells(rId,idxLinkRewrite).getValue().substr(0,<?php echo _s('CAT_LINK_REWRITE_SIZE')?>)));
			}
			if (cInd == idxActive){ //Active update
				if (nValue==0){
					cms_grid.cells(rId,idxMetaTitle).setBgColor('#D7D7D7');
				}else{
					cms_grid.cells(rId,idxMetaTitle).setBgColor(cms_grid.cells(rId,0).getBgColor());
				}
			}
<?php
		sc_ext::readCustomGridsConfigXML('onEditCell');
?>
			return true;
		}
	}
	cms_grid.attachEvent("onEditCell",onEditCell);

	catDataProcessorURLBase="index.php?ajax=1&x=cat_catalog_update&id_lang="+SC_ID_LANG;
	catDataProcessor = new dataProcessor(catDataProcessorURLBase);
	catDataProcessor.attachEvent("onAfterUpdate",function(sid,action,tid,xml){
			var dbQty = xml.getAttribute("quantity");
			if (dbQty!='')
			{
				idxQty=cms_grid.getColIndexById('quantity');
				if (idxQty!=null)
					cms_grid.cells(sid,idxQty).setValue(dbQty);
			}
			if (action=='insert')
			{
				idxID=cms_grid.getColIndexById('id');
				cms_grid.cells(sid,idxID).setValue(tid);
			}
			var doUpdateCombinations = xml.getAttribute("doUpdateCombinations");
			if (doUpdateCombinations==1 && propertiesPanel=='combinations')
			{
				displayCombinations();
			}
		});
	catDataProcessor.enableDataNames(true);
	catDataProcessor.enablePartialDataSend(true);
	catDataProcessor.setUpdateMode('cell',true);
	catDataProcessor.setTransactionMode("POST");
	catDataProcessor.init(cms_grid);

	// Context menu for Grid
	cms_cmenu=new dhtmlXMenuObject();
	cms_cmenu.renderAsContextMenu();
	function onGridCatContextButtonClick(itemId){
		tabId=cms_grid.contextID.split('_');
		tabId=tabId[0];
		if (itemId=="gopsbo"){
			wModifyPage = dhxWins.createWindow("wModifyPage", 50, 50, 1000, $(window).height()-75);
			wModifyPage.setText('<?php echo _l('Modify the product and close this window to refresh the grid')?>');
			wModifyPage.attachURL("<?php echo SC_PS_PATH_ADMIN_REL;?>index.php?tab=AdminCatalog&updateproduct&id_product="+tabId+"&id_lang="+SC_ID_LANG+"&adminlang=1&token=<?php echo $sc_agent->getPSToken('AdminCatalog');?>");
			wModifyPage.attachEvent("onClose", function(win){
						displayPages();
						return true;
					});
		}
		if (itemId=="goshop"){
			var sel=cms_grid.getSelectedRowId();
			if (sel)
			{
				var tabId=sel.split(',');
				var k=1;
				for (var i=0;i<tabId.length;i++)
				{
					if (k > <?php echo _s('CAT_PROD_OPEN_URL')?>) break;
					idxActive=cms_grid.getColIndexById('active');
					if (idxActive)
						if (cms_grid.cells(tabId[i],idxActive).getValue()==0)
							continue;
					window.open('<?php echo SC_PS_PATH_REL;?>cms.php?id_cms='+tabId[i]);
					k++;
				}
			}else{
				var tabId=cms_grid.contextID.split('_');
				window.open('<?php echo SC_PS_PATH_REL;?>cms.php?id_cms='+tabId[0]);
			}
		}
		if (itemId=="copy"){
			if (lastColumnRightClicked!=0)
			{
				clipboardValue=cms_grid.cells(tabId,lastColumnRightClicked).getValue();
				cms_cmenu.setItemText('paste' , '<?php echo _l('Paste')?> '+cms_grid.cells(tabId,lastColumnRightClicked).getTitle().substr(0,30)+'...');
				clipboardType=lastColumnRightClicked;
			}
		}
		if (itemId=="paste"){
			if (lastColumnRightClicked!=0 && clipboardValue!=null && clipboardType==lastColumnRightClicked)
			{
				selection=cms_grid.getSelectedRowId();
				if (selection!='' && selection!=null)
				{
					selArray=selection.split(',');
					for(i=0 ; i < selArray.length ; i++)
					{
						cms_grid.cells(selArray[i],lastColumnRightClicked).setValue(clipboardValue);
						cms_grid.cells(selArray[i],lastColumnRightClicked).cell.wasChanged=true;
						onEditCell(null,selArray[i],lastColumnRightClicked,clipboardValue,null);
						catDataProcessor.setUpdated(selArray[i],true,"updated");
					}
				}
			}
		}
	}
	cms_cmenu.attachEvent("onClick", onGridCatContextButtonClick);
	var contextMenuXML='<menu absolutePosition="auto" mode="popup" maxItems="8"  globalCss="contextMenu" globalSecondCss="contextMenu" globalTextCss="contextMenuItem">'+
		'<item text="Object" id="object" enabled="false"/>'+
		'<item text="<?php echo _l('See on shop')?>" id="goshop"/>'+
		'<item text="<?php echo _l('Edit in PrestaShop BackOffice')?>" id="gopsbo"/>'+
		'<item text="<?php echo _l('Copy')?>" id="copy"/>'+
		'<item text="<?php echo _l('Paste')?>" id="paste"/>'+
	'</menu>';
	cms_cmenu.loadStruct(contextMenuXML);
	cms_grid.enableContextMenu(cms_cmenu);

	//#####################################
	//############ Events
	//#####################################

	// Click on a page
	function doOnRowSelected(idpage){
		if (!dhxLayout.cells('b').isCollapsed() && lastPageSelID!=idpage)
		{
			lastPageSelID=idpage;
			idxMetaTitle=cms_grid.getColIndexById('meta_title');
			if (propertiesPanel!='descriptions'){
				dhxLayout.cells('b').setText('<?php echo _l('Properties',1).' '._l('of',1)?> '+cms_grid.cells(lastPageSelID,idxMetaTitle).getValue());
			}
			if (propertiesPanel=='descriptions')
			{
				if (prop_tb._descriptionsLayout.cells('a').getFrame().contentWindow.checkSize())
				{
					prop_tb._descriptionsLayout.cells('a').getFrame().contentWindow.checkChange();
					dhxLayout.cells('b').setText('<?php echo _l('Properties',1).' '._l('of',1)?> '+cms_grid.cells(lastPageSelID,idxMetaTitle).getValue());
					prop_tb._descriptionsLayout.cells('a').getFrame().contentWindow.ajaxLoad('&id_page='+lastPageSelID+'&id_lang='+SC_ID_LANG,lastPageSelID,SC_ID_LANG);
				}else{
					dhtmlx.message({text:'<?php echo _l('Short description size must be < ')._s('CAT_SHORT_DESC_SIZE').' '._l('chars')?>',type:'error'});
				}
			}
<?php
	echo eval('?>'.$pluginProductProperties['doOnProductRowSelected'].'<?php ');
?>
		}
	}

	cms_grid.attachEvent("onRowSelect",doOnRowSelected);


function displayPages(callback)
{
	if (catselection!=0)
	{
		oldFilters=new Array();
		for(var i=0,l=cms_grid.getColumnsNum();i<l;i++)
		{
			if (cms_grid.getFilterElement(i)!=null && cms_grid.getFilterElement(i).value!='')
				oldFilters[cms_grid.getColumnId(i)]=cms_grid.getFilterElement(i).value;
		}
		if (firstPagesLoading==0)
		{
   		cms_grid.saveHiddenColumnsToCookie('cg_cms_treegrid_'+oldGridView,"expires=Fri, 31-Dec-2031 23:59:59 GMT");
			cms_grid.saveOrderToCookie('cg_cms_treegrid_'+oldGridView,"expires=Fri, 31-Dec-2031 23:59:59 GMT");
   		cms_grid.saveSortingToCookie('cg_cms_treegrid_'+oldGridView,"expires=Fri, 31-Dec-2031 23:59:59 GMT");
			cms_grid.saveSizeToCookie('cg_cms_treegrid_'+oldGridView,"expires=Fri, 31-Dec-2031 23:59:59 GMT");
   	}
		cms_grid.clearAll(true);
		cms_grid_sb.setText('');
		oldGridView=gridView;
   	firstPagesLoading=0;
		cms_grid_sb.setText('<?php echo _l('Loading in progress, please wait...')?>');
		cms_grid.loadXML("index.php?ajax=1&x=cms_page_get&tree_mode="+tree_mode+"&productsfrom="+displayPagesFrom+"&idc="+catselection+"&view="+gridView+"&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),function(){
			idxActive=cms_grid.getColIndexById('active');
			idxPosition=cms_grid.getColIndexById('position');
			if (idxPosition)
			{
				cms_grid_tb.enableItem('setposition');
			}else{
				cms_grid_tb.disableItem('setposition');
			}
			lastEditedCell=0;
			lastColumnRightClicked=0;
	    cms_grid.loadHiddenColumnsFromCookie('cg_cms_treegrid_'+gridView);
			cms_grid.loadOrderFromCookie('cg_cms_treegrid_'+gridView);
			cms_grid.loadSizeFromCookie('cg_cms_treegrid_'+gridView);
	    if (cms_grid._getCookie('cg_cms_treegrid_'+gridView,2)!='')
	    {
	    	cms_grid.loadSortingFromCookie('cg_cms_treegrid_'+gridView);
	    }
	    getRowsNum=cms_grid.getRowsNum();
   		cms_grid_sb.setText(getRowsNum+' '+(getRowsNum>1?'<?php echo _l('pages')?>':'<?php echo _l('page')?>')+(tree_mode=='all'?' <?php echo _l('in this category and all subcategories')?>':' <?php echo _l('in this category')?>'));
			for(var i=0;i<cms_grid.getColumnsNum();i++)
			{
				if (cms_grid.getFilterElement(i)!=null && oldFilters[cms_grid.getColumnId(i)]!=undefined)
				{
					cms_grid.getFilterElement(i).value=oldFilters[cms_grid.getColumnId(i)];
				}
			}
			cms_grid.filterByAll();
			if (!cms_grid.doesRowExist(lastPageSelID))
			{
				lastPageSelID=0;
			}else{
				cms_grid.selectRowById(lastPageSelID);
			}
   		if (callback!='') eval(callback);
			});
	}
}
firstPagesLoading=1;
tree_mode='';
catselection=1;
displayPagesFrom='';
gridView='grid_light';
propertiesPanel='';
displayPages();
</script>