<?php

class modSpoudazoPopupHelper
{
    /**
     * Retrieves the hello message
     *
     * @param   array  $params An object containing the module parameters
     *
     * @access public
     */    
    public static function getParams(&$params)
    {
        return $params;
    }
	
	public function showPopup()
	{
		$app = JFactory::getApplication();
		$jinput = $app->input;
		$cookie = $app->input->cookie;
		$user = JFactory::getUser();
		
		$hide_popup=false;
		
		if($cookie->get('spoudazoCookie')=='true' || $jinput->get('option')=='com_users' ){
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