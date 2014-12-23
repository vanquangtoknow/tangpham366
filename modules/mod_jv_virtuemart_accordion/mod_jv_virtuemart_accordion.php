<?php
/**
 * @package JV Virtuemart Accordion module for Joomla! 1.5
 * @author http://www.joomlavision.com
 * @copyright (C) 2010- JoomlaVision.Com
 * @license PHP files are GNU/GPL
**/
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');
$id_mod = $module->id;
$jvAccodion = new modjv_virtuemart_accordionHelper($params);
$list = $jvAccodion->jvAccordion($id_mod);
require(JModuleHelper::getLayoutPath('mod_jv_virtuemart_accordion'));