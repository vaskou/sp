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
if (!class_exists('plgSystemSpoudazocityguidetags')) {
	
    /**
     * Plugin entrypoint
     * @link http://docs.joomla.org/Plugin/Events/System
     */
    class plgSystemSpoudazocityguidetags extends JPlugin {
		
		var $_params;
		var $_pluginPath;

        /**
         * Construct method
         * @param type $subject
         * @param type $config
         */
        function plgSystemSpoudazocityguidetags(& $subject, $config) {
            parent::__construct($subject, $config);
			$this->_plugin = JPluginHelper::getPlugin( 'system', 'spoudazocityguidetags' );
			$this->_params = new JForm( $this->_plugin->params );
			$this->_pluginPath = JPATH_PLUGINS."/system/spoudazocityguidetags/";
        }

		public function onAfterRoute()
		{
			$app = JFactory::getApplication();
			
			//If not in frontend, do nothing
			if(!$app->isSite()){
				return;
			}
			
			//Get the current menu by Itemid
			$Itemid = $app->input->get('Itemid','0','int');
			$menu =  $app->getMenu()->getItem($Itemid);

			//Filter tag item result by category. This is needed becasue otherwise, it shows items from ALL K2!!!!!
			if( $menu -> menutype == 'cityguide' ){
				$categories = $menu->params -> get ('categories');
				$app->getParams('com_k2')->set('categoriesFilter',$categories);
				
				//var_dump( $app->getParams('com_k2')->get('categoriesFilter') ); die;
			}
			
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
			$mod_k2_tools=JModuleHelper::getModule('mod_k2_tools','City Guide Tags');
			
			
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
			if( $menu -> menutype == 'cityguide' )
			{
				$categories = $menu->params -> get ('categories');
				$params ['cloud_category'] = $categories;
			}
			
			$mod_k2_tools->params=json_encode($params);
			
		}
    }
}