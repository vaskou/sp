<?php

class modSpoudazoWelcomeHelper
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
	
	public function getUserSelectedCity($userID)
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
	
	public function getCities()
	{
		$db = JFactory::getDBO();
		$query="SELECT id,name FROM #__k2_categories WHERE `plugins` LIKE '%\"citySelectisCity\":\"1\"%' UNION SELECT '' as id,'None' as name ORDER BY name";
		$db->setQuery($query);
		$results = $db->loadObjectList();
		
		return $results;
	}
	
	public function getUserNameAndCity()
	{
		$app = JFactory::getApplication();
		$cookie=$app->input->cookie;
		
		$user = JFactory::getUser();
		$isGuest = $user->get('guest');
		
		$cityName = '';
		
		if(!$isGuest){
			$userName = $user->name;
			$cityID = modSpoudazoWelcomeHelper::getUserSelectedCity($user->id);
		}else{
			$userName = JText::_('MOD_SPOUDAZO_WELCOME_VISITOR');
			$cityID = $cookie->get('spoudazoCityID');
		}
		
		$cities=self::getCities();
		
		foreach($cities as $city){
			if($city->id!='' && $city->id == $cityID){
				$cityName = JText::_('MOD_SPOUDAZO_WELCOME_FROM') . ' ' . htmlspecialchars($city->name);
			}
		}
		
		return array($userName,$cityName);
	}
}