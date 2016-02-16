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
	if (version_compare(_PS_VERSION_, '1.5.0.0', '<') || Feature::isFeatureActive())
	{
?>
	<?php if(_r("GRI_CAT_PROPERTIES_GRID_FEATURE")) { ?>
		prop_tb.addListOption('panel', 'features', 5, "button", '<?php echo _l('Features',1)?>', "lib/img/eye.png");
		allowed_properties_panel[allowed_properties_panel.length] = "features";
	<?php } ?>
	


		
	prop_tb.addButton("feature_refresh", 100, "", "lib/img/arrow_refresh.png", "lib/img/arrow_refresh.png");
	prop_tb.setItemToolTip('feature_refresh','<?php echo _l('Refresh grid',1)?>');
	prop_tb.addButtonTwoState('feature_lightNavigation', 100, "", "lib/img/cursor.png", "lib/img/cursor.png");
	prop_tb.setItemToolTip('feature_lightNavigation','<?php echo _l('Light navigation (simple click on grid)',1)?>');
	prop_tb.addButtonTwoState('feature_filter', 100, "", "lib/img/filter.png", "lib/img/filter.png");
	prop_tb.setItemToolTip('feature_filter','<?php echo _l('Display only features used by products in the same category',1)?>');

	needInitFeatures = 1;
	function initFeatures(){
		if (needInitFeatures)
		{
			prop_tb._featuresLayout = dhxLayout.cells('b').attachLayout('1C');
			dhxLayout.cells('b').showHeader();
			prop_tb._featuresLayout.cells('a').hideHeader();
			prop_tb._featuresGrid = prop_tb._featuresLayout.cells('a').attachGrid();
			prop_tb._featuresGrid.setImagePath("lib/js/imgs/");
			
			// UISettings
			prop_tb._featuresGrid._uisettings_prefix='cat_feature_productfeature';
			prop_tb._featuresGrid._uisettings_name=prop_tb._featuresGrid._uisettings_prefix;
		   	prop_tb._featuresGrid._first_loading=1;
		   	
			// UISettings
			initGridUISettings(prop_tb._featuresGrid);
			
	prop_tb._featuresGrid.attachEvent("onEditCell",function(stage,rId,cInd,nValue,oValue){
					if (stage==1 && this.editor && this.editor.obj) this.editor.obj.select();
					idxID_feature_value=prop_tb._featuresGrid.getColIndexById('id_feature_value');
					if (cInd == idxID_feature_value)
					{
						if(stage==1){
					  		var editor = this.editor;
						    var pos = this.getPosition(editor.cell);
					    	var y = document.body.offsetHeight-pos[1];
					    	if(y < editor.list.offsetHeight)
							    editor.list.style.top = pos[1] - editor.list.offsetHeight + 'px';
					    }
						if (nValue>-2)
						{
<?php
// Not custom
	foreach($languages AS $lang){
		echo "				idxCustom".$lang['iso_code']."=prop_tb._featuresGrid.getColIndexById('custom_".$lang['iso_code']."');";
		echo "				prop_tb._featuresGrid.cells(rId,idxCustom".$lang['iso_code'].").setValue('');";
		echo "				prop_tb._featuresGrid.setCellExcellType(rId,idxCustom".$lang['iso_code'].",'ro');";
	}
?>
						}
						if (nValue==-2){
<?php
	// Custom
	foreach($languages AS $lang){
		echo "				idxCustom".$lang['iso_code']."=prop_tb._featuresGrid.getColIndexById('custom_".$lang['iso_code']."');";
		echo "				prop_tb._featuresGrid.setCellExcellType(rId,idxCustom".$lang['iso_code'].",'edtxt');";
	}
?>
						}
					}
					if (nValue!=oValue)
					{
						var ids = cat_grid.getSelectedRowId();
						var p_ids = new Array();
						if(ids.search(",")>=0)
							p_ids = ids.split(",");
						else
							p_ids[0] = ids;
					
						var nb_rows = p_ids.length*1 - 1;
					
						$.each(p_ids, function(num, p_id){
							var data = "";
							if(nb_rows!=num)
								data = "noUnBold";
						
							var params = {
								name: "cat_feature_productfeature_update_queue",
								row: rId,
								action: "update",
								params: {},
								callback: "callbackFeaturesProp('"+rId+"','update','"+rId+"','"+data+"');"
							};
							// COLUMN VALUES
							prop_tb._featuresGrid.forEachCell(rId,function(cellObj,ind){
								params.params[prop_tb._featuresGrid.getColumnId(ind)] = prop_tb._featuresGrid.cells(rId,ind).getValue();
							});
							params.params["id_product"] = p_id;
							params.params["id_lang"] = SC_ID_LANG;
							// USER DATA
							/*params.params['marginMatrix_form'] = specificPrice_grid.getUserData("", "marginMatrix_form");*/
							
							params.params = JSON.stringify(params.params);
							addInUpdateQueue(params,prop_tb._featuresGrid);
						});
					}
					return true;
				});
			needInitFeatures=1;
		}
	}



	function setPropertiesPanel_features(id){
		if (id=='features')
		{
			if(lastProductSelID!=undefined && lastProductSelID!="")
			{
				idxProductName=cat_grid.getColIndexById('name');
				dhxLayout.cells('b').setText('<?php echo _l('Properties',1).' '._l('of',1)?> '+cat_grid.cells(lastProductSelID,idxProductName).getValue());
			}
			hidePropTBButtons();
			prop_tb.showItem('feature_filter');
			prop_tb.showItem('feature_lightNavigation');
			prop_tb.showItem('feature_refresh');
			prop_tb.setItemText('panel', '<?php echo _l('Features',1)?>');
			prop_tb.setItemImage('panel', 'lib/img/eye.png');
			initFeatures();
			propertiesPanel='features';
			if (lastProductSelID!=0)
			{
				displayFeatures();
			}
		}
		if (id=='feature_refresh')
		{
			if (lastProductSelID!=0)
			{
				displayFeatures();
			}
		}
	}
	prop_tb.attachEvent("onClick", setPropertiesPanel_features);





	function setPropertiesPanelState_features(id,state){
		if (id=='feature_filter')
		{
			if (state)
			{
				featuresFilter=1;
			}else{
				featuresFilter=0;
			}
			displayFeatures();
		}
		if (id=='feature_lightNavigation')
		{
			if (state)
			{
				prop_tb._featuresGrid.enableLightMouseNavigation(true);
			}else{
				prop_tb._featuresGrid.enableLightMouseNavigation(false);
			}
		}
	}
	prop_tb.attachEvent("onStateChange", setPropertiesPanelState_features);


	function displayFeatures(){
		var tempIdList = 	cat_grid.getSelectedRowId();
		if (tempIdList == null || tempIdList == '') return false;
		prop_tb._featuresGrid.clearAll(true);
		$.post("index.php?ajax=1&act=cat_feature_productfeature_get&id_lang="+SC_ID_LANG+"&id_category="+catselection+"&filter="+featuresFilter+"&"+new Date().getTime(),{'id_product': tempIdList},function(data)
				{
					prop_tb._featuresGrid.parse(data);
					prop_tb._sb.setText("");
					/*featuresDataProcessorURLBase="index.php?ajax=1&act=cat_feature_productfeature_update&action=changedefault&id_product="+cat_grid.getSelectedRowId()+"&id_lang="+SC_ID_LANG;
					featuresDataProcessor.serverProcessor=featuresDataProcessorURLBase;
					featuresDataProcessor.init(prop_tb._featuresGrid);*/
				
		    		// UISettings
					loadGridUISettings(prop_tb._featuresGrid);
					
					// UISettings
					prop_tb._featuresGrid._first_loading=0;
				});
	}

	cat_grid.attachEvent("onRowSelect",function (idproduct){
			if (propertiesPanel=='features'){
				initFeatures();
				if (cat_grid.getSelectedRowId().indexOf(',')!=-1)
					dhxLayout.cells('b').setText('<?php echo _l('MULTIPLE EDITION',1)?>');
				displayFeatures();
			}
		});
		
	// CALLBACK FUNCTION
	function callbackFeaturesProp(sid,action,tid,data)
	{
		if (action=='update' && ((data!=undefined && data!="noUnBold") || data==undefined))
			prop_tb._featuresGrid.setRowTextNormal(sid);
	}

<?php
	}
