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
if (!class_exists('plgSystemSpoudazocategorylist')) {
	
    /**
     * Plugin entrypoint
     * @link http://docs.joomla.org/Plugin/Events/System
     */
    class plgSystemSpoudazocategorylist extends JPlugin {
		
		var $_params;
		var $_pluginPath;

        /**
         * Construct method
         * @param type $subject
         * @param type $config
         */
        function plgSystemSpoudazocategorylist(& $subject, $config) {
            parent::__construct($subject, $config);
			$this->_plugin = JPluginHelper::getPlugin( 'system', 'spoudazocategorylist' );
			$this->_params = new JForm( $this->_plugin->params );
			$this->_pluginPath = JPATH_PLUGINS."/system/spoudazocategorylist/";
        }
		
		public function onAfterDispatch()
		{
			$app = JFactory::getApplication();

			//If not in forntend, return
			if(!$app->isSite()){
				return;
			}
			
			$Itemid = $app->input->get('Itemid','0','int');
			$menu =  $app->getMenu()->getItem($Itemid);
			
			
			//Get k2 Tools module params
			$mod_k2_tools=JModuleHelper::getModule('mod_k2_tools','Business categories list');
			
			$params=json_decode($mod_k2_tools->params,true);

			//If not calendar mode, reutrn. module_usage=4 for categories list mode
			if( $params ['module_usage'] =='4')
			{
				//Get the current menu by Itemid
				
				
			
				//Filter tag item result by category. This is needed becasue otherwise, it shows items from ALL K2!!!!!
				if( $menu -> menutype == 'businesses' )
				{
					$categories = $menu->params -> get ('categories');
					$category = $categories[0];

					if($category){
						
						$params ['root_id'] = $category;
						
						if( $category != $app->input->get('id','','string') ){
									
							$mod_k2_tools ->position='';
						}

					}
				}
			
				$mod_k2_tools->params=json_encode($params);
			}

			
			//Get k2 Tools module params
			$mod_k2_tools=JModuleHelper::getModule('mod_k2_tools','City Guide categories list');
			$params=json_decode($mod_k2_tools->params,true);
			
			//If not calendar mode, reutrn. module_usage=4 for categories list mode
			if( $params ['module_usage'] =='4')
			{
				//Filter tag item result by category. This is needed becasue otherwise, it shows items from ALL K2!!!!!
				if( $menu -> menutype == 'cityguide' )
				{
					
					$categories = $menu->params -> get ('categories');
					$category = $categories[0];

					if($category){
						
						$params ['root_id'] = $category;
						
						if( $category != $app->input->get('id','','string') ){
									
							$mod_k2_tools ->position='';
						}
					}
				}
			
				$mod_k2_tools->params=json_encode($params);
				
				
			}		

			
		}
    }
}