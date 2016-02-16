<?php /* Smarty version Smarty-3.1.19, created on 2016-02-09 11:34:45
         compiled from "/var/www/vhosts/suquisa.com/httpdocs/admin9359/themes/default/template/helpers/tree/tree_node_item_radio.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7526958756b9c0c5acfda8-19480181%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '26056c61d97957410cf96372a307447b0f2f75d9' => 
    array (
      0 => '/var/www/vhosts/suquisa.com/httpdocs/admin9359/themes/default/template/helpers/tree/tree_node_item_radio.tpl',
      1 => 1454702843,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7526958756b9c0c5acfda8-19480181',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'node' => 0,
    'input_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56b9c0c5b5e461_44294278',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56b9c0c5b5e461_44294278')) {function content_56b9c0c5b5e461_44294278($_smarty_tpl) {?>
<li class="tree-item<?php if (isset($_smarty_tpl->tpl_vars['node']->value['disabled'])&&$_smarty_tpl->tpl_vars['node']->value['disabled']==true) {?> tree-item-disable<?php }?>">
	<label class="tree-item-name">
		<input type="radio" name="<?php echo $_smarty_tpl->tpl_vars['input_name']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['node']->value['id_category'];?>
"<?php if (isset($_smarty_tpl->tpl_vars['node']->value['disabled'])&&$_smarty_tpl->tpl_vars['node']->value['disabled']==true) {?> disabled="disabled"<?php }?> />
		<i class="tree-dot"></i>
		<?php echo $_smarty_tpl->tpl_vars['node']->value['name'];?>

	</label>
</li><?php }} ?>
