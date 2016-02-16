<?php
defined('_JEXEC') or die;

/**
 * Template for Joomla! CMS, created with Artisteer.
 * See readme.txt for more details on how to use the template.
 */

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'functions.php';

// Create alias for $this object reference:
$document = $this;

// Shortcut for template base url:
$templateUrl = $document->baseurl . '/templates/' . $document->template;

Artx::load("Artx_Page");

// Initialize $view:
$view = $this->artx = new ArtxPage($this);

// Decorate component with Artisteer style:
$view->componentWrapper();

JHtml::_('behavior.framework', true);

?>
<!DOCTYPE html>
<html dir="ltr" lang="<?php echo $document->language; ?>">
<head>
    <jdoc:include type="head" />
    <link rel="stylesheet" href="<?php echo $document->baseurl; ?>/templates/system/css/system.css" />
    <link rel="stylesheet" href="<?php echo $document->baseurl; ?>/templates/system/css/general.css" />

    <!-- Created by Artisteer v4.1.0.60046 -->
    
    
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">

    <!--[if lt IE 9]><script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.css" media="screen">
    <!--[if lte IE 7]><link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.ie7.css" media="screen" /><![endif]-->
    <link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.responsive.css" media="all">


    <script>if ('undefined' != typeof jQuery) document._artxJQueryBackup = jQuery;</script>
    <script src="<?php echo $templateUrl; ?>/jquery.js"></script>
    <script>jQuery.noConflict();</script>

    <script src="<?php echo $templateUrl; ?>/script.js"></script>
    <?php $view->includeInlineScripts() ?>
    <script>if (document._artxJQueryBackup) jQuery = document._artxJQueryBackup;</script>
    <script src="<?php echo $templateUrl; ?>/script.responsive.js"></script>
</head>
<body>

<div id="jq-main">
<header class="jq-header"><?php echo $view->position('position-30', 'jq-nostyle'); ?>

    <div class="jq-shapes">
  
        <div class="jq-object1029144251" data-left="3.01%">  <a href="<?php echo $document->baseurl; ?>/"><img src="<?php echo $document->baseurl; ?>/images/logo.png" width="140px" height="90px" alt="Higiene Industrial"  title="Higiene Industrial"></a></div>
<!--<div class="jq-object1384352361" data-left="96.38%">  -->
<div class="clogin"><a href="http://www.igarle.es/tienda_suquisa/"><img src="<?php echo $document->baseurl; ?>/images/login.png" width="20px" height="20px" alt="Area de clientes" title="Area de clientes"></a><div><a href="http://www.igarle.es/tienda_suquisa/">Area de clientes</a></div></div>
<!--<div><a href="http://www.adial.net"><img src="<?php echo $document->baseurl; ?>/images/adial.png" alt="Distribución de productos y maquinaria de limpieza e higiene profesional" title="Distribución de productos y maquinaria de limpieza e higiene profesional"></a></div>-->
         <!--   </div>-->
            
<h1 class="jq-headline" data-left="3.1%">
    <!--<a href="<?php echo $document->baseurl; ?>/">HIGIENE INDUSTRIAL<?php echo $this->params->get('siteTitle'); ?></a>-->
</h1>




                        
                    
</header>
<?php if ($view->containsModules('position-1', 'position-28', 'position-29')) : ?>
<nav class="jq-nav">
    
<?php if ($view->containsModules('position-28')) : ?>
<div class="jq-hmenu-extra1"><?php echo $view->position('position-28'); ?></div>
<?php endif; ?>
<?php if ($view->containsModules('position-29')) : ?>
<div class="jq-hmenu-extra2"><?php echo $view->position('position-29'); ?></div>
<?php endif; ?>


<?php echo $view->position('position-1'); ?>

    </nav>
<?php endif; ?>

<div class="jq-sheet clearfix">
            <?php echo $view->position('position-15', 'jq-nostyle'); ?>
<?php echo $view->positions(array('position-16' => 33, 'position-17' => 33, 'position-18' => 34), 'jq-block'); ?>
<div class="jq-layout-wrapper">
                <div class="jq-content-layout">
                    <div class="jq-content-layout-row">
                        <div class="jq-layout-cell jq-content">
<?php
  echo $view->position('position-19', 'jq-nostyle');
  if ($view->containsModules('position-2'))
    echo artxPost($view->position('position-2'));
  echo $view->positions(array('position-20' => 50, 'position-21' => 50), 'jq-article');
  echo $view->position('position-12', 'jq-nostyle');
  echo artxPost(array('content' => '<jdoc:include type="message" />', 'classes' => ' jq-messages'));
  echo '<jdoc:include type="component" />';
  echo $view->position('position-22', 'jq-nostyle');
  echo $view->positions(array('position-23' => 50, 'position-24' => 50), 'jq-article');
  echo $view->position('position-25', 'jq-nostyle');
?>




                        </div>
                    </div>
                </div>
            </div>
<?php echo $view->positions(array('position-9' => 33, 'position-10' => 33, 'position-11' => 34), 'jq-block'); ?>
<?php echo $view->position('position-26', 'jq-nostyle'); ?>


    </div>
<footer class="jq-footer">
  <div class="jq-footer-inner">
<?php if ($view->containsModules('position-27')) : ?>
    <?php echo $view->position('position-27', 'jq-nostyle'); ?>
<?php else: ?>
<div><a href="index.php?option=com_content&view=article&id=8">Aviso Legal</a></div>
<!--<div>Política de Privacidad</div>-->
<div style="width: 50%;float:left;">
<p></p>
<p>Pol. Ind. Ugaldeguren II, Naves 10 - 11</p><p>48170 Zamudio</p><p>Bizkaia</p><p>Teléfono 944 52 22 00</p><p>Fax 944 52 25 50</p>
<p><a href="mailto:suquisa@suquisa.net?Subject=Peticion%20de%20informacion">suquisa@suquisa.net</a></p>
</div>
<div style="width: 50%;float:right;">
<p>Sierra Donesteve,17 - Entrep. Local 5</p><p>39610 Astillero</p><p>Cantabria</p><p>Teléfono 942 54 33 29</p><p>Fax 944 52 22 00</p>
<p><a href="mailto:suquisa@suquisa.net?Subject=Peticion%20de%20informacion">suquisa@suquisa.net</a></p>
  <?php endif; ?>
</div>
</footer>

</div>



<?php echo $view->position('debug'); ?>
</body>
</html>