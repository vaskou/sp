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
if (!class_exists('plgSystemSpoudazocalendaricagenda')) {
	
    /**
     * Plugin entrypoint
     * @link http://docs.joomla.org/Plugin/Events/System
     */
    class plgSystemSpoudazocalendaricagenda extends JPlugin {
		
		var $_params;
		var $_pluginPath;

        /**
         * Construct method
         * @param type $subject
         * @param type $config
         */
        function plgSystemSpoudazocalendaricagenda(& $subject, $config)
		{
		    parent::__construct($subject, $config);
			$this->_plugin = JPluginHelper::getPlugin( 'system', 'spoudazocalendaricagenda' );
			$this->_params = new JForm( $this->_plugin->params );
			$this->_pluginPath = JPATH_PLUGINS."/system/spoudazocalendaricagenda/";
        }
		
		public function onAfterRoute()
		{
			//$app = JFactory::getApplication();
			
			//If not in frontend, do nothing
			//if(!$app->isSite()){
			//	return;
			//}
			
			//Get the current menu by Itemid
			//$Itemid = $app->input->get('Itemid','0','int');
			//$menu =  $app->getMenu()->getItem($Itemid);

			//Filter tag item result by category. This is needed becasue otherwise, it shows items from ALL K2!!!!!
			//if( $menu -> menutype == 'events' ){
				
				
				//$categories = $menu->params -> get ('mcatid');
				//$app->getParams('com_k2')->set('categoriesFilter',$categories);
			//}
			
		}
		
		public function onAfterDispatch()
		{
			$app = JFactory::getApplication();

			//If not in forntend, return
			if(!$app->isSite()){
				return;
			}
	
			//Get k2 Tools module params
			$mod_iccalendar=JModuleHelper::getModule('mod_iccalendar','Ημερολόγιο Events');
			$params=json_decode($mod_iccalendar->params,true);

			//Get the current menu by Itemid
			$Itemid = $app->input->get('Itemid','0','int');
			$menu =  $app->getMenu()->getItem($Itemid);

			//Filter tag item result by category. This is needed becasue otherwise, it shows items from ALL K2!!!!!
			if( $menu -> menutype == 'events' ){
				$categories = $menu->params -> get ('mcatid');
				$params ['mcatid'] = $categories;
			}
			
			$mod_iccalendar->params=json_encode($params);
		
		}
		
    }
}