<?php /* Smarty version Smarty-3.1.19, created on 2016-02-09 13:29:43
         compiled from "/var/www/vhosts/suquisa.com/httpdocs/admin9359/themes/default/template/helpers/list/list_action_details.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9152560056b9dbb75adc34-79659547%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '69e087c7ba0f2e41b1ac269bbaffb24ace1eed13' => 
    array (
      0 => '/var/www/vhosts/suquisa.com/httpdocs/admin9359/themes/default/template/helpers/list/list_action_details.tpl',
      1 => 1454702840,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9152560056b9dbb75adc34-79659547',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'params' => 0,
    'id' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56b9dbb7618bc7_50580270',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56b9dbb7618bc7_50580270')) {function content_56b9dbb7618bc7_50580270($_smarty_tpl) {?>

<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['href']->value, ENT_QUOTES, 'UTF-8', true);?>
" id="details_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['action'], ENT_QUOTES, 'UTF-8', true);?>
_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="">
	<i class="icon-eye-open"></i> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>

</a><?php }} ?>
