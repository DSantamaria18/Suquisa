<?php /* Smarty version Smarty-3.1.19, created on 2016-02-06 14:26:11
         compiled from "/var/www/vhosts/suquisa.com/httpdocs/modules/blockfacebook/blockfacebook.tpl" */ ?>
<?php /*%%SmartyHeaderCode:57832659056b5f473c38ee5-08148995%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3656e133e995e0efb90ff62e0058a10936d2e977' => 
    array (
      0 => '/var/www/vhosts/suquisa.com/httpdocs/modules/blockfacebook/blockfacebook.tpl',
      1 => 1454704951,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '57832659056b5f473c38ee5-08148995',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'facebookurl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56b5f4747d8286_30314848',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56b5f4747d8286_30314848')) {function content_56b5f4747d8286_30314848($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['facebookurl']->value!='') {?>
<div id="fb-root"></div>
<div id="facebook_block" class="col-xs-4">
	<h4 ><?php echo smartyTranslate(array('s'=>'Follow us on Facebook','mod'=>'blockfacebook'),$_smarty_tpl);?>
</h4>
	<div class="facebook-fanbox">
		<div class="fb-like-box" data-href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['facebookurl']->value, ENT_QUOTES, 'UTF-8', true);?>
" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false">
		</div>
	</div>
</div>
<?php }?>
<?php }} ?>
