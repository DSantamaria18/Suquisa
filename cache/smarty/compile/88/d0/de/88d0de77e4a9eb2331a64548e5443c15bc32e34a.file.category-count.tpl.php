<?php /* Smarty version Smarty-3.1.19, created on 2016-02-15 22:44:01
         compiled from "/var/www/vhosts/suquisa.com/httpdocs/themes/default-bootstrap/category-count.tpl" */ ?>
<?php /*%%SmartyHeaderCode:146421566156c246a155f3e5-67943808%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '88d0de77e4a9eb2331a64548e5443c15bc32e34a' => 
    array (
      0 => '/var/www/vhosts/suquisa.com/httpdocs/themes/default-bootstrap/category-count.tpl',
      1 => 1454707144,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '146421566156c246a155f3e5-67943808',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'category' => 0,
    'nb_products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56c246a15a2678_09537007',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56c246a15a2678_09537007')) {function content_56c246a15a2678_09537007($_smarty_tpl) {?>
<span class="heading-counter"><?php if ((isset($_smarty_tpl->tpl_vars['category']->value)&&$_smarty_tpl->tpl_vars['category']->value->id==1)||(isset($_smarty_tpl->tpl_vars['nb_products']->value)&&$_smarty_tpl->tpl_vars['nb_products']->value==0)) {?><?php echo smartyTranslate(array('s'=>'There are no products in this category.'),$_smarty_tpl);?>
<?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['nb_products']->value)&&$_smarty_tpl->tpl_vars['nb_products']->value==1) {?><?php echo smartyTranslate(array('s'=>'There is 1 product.'),$_smarty_tpl);?>
<?php } elseif (isset($_smarty_tpl->tpl_vars['nb_products']->value)) {?><?php echo smartyTranslate(array('s'=>'There are %d products.','sprintf'=>$_smarty_tpl->tpl_vars['nb_products']->value),$_smarty_tpl);?>
<?php }?><?php }?></span>
<?php }} ?>
