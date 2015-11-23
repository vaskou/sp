<?php

defined('_JEXEC') or die;

require_once JPATH_COMPONENT_ADMINISTRATOR . '/controller.php';

class SpoudazoControllerSpoudazo extends SpoudazoController {

	public function addCityToUseState()
	{
		$app = JFactory::getApplication();
		
		$jinput = $app->input;
		
		$module_id=$jinput->get('module_id', 0);
		if(!$module_id) return;
		
		$city_id=$jinput->get('id', null);
		
		$value = $jinput->get('value', '0');

		$city_list=$app->getUserState('com_spoudazo.'.$module_id.'.city_list');
		
		$city_list = (!empty($city_list)) ? $city_list : array();
		
		if( !empty($city_id) ) {
			if($value == '0'){
				unset ( $city_list[$city_id] );
			}else{
				$city_list[$city_id]=$value;
			}
		}
		
		$city_list=$app->setUserState('com_spoudazo.'.$module_id.'.city_list', $city_list);
		
		echo new JResponseJson( array('data'=>$city_list) );
		
		jexit();
		
	}
	
	public function includeExclude()
	{
		$app = JFactory::getApplication();
		
		$jinput = $app->input;
		
		$module_id=$jinput->get('module_id', 0);
		if(!$module_id) return;
		
		$value = $jinput->get('value', 'disabled');
		
		$include_exclude=$app->setUserState('com_spoudazo.'.$module_id.'.include_exclude', $value);
		
		echo new JResponseJson( array('data'=>$include_exclude) );
		
		jexit();
		
	}
}