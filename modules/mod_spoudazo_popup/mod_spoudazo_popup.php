<?php
 
// No direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';

if (!class_exists('SpoudazoLibrary')) {return false;}

$app = JFactory::getApplication();

$user = JFactory::getUser();
$isGuest = $user->get('guest');
$username = $user->get('name');

$cookie=$app->input->cookie;
if($isGuest){
	$cityID = $cookie->get('spoudazoCityID');
}else{
	$cityID = SpoudazoLibrary::getUserSelectedCity($user->get('id'));
}
$city = SpoudazoLibrary::getCity($cityID);

modSpoudazoPopupHelper::showPopup();

$cities = SpoudazoLibrary::getCities();

require JModuleHelper::getLayoutPath('mod_spoudazo_popup', $params->get('layout', 'default'));