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
if (!class_exists('plgSystemSpoudazoicagendarss')) {
	
    /**
     * Plugin entrypoint
     * @link http://docs.joomla.org/Plugin/Events/System
     */
    class plgSystemSpoudazoicagendarss extends JPlugin {
		
		var $_params;
		var $_pluginPath;

        /**
         * Construct method
         * @param type $subject
         * @param type $config
         */
        function plgSystemSpoudazoicagendarss(& $subject, $config)
		{
		    parent::__construct($subject, $config);
			$this->_plugin = JPluginHelper::getPlugin( 'system', 'spoudazoicagendarss' );
			$this->_params = new JForm( $this->_plugin->params );
			$this->_pluginPath = JPATH_PLUGINS."/system/spoudazoicagendarss/";
        }
		
		public function onAfterDispatch()
		{
			$app = JFactory::getApplication();

			//If not in forntend, return
			if(!$app->isSite()){
				return;
			}
	
			$mod_icagendarss=JModuleHelper::getModule('mod_news_pro_gk5','ICagenda RSS');

			$app = JFactory::getApplication();

			$selectedCity = $app->input->cookie->get('spoudazoCityID');
			
			$Itemid=null;
			
			if ($selectedCity !='' ){
				
				$menu =  $app->getMenu();
				$menuEvents = $menu->getItems('menutype', 'events');
				
				foreach($menuEvents as $key => $menuitem) {
				
					if($selectedCity == $menuitem->params->get('k2_city_id'))
					{
						
						$Itemid = $menuitem->id;
						
						break;
					}

				}
						
				
			}
			


			$params=json_decode($mod_icagendarss->params,true);

			$params['rss_feed']=JURI::base().'index.php?option=com_icagenda&view=list&format=feed';
			if($Itemid){
				$params['rss_feed'].='&Itemid='.$Itemid;
			}

			$mod_icagendarss->params=json_encode($params);
		
		}
		
    }
}