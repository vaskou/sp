<?php

defined('_JEXEC') or die;

//require_once JPATH_SITE . '/components/com_spoudazo/spoudazo.php';

// Include dependancies
jimport('joomla.application.component.controller');

// Execute the task.
$controller	= JControllerLegacy::getInstance('Spoudazo');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();