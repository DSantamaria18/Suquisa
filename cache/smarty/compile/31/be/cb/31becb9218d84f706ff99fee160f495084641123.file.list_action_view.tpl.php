<?php /* Smarty version Smarty-3.1.19, created on 2016-02-15 19:49:39
         compiled from "/var/www/vhosts/suquisa.com/httpdocs/admin9359/themes/default/template/helpers/list/list_action_view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:37632868156c21dc34c9c95-88619032%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '31becb9218d84f706ff99fee160f495084641123' => 
    array (
      0 => '/var/www/vhosts/suquisa.com/httpdocs/admin9359/themes/default/template/helpers/list/list_action_view.tpl',
      1 => 1454702841,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '37632868156c21dc34c9c95-88619032',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56c21dc34e77f7_52650269',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56c21dc34e77f7_52650269')) {function content_56c21dc34e77f7_52650269($_smarty_tpl) {?>
<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['href']->value, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" >
	<i class="icon-search-plus"></i> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>

</a><?php }} ?>
