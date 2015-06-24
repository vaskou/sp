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
			
			if( $user->get('guest') && $cookie->get('spoudazoCityID')!='' )
			{
				$userCity=$cookie->get('spoudazoCityID');
			}else
			{
				$userCity=SpoudazoLibrary::getUserSelectedCity($userID);
			}
			
			$city=SpoudazoLibrary::getCity($userCity);
			
			if($city && $city['woeid']>'0')
			{
				$mod_weather=JModuleHelper::getModule('mod_weather_gk4');
				$params=json_decode($mod_weather->params,true);
				$params['fullcity']=$city['name'];
				$params['WOEID']=$city['woeid'];
				$mod_weather->params=json_encode($params);
			}
			
		}
		
    }
}