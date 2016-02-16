<?php /* Smarty version Smarty-3.1.19, created on 2016-02-15 19:48:59
         compiled from "/var/www/vhosts/suquisa.com/httpdocs/admin9359/themes/default/template/controllers/cms_content/content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:82762566056c21d9b5bc6c5-01984834%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8eaf07d4efe469fd0842f8477d39bb9b2394870b' => 
    array (
      0 => '/var/www/vhosts/suquisa.com/httpdocs/admin9359/themes/default/template/controllers/cms_content/content.tpl',
      1 => 1454702816,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '82762566056c21d9b5bc6c5-01984834',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cms_breadcrumb' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56c21d9b5cef61_24068731',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56c21d9b5cef61_24068731')) {function content_56c21d9b5cef61_24068731($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['cms_breadcrumb']->value)) {?>
	<ul class="breadcrumb cat_bar">
		<?php echo $_smarty_tpl->tpl_vars['cms_breadcrumb']->value;?>

	</ul>
<?php }?>

<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

<?php }} ?>
