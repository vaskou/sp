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
		
		$cookie=$app->input->cookie;
		
		$user=$options['user'];
		
		$cityID = $this->getUserSelectedCity($user->id);

		$cookie->set('spoudazoCookie','true',time() + (10*365*24*60*60),'/' );
		$cookie->set('spoudazoCityID',$cityID,time() + (10*365*24*60*60),'/' );

		return true;
	}
	
	private function getUserSelectedCity($userID)
	{

		$app = JFactory::getApplication();
		
		$db = JFactory::getDBO();
		$query = "SELECT plugins FROM #__k2_users WHERE userID = ".$userID;
		$db->setQuery($query);
		$row = $db->loadObject();
		if (!$row)
		{
			$row = JTable::getInstance('K2User', 'Table');
		}
		
		try{
			$plugins=json_decode($row->plugins);
		}catch(  Exception $ex){
			
		}
		
		if(isset($plugins->citySelectcity)){
			return $plugins->citySelectcity;
		}
		return false;
	}
	
}
