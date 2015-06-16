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
    class plgSystemspoudazoweather extends JPlugin {
		
		var $_params;
		var $_pluginPath;

        /**
         * Construct method
         * @param type $subject
         * @param type $config
         */
        function plgSystemspoudazoweather(& $subject, $config) {
            parent::__construct($subject, $config);
			$this->_plugin = JPluginHelper::getPlugin( 'system', 'spoudazoweather' );
			$this->_params = new JForm( $this->_plugin->params );
			$this->_pluginPath = JPATH_PLUGINS."/system/spoudazoweather/";
        }
		
		public function onAfterDispatch()
		{
			$app = JFactory::getApplication();
			$cookie=$app->input->cookie;
			
			if(!$app->isSite()){
				return;
			}
			
			$user = JFactory::getUser();
			$userID=$user->id;
			
			if( $user->get('guest') && $cookie->get('spoudazoCityID')!='' ){
				$userCity=$cookie->get('spoudazoCityID');
			}else{
				$userCity=$this->getUserSelectedCity($userID);
			}
			
			$city=self::getCity($userCity);
			
			if($city && $city['woeid']>'0'){
				$mod_weather=JModuleHelper::getModule('mod_weather_gk4');
				$params=json_decode($mod_weather->params,true);
				$params['fullcity']=$city['name'];
				$params['WOEID']=$city['woeid'];
				$mod_weather->params=json_encode($params);
			}
			
		}
		
		private function getCity($cityID)
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
				
				return $city;
			}
			
			return false;
		}
		
		private function getUserSelectedCity($userID)
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
		
    }
}