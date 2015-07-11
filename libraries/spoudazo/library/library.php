<?php

defined('JPATH_PLATFORM') or die;

class SpoudazoLibrary {
	
	public function set_cookie($cityID)
	{
		$app = JFactory::getApplication();
		
		$cookie=$app->input->cookie;
		
		$cookie->set('spoudazoCookie','true',time() + (10*365*24*60*60),'/' );
		$cookie->set('spoudazoCityID',$cityID,time() + (10*365*24*60*60),'/' );
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
		$query="SELECT id,name FROM #__k2_categories WHERE `plugins` LIKE '%\"citySelectisCity\":\"1\"%' AND `published`='1' UNION SELECT '' as id,'MOD_SPOUDAZO_POPUP_SELECT_CITY' as name ORDER BY name";
		$db->setQuery($query);
		$results = $db->loadObjectList();
		
		return $results;
	}
	
	public function getCity($cityID)
	{
		$db = JFactory::getDBO();
		
		$query="SELECT id,name,plugins FROM #__k2_categories WHERE `plugins` LIKE '%\"citySelectisCity\":\"1\"%' ";
		
		if($cityID){
			$query .= " AND id=$cityID";
		}
		
		$db->setQuery($query);
		$results = $db->loadObjectList();
		
		if(count($results) == 1){
			$plugins=json_decode($results[0]->plugins);
			$city['id']=$results[0]->id;
			$city['name']=$results[0]->name;
			$city['woeid']=$plugins->citySelectwoeid;
			$city['listID']=$plugins->citySelectlistID;
			
			return $city;
		}
		
		return false;
	}
	
	public function getCustomAuthorName($author)
	{
		$author_name = (!empty($author->groups) && in_array('13',$author->groups))?'SpoudaZO Team':$author->name;
		
		return $author_name;
	}
}