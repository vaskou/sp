<?php
/**
 * @version		2.2
 * @package		Example K2 Plugin (K2 plugin)
 * @author		JoomlaWorks - http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die ;

/**
 * Example K2 Plugin to render YouTube URLs entered in backend K2 forms to video players in the frontend.
 */

// Load the K2 Plugin API
JLoader::register('K2Plugin', JPATH_ADMINISTRATOR.'/components/com_k2/lib/k2plugin.php');

// Initiate class to hold plugin events
class plgK2Onbeforesetquery extends K2Plugin
{

	// Some params
	//var $pluginName = 'citySelect';
	//var $pluginNameHumanReadable = 'City Select K2 Plugin';

	function plgK2Onbeforesetquery(&$subject, $params)
	{
		
		$app = JFactory::getApplication();
		
		if( !$app->isSite() )
		{
			return;
		}
		
		parent::__construct($subject, $params);
	}

	
	function onK2BeforeSetQuery(&$query)
	{
		//$app = JFactory::getApplication();



		//print '<pre>';
		//print_r($query);
		//print '</pre>';
		//var_dump($app->input->get('task', ''));
		//var_dump($query);
		
		//$item->text = 'It works! '.$item->text;
	}	
	

} // END CLASS
