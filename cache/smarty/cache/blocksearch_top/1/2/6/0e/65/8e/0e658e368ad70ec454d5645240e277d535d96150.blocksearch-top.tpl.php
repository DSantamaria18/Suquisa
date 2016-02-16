<?php /*%%SmartyHeaderCode:88814332256b5f427f2e384-79509550%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0e658e368ad70ec454d5645240e277d535d96150' => 
    array (
      0 => '/var/www/vhosts/suquisa.com/httpdocs/themes/default-bootstrap/modules/blocksearch/blocksearch-top.tpl',
      1 => 1454707217,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '88814332256b5f427f2e384-79509550',
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_56bcbcb2b7fa46_91455765',
  'has_nocache_code' => false,
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56bcbcb2b7fa46_91455765')) {function content_56bcbcb2b7fa46_91455765($_smarty_tpl) {?><div id="search_block_top" class="col-sm-4 clearfix"><form id="searchbox" method="get" action="http://suquisa.com/ca/buscar" > <input type="hidden" name="controller" value="search" /> <input type="hidden" name="orderby" value="position" /> <input type="hidden" name="orderway" value="desc" /> <input class="search_query form-control" type="text" id="search_query_top" name="search_query" placeholder="Cercar" value="" /> <button type="submit" name="submit_search" class="btn btn-default button-search"> <span>Cercar</span> </button></form></div><?php }} ?>
