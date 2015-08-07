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
if (!class_exists('plgSystemSpoudazonewstags')) {
	
    /**
     * Plugin entrypoint
     * @link http://docs.joomla.org/Plugin/Events/System
     */
    class plgSystemSpoudazonewstags extends JPlugin {
		
		var $_params;
		var $_pluginPath;

        /**
         * Construct method
         * @param type $subject
         * @param type $config
         */
        function plgSystemSpoudazoeventstags(& $subject, $config) {
            parent::__construct($subject, $config);
			$this->_plugin = JPluginHelper::getPlugin( 'system', 'spoudazonewstags' );
			$this->_params = new JForm( $this->_plugin->params );
			$this->_pluginPath = JPATH_PLUGINS."/system/spoudazonewstags/";
        }
		
		public function onAfterDispatch()
		{
			$app = JFactory::getApplication();
			//$cookie=$app->input->cookie;

			//If not in forntend, return
			if(!$app->isSite()){
				return;
			}
	
			//Get k2 Tools News Tags module
			$mod_k2_tools_newstags=JModuleHelper::getModule('mod_k2_tools','News Tags');
			
			$params=json_decode($mod_k2_tools_newstags->params,true);
			
			if( $mod_k2_tools_newstags->id && $params ['module_usage'] =='7')
			{
			
				//Get the current menu by Itemid
				$Itemid = $app->input->get('Itemid','0','int');
				$menu =  $app->getMenu()->getItem($Itemid);
	
				//Filter tag item result by category. This is needed becasue otherwise, it shows items from ALL K2!!!!!
				if( $menu -> menutype == 'mainmenu' )
				{
					$categories = $menu->params -> get ('categories');
					$params ['cloud_category'] = $categories;
				}
				
				$mod_k2_tools_newstags->params=json_encode($params);
			}
			
			
			
			
			//Get k2 Tools News Tags module
			//Do not show if we are in tag list view

			if( $app->input->get('task','','string')=='tag' )
			{
				$modules=JModuleHelper::getModules('mainbody_top');
				foreach ($modules as $k => $module)
				{
					if( $module -> module =='mod_news_pro_gk5' )
					{
						$module -> position = '';	
					}
	
				}
			}


			
		}
		
		public function onAfterRoute()
		{
			//If we have Itemid of Homepage, change it to News itemid, becasue we are in tag list view
			$app = JFactory::getApplication();
			if( $app->input->get('task','','string')=='tag' )
			{
				//Check if we are in Homepage Itemid
				$Itemid = $app->input->get('Itemid','0','int');
				
				if($Itemid==435){
					$app->input->set('Itemid',991);
				}
				
			}
		}
    }
}