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

/**
 * Joomla User plugin
 *
 * @since  1.5
 */
class PlgUserSpoudazoLoginCookie extends JPlugin
{
	
	function onUserAfterLogin($options)
	{

		$app = JFactory::getApplication();
		
		//Check if we are in frontend
		if(!$app->isSite()){
			return true;
		}
		
		$user=$options['user'];
		
		$cityID = SpoudazoLibrary::getUserSelectedCity($user->id);
		
		SpoudazoLibrary::set_cookie($cityID);

		return true;
	}
	
}
