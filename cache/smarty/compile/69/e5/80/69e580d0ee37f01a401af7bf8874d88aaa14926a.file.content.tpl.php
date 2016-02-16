<?php /* Smarty version Smarty-3.1.19, created on 2016-02-15 19:53:19
         compiled from "/var/www/vhosts/suquisa.com/httpdocs/admin9359/themes/default/template/content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:35213790756c21e9f852883-68019364%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '69e580d0ee37f01a401af7bf8874d88aaa14926a' => 
    array (
      0 => '/var/www/vhosts/suquisa.com/httpdocs/admin9359/themes/default/template/content.tpl',
      1 => 1454702793,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '35213790756c21e9f852883-68019364',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56c21e9f861d82_36179941',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56c21e9f861d82_36179941')) {function content_56c21e9f861d82_36179941($_smarty_tpl) {?>
<div id="ajax_confirmation" class="alert alert-success hide"></div>

<div id="ajaxBox" style="display:none"></div>


<div class="row">
	<div class="col-lg-12">
		<?php if (isset($_smarty_tpl->tpl_vars['content']->value)) {?>
			<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

		<?php }?>
	</div>
</div><?php }} ?>
