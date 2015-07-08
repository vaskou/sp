<?php

class modSpoudazoWelcomeHelper
{
	
	public function getUserNameAndCity()
	{
		if (!class_exists('SpoudazoLibrary')) {return false;}
		$app = JFactory::getApplication();
		$cookie=$app->input->cookie;
		
		$user = JFactory::getUser();
		$isGuest = $user->get('guest');
		
		$cityName = '';
		
		if(!$isGuest){
			$userName = $user->name;
			$cityID = SpoudazoLibrary::getUserSelectedCity($user->id);
		}else{
			$userName = JText::_('MOD_SPOUDAZO_WELCOME_VISITOR');
			$cityID = $cookie->get('spoudazoCityID');
		}
		
		$cities=SpoudazoLibrary::getCities();
		
		foreach($cities as $city){
			if($city->id!='' && $city->id == $cityID){
				$cityName = JText::_('MOD_SPOUDAZO_WELCOME_FROM') . ' ' . htmlspecialchars($city->name);
			}
		}
		
		return array($userName,$cityName);
	}
}