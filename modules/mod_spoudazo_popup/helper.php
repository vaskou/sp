<?php

class modSpoudazoPopupHelper
{
	
	public function showPopup()
	{
		$app = JFactory::getApplication();
		$jinput = $app->input;
		$cookie = $app->input->cookie;
		$user = JFactory::getUser();
		
		$hide_popup=false;
		
		if($cookie->get('spoudazoCookie')=='true' || $jinput->get('option')=='com_users' || $jinput->get('option')=='com_socialconnect'){
			$hide_popup=true;
		}
		
		$isGuest = $user->get('guest');
		
		if($isGuest && !$hide_popup){
			$document = JFactory::getDocument();
			$document->addScript(JURI::base().'modules/mod_spoudazo_popup/assets/js/script.js');
			return true;
		}
		
		return false;
	}
	
}