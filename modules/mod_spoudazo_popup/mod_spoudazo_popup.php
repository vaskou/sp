<?php
 
// No direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';

$app = JFactory::getApplication();

$cookie=$app->input->cookie;
$cityID = $cookie->get('spoudazoCityID');
$city = SpoudazoLibrary::getCity($cityID);

$user = JFactory::getUser();
$isGuest = $user->get('guest');
$username = $user->get('name');

modSpoudazoPopupHelper::showPopup();

$cities = SpoudazoLibrary::getCities();

require JModuleHelper::getLayoutPath('mod_spoudazo_popup', $params->get('layout', 'default'));