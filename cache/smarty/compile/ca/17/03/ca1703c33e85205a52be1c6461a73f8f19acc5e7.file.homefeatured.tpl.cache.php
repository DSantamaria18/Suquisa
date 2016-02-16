<?php /* Smarty version Smarty-3.1.19, created on 2016-02-06 14:26:13
         compiled from "/var/www/vhosts/suquisa.com/httpdocs/themes/default-bootstrap/modules/homefeatured/homefeatured.tpl" */ ?>
<?php /*%%SmartyHeaderCode:128821326956b5f4759f0ff0-29595322%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ca1703c33e85205a52be1c6461a73f8f19acc5e7' => 
    array (
      0 => '/var/www/vhosts/suquisa.com/httpdocs/themes/default-bootstrap/modules/homefeatured/homefeatured.tpl',
      1 => 1454707220,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '128821326956b5f4759f0ff0-29595322',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56b5f475a1a607_50999655',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56b5f475a1a607_50999655')) {function content_56b5f475a1a607_50999655($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['products']->value)&&$_smarty_tpl->tpl_vars['products']->value) {?>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array('class'=>'homefeatured tab-pane','id'=>'homefeatured'), 0);?>

<?php } else { ?>
<ul id="homefeatured" class="homefeatured tab-pane">
	<li class="alert alert-info"><?php echo smartyTranslate(array('s'=>'No featured products at this time.','mod'=>'homefeatured'),$_smarty_tpl);?>
</li>
</ul>
<?php }?><?php }} ?>
