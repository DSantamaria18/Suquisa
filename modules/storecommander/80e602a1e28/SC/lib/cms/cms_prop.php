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
	prop_tb=dhxLayout.cells('b').attachToolbar();
	prop_tb._sb=dhxLayout.cells('b').attachStatusBar();
	icons=Array(
							Array('descriptions',"obj",'<?php echo _l('Descriptions')?>',"lib/img/description.png")
<?php
	echo eval('?>'.$pluginProductProperties['Title'].'<?php ');
?>
							);
	prop_tb.addButton("help", 0, "", "lib/img/help.png", "lib/img/help.png");
	prop_tb.setItemToolTip('help','<?php echo _l('Help')?>');
<?php
	echo eval('?>'.$pluginProductProperties['ToolbarButtons'].'<?php ');
?>
	prop_tb.addText('txt_descriptionsize', 0, '<?php echo _l('Short description size')._l(':').' '.'0/'._s('CAT_SHORT_DESC_SIZE')?>');
	prop_tb.addButton('desc_save',0,'','lib/img/page_save.png','lib/img/page_save.png');
	prop_tb.setItemToolTip('desc_save','<?php echo _l('Save descriptions')?>');

	prop_tb.addButtonSelect('panel',0,'<?php echo _l('Descriptions',1)?>',icons,'lib/img/description.png','lib/img/description.png',false,true);
	prop_tb.setItemToolTip('panel','<?php echo _l('Select properties panel',1)?>');
	prop_tb._imagesUploadWindow=new Array();

	function hidePropTBButtons()
	{
		prop_tb.hideItem('txt_descriptionsize');
		prop_tb.hideItem('desc_save');
<?php
	echo eval('?>'.$pluginProductProperties['HideToolbarButtons'].'<?php ');
?>
	}

	function setPropertiesPanel(id)
	{
		if (id=='help'){
			<?php echo "window.open('".getHelpLink('cms_toolbar_page_prop')."');"; ?>
		}
		// ask to save description if modified
		if (propertiesPanel=='descriptions' && id!='desc_save' && typeof prop_tb._descriptionsLayout!='undefined')
			prop_tb._descriptionsLayout.cells('a').getFrame().contentWindow.checkChange();

		if (id=='desc_save')
		{
			prop_tb._descriptionsLayout.cells('a').getFrame().contentWindow.ajaxSave();
		}
		prop_tb._sb.setText('');
		if (id=='descriptions')
		{
			hidePropTBButtons();
			prop_tb.showItem('desc_save');
			prop_tb.showItem('txt_descriptionsize');
			prop_tb.setItemText('panel', '<?php echo _l('Descriptions')?>');
			prop_tb.setItemImage('panel', 'lib/img/description.png');
			URLOptions='';
			if (lastPageSelID!=0) URLOptions='&id_cms='+lastPageSelID+'&id_lang='+SC_ID_LANG;
			prop_tb._descriptionsLayout = dhxLayout.cells('b').attachLayout('1C');
			prop_tb._descriptionsLayout.cells('a').hideHeader();
			prop_tb._descriptionsLayout.cells('a').attachURL('index.php?ajax=1&p=cat_description'+URLOptions);
			propertiesPanel='descriptions';
			dhxLayout.cells('b').setWidth(660);//605
		}
<?php
	echo eval('?>'.$pluginProductProperties['ToolbarActions'].'<?php ');
?>
		dhxLayout.cells('b').showHeader();
	}

	prop_tb.attachEvent("onClick", setPropertiesPanel);

//#####################################
//############ Load functions
//#####################################

<?php
	echo eval('?>'.$pluginProductProperties['DisplayPlugin'].'<?php ');
?>

	setPropertiesPanel(propertiesPanel);

</script>