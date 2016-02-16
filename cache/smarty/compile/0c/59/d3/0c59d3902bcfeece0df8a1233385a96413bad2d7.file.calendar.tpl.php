<?php /* Smarty version Smarty-3.1.19, created on 2016-02-09 10:51:21
         compiled from "/var/www/vhosts/suquisa.com/httpdocs/admin9359/themes/default/template/controllers/stats/calendar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:200702619056b9b699324e31-14718167%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0c59d3902bcfeece0df8a1233385a96413bad2d7' => 
    array (
      0 => '/var/www/vhosts/suquisa.com/httpdocs/admin9359/themes/default/template/controllers/stats/calendar.tpl',
      1 => 1454702833,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '200702619056b9b699324e31-14718167',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56b9b69934e383_52960944',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56b9b69934e383_52960944')) {function content_56b9b69934e383_52960944($_smarty_tpl) {?>

<div id="statsContainer" class="col-md-9">
	<?php echo $_smarty_tpl->getSubTemplate ("../../form_date_range_picker.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
