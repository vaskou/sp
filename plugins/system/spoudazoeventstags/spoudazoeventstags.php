<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_k2/tables');
JLoader::register('K2HelperRoute', JPATH_ROOT.'/components/com_k2/helpers/route.php');

jimport( 'joomla.plugin.plugin' );
jimport( 'joomla.application.module.helper' );
jimport( 'joomla.event.plugin' );
/**
 * Class exists checking
 */
if (!class_exists('plgSystemspoudazoweather')) {
	
    /**
     * Plugin entrypoint
     * @link http://docs.joomla.org/Plugin/Events/System
     */
    class plgSystemSpoudazoeventstags extends JPlugin {
		
		var $_params;
		var $_pluginPath;

        /**
         * Construct method
         * @param type $subject
         * @param type $config
         */
        function plgSystemSpoudazoeventstags(& $subject, $config) {
            parent::__construct($subject, $config);
			$this->_plugin = JPluginHelper::getPlugin( 'system', 'spoudazoeventstags' );
			$this->_params = new JForm( $this->_plugin->params );
			$this->_pluginPath = JPATH_PLUGINS."/system/spoudazoeventstags/";
        }
		
		public function onAfterDispatch()
		{
			$app = JFactory::getApplication();
			//$cookie=$app->input->cookie;

			//If not in forntend, return
			if(!$app->isSite()){
				return;
			}
	
			//Get k2 Tools module params
			$mod_k2_tools=JModuleHelper::getModule('mod_k2_tools','Event tags');
			
			
			$params=json_decode($mod_k2_tools->params,true);

			//If not calendar mode, reutrn. module_usage=2 for calendar mode
			if( $params ['module_usage'] !='7')
			{
				return;	
			}

			//If not in K2 category view mode, return
			//if(  $app->input->get('option','','string') != 'com_k2' )
			//{
			//	return;	
			//}
			//
			//if(  $app->input->get('view','','string') != 'itemlist')
			//{
			//	return;	
			//}
			//
			//if(  $app->input->get('layout','','string') != 'category')
			//{
			//	return;	
			//}
			
			//Get the current menu by Itemid
			$Itemid = $app->input->get('Itemid','0','int');
			$menu =  $app->getMenu()->getItem($Itemid);
			
			//Filter tag item result by category. This is needed becasue otherwise, it shows items from ALL K2!!!!!
			if( $menu -> menutype == 'events' ){
				$categories = $menu->params -> get ('categories');
				//$category=$categories[0];
				
				$params ['cloud_category'] = $categories;
				//$params ['calendarCategory'] = $category;
			}
			
			
			
			//Set the calendarCategory equal to current category id
			//if( $app->input->get('id','0','string') !='0'){
			//	$cloud_category=array();
			//	$cloud_category['0'] = $app->input->get('id','0','string');
			//	$params ['cloud_category'] = $cloud_category;
			//}
			//else{
				//$cloud_category['0']= '10000000000000';
			//}
			
			
	
			
			
			$mod_k2_tools->params=json_encode($params);
			
			
			
			//$user = JFactory::getUser();
			//$userID=$user->id;
			//
			//if( $user->get('guest') && $cookie->get('spoudazoCityID')!='' ){
			//	$userCity=$cookie->get('spoudazoCityID');
			//}else{
			//	$userCity=$this->getUserSelectedCity($userID);
			//}
			//
			//$city=self::getCity($userCity);
			
			//if($city && $city['woeid']>'0'){
				

			
			//var_dump($params);
			//$params['fullcity']=$city['name'];
			//$params['WOEID']=$city['woeid'];
			//$mod_weather->params=json_encode($params);
			//}
			
		}
		
		//private function getCity($cityID)
		//{
		//	$db = JFactory::getDBO();
		//	
		//	$query="SELECT id,name,plugins FROM #__k2_categories WHERE `plugins` LIKE '%\"citySelectisCity\":\"1\"%' ";
		//	
		//	if($cityID){
		//		$query .= " AND id=$cityID";
		//	}
		//	
		//	$db->setQuery($query);
		//	$results = $db->loadObjectList();
		//	
		//	if(count($results) == 1){
		//		$plugins=json_decode($results[0]->plugins);
		//		$city['id']=$results[0]->id;
		//		$city['name']=$results[0]->name;
		//		$city['woeid']=$plugins->citySelectwoeid;
		//		
		//		return $city;
		//	}
		//	
		//	return false;
		//}
		
		//private function getUserSelectedCity($userID)
		//{
		//
		//	$app = JFactory::getApplication();
		//	
		//	$db = JFactory::getDBO();
		//	$query = "SELECT plugins FROM #__k2_users WHERE userID = ".$userID;
		//	$db->setQuery($query);
		//	$row = $db->loadObject();
		//	if (!$row)
		//	{
		//		$row = JTable::getInstance('K2User', 'Table');
		//	}
		//	
		//	try{
		//		$plugins=json_decode($row->plugins);
		//	}catch(  Exception $ex){
		//		
		//	}
		//	
		//	if(isset($plugins->citySelectcity)){
		//		return $plugins->citySelectcity;
		//	}
		//	return false;
		//}
		
    }
}