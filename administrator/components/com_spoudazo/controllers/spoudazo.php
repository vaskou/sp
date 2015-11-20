<?php

defined('_JEXEC') or die;

require_once JPATH_COMPONENT_ADMINISTRATOR . '/controller.php';

class SpoudazoControllerSpoudazo extends SpoudazoController {

	public function addCityToUseState()
	{
		$app = JFactory::getApplication();
		
		$jinput = $app->input;
		
		$city_id=$jinput->get('id', null);
		
		$value = $jinput->get('value', '0');

		$city_list=$app->getUserState('com_spoudazo.city_list');
		
		$city_list = (!empty($city_list)) ? $city_list : array();
		
		if(!empty($city_id)){
			$city_list[$city_id]=$value;
		}
		
		$city_list=$app->setUserState('com_spoudazo.city_list', $city_list);
		
		echo new JResponseJson( array('data'=>$city_list) );
		
		jexit();
		
	}
}