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
if (!class_exists('plgSystemSpoudazoeventstags')) {
	
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

			//Get the current menu by Itemid
			$Itemid = $app->input->get('Itemid','0','int');
			$menu =  $app->getMenu()->getItem($Itemid);
			
			//Filter tag item result by category. This is needed becasue otherwise, it shows items from ALL K2!!!!!
			if( $menu -> menutype == 'events' )
			{
				$categories = $menu->params -> get ('categories');
				$params ['cloud_category'] = $categories;
			}
			
			$mod_k2_tools->params=json_encode($params);
			
		}
    }
}