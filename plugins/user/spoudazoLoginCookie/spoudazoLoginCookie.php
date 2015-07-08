<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  User.joomla
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

$lang = JFactory::getLanguage(); 
$lang->load('plg_user_spoudazoLoginCookie');

class PlgUserSpoudazoLoginCookie extends JPlugin
{
	
	function onUserAfterLogin($options)
	{
		if (!class_exists('SpoudazoLibrary')) {return false;}
		$app = JFactory::getApplication();
		
		//Check if we are in frontend
		if(!$app->isSite()){
			return true;
		}
		
		$user=$options['user'];
		
		$cityID = SpoudazoLibrary::getUserSelectedCity($user->id);
		
		if(!$cityID){
			$app->redirect(JRoute::_('index.php?option=com_users&view=profile&layout=edit'),JText::_('SPOUDAZOLOGINCOOKIE_MESSAGE'),'error');
		}
		
		SpoudazoLibrary::set_cookie($cityID);

		return true;
	}
	
	function onUserAfterSave($user, $isnew, $success, $msg)
	{
		if (!class_exists('SpoudazoLibrary')) {return false;}
		if($user->id){
			$cityID = SpoudazoLibrary::getUserSelectedCity($user->id);
		
			SpoudazoLibrary::set_cookie($cityID);
		}
	}
	
}
