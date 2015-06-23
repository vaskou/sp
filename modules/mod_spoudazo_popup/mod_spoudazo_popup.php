<?php
 
// No direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';

modSpoudazoPopupHelper::showPopup();

$params = modSpoudazoPopupHelper::getParams($params);

$cities = SpoudazoLibrary::getCities();

require JModuleHelper::getLayoutPath('mod_spoudazo_popup');