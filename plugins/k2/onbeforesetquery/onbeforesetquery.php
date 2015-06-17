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
		parent::__construct($subject, $params);
	}

	
	function onK2BeforeSetQuery(&$query)
	{
		$app = JFactory::getApplication();
		
		
		var_dump($app->input->get('task', ''));
		var_dump($query);
		
		//$item->text = 'It works! '.$item->text;
	}	
	
	/**
	 * Below we list all available FRONTEND events, to trigger K2 plugins.
	 * Watch the different prefix "onK2" instead of just "on" as used in Joomla! already.
	 * Most functions are empty to showcase what is available to trigger and output. A few are used to actually output some code for example reasons.
	 */

	function onK2PrepareContent(&$item, &$params, $limitstart)
	{
		$mainframe = JFactory::getApplication();
		//$item->text = 'It works! '.$item->text;
		

		}

	function onK2AfterDisplay(&$item, &$params, $limitstart)
	{
		$mainframe = JFactory::getApplication();
		return '';
	}

	function onK2BeforeDisplay(&$item, &$params, $limitstart)
	{
		$mainframe = JFactory::getApplication();
		return '';
	}

	function onK2AfterDisplayTitle(&$item, &$params, $limitstart)
	{
		$mainframe = JFactory::getApplication();
		return '';
	}

	function onK2BeforeDisplayContent(&$item, &$params, $limitstart)
	{
		$mainframe = JFactory::getApplication();
		return '';
	}

	// Event to display (in the frontend) the YouTube URL as entered in the item form
	function onK2AfterDisplayContent(&$item, &$params, $limitstart)
	{
		$mainframe = JFactory::getApplication();


		return '';
	}

	// Event to display (in the frontend) the YouTube URL as entered in the category form
	function onK2CategoryDisplay(&$category, &$params, $limitstart)
	{
		$mainframe = JFactory::getApplication();


		return '';
	}

	// Event to display (in the frontend) the YouTube URL as entered in the user form
	function onK2UserDisplay(&$user, &$params, $limitstart)
	{
		$mainframe = JFactory::getApplication();

		return '';
	}

} // END CLASS
