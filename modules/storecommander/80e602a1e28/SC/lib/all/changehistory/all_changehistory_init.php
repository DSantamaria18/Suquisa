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
	var lHistory = new dhtmlXLayoutObject(wCatHistory, "1C");
	lHistory.cells('a').setText('<?php echo _l('History',1);?>');
	his_grid=lHistory.cells('a').attachGrid();
	his_grid.setImagePath('lib/js/imgs/');
	his_grid.setHeader("ID,<?php echo _l('ID employee')?>,<?php echo _l('Section')?>,<?php echo _l('Action')?>,<?php echo _l('Object')?>,<?php echo _l('Old value')?>,<?php echo _l('New value')?>,<?php echo _l('Object ID')?>,<?php echo _l('Lang ID')?>,<?php echo _l('Table')?>,<?php echo _l('Date')?>");
	his_grid.setColumnIds("id_history,id_employee,section,action,object,oldvalue,newvalue,object_id,lang_id,table,date_add");
	his_grid.setInitWidths("50,50,90,75,100,100,100,60,60,100,115");
	his_grid.setColAlign("right,left,left,left,left,left,left,right,right,left,left");
	his_grid.setColTypes("ro,ro,ro,ro,ro,ed,ed,ro,ro,ro,ro");
  his_grid.enableSmartRendering(true);
  his_grid.enableMultiline(true);
	his_grid.setColSorting("int,str,str,str,str,str,str,int,int,str,str");
	his_grid.attachHeader("#text_filter,#text_filter,#select_filter,#select_filter,#select_filter,#text_filter,#text_filter,#numeric_filter,#numeric_filter,#select_filter,#text_filter");
	his_grid.setDateFormat("%Y-%m-%d");
	his_grid.init();
	his_grid.enableHeaderMenu();

	his_grid_sb=lHistory.cells('a').attachStatusBar();
	
	his_tb=lHistory.cells('a').attachToolbar();
	his_tb.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
	his_tb.setItemToolTip('delete','<?php echo _l('Delete all history',1)?>');
	his_tb.addButton("refresh", 0, "", "lib/img/arrow_refresh.png", "lib/img/arrow_refresh.png");
	his_tb.setItemToolTip('refresh','<?php echo _l('Refresh grid',1)?>');
	his_tb.attachEvent("onClick",
		function(id){
			if (id=='refresh'){
				displayHistory();
			}
			if (id=='delete'){
				if (confirm('<?php echo _l('This action will delete all history, do you confirm this action?',1)?>'))
				{
					$.get('index.php?ajax=1&act=all_changehistory_delete',function(){displayHistory();});
				}
			}
		});

	function displayHistory(callback)
	{
		his_grid.clearAll();
		his_grid_sb.setText('');
		his_grid_sb.setText('<?php echo _l('Loading in progress, please wait...',1)?>');
		his_grid.load("index.php?ajax=1&act=all_changehistory_get&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),function(){
	    getRowsNum=his_grid.getRowsNum();
	 		his_grid_sb.setText(getRowsNum+' '+(getRowsNum>1?'<?php echo _l('actions',1)?>':'<?php echo _l('action')?>'));
	    his_grid.filterByAll();
			if (callback!='') eval(callback);
			});
	}

	displayHistory();
	//lHistory.cells('b').collapse();
</script>