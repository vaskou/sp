<?php
 
// No direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';
$moduleName = basename(dirname(__FILE__));
$document = JFactory::getDocument();

list($userName,$cityName) = modSpoudazoWelcomeHelper::getUserNameAndCity();

$document->addStylesheet(JURI::base(true) . '/modules/'.$moduleName.'/assets/css/' . $moduleName . '.css');

require JModuleHelper::getLayoutPath('mod_spoudazo_welcome');