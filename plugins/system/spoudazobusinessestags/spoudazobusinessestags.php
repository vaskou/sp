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
if (!class_exists('plgSystemSpoudazobusinessestags')) {
	
    /**
     * Plugin entrypoint
     * @link http://docs.joomla.org/Plugin/Events/System
     */
    class plgSystemSpoudazobusinessestags extends JPlugin {
		
		var $_params;
		var $_pluginPath;

        /**
         * Construct method
         * @param type $subject
         * @param type $config
         */
        function plgSystemSpoudazoeventstags(& $subject, $config) {
            parent::__construct($subject, $config);
			$this->_plugin = JPluginHelper::getPlugin( 'system', 'spoudazobusinessestags' );
			$this->_params = new JForm( $this->_plugin->params );
			$this->_pluginPath = JPATH_PLUGINS."/system/spoudazobusinessestags/";
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
			if( $menu -> menutype == 'businesses' ){
				$categories = $menu->params -> get ('categories');

				$app->getParams('com_k2')->set('categoriesFilter',$this -> getCategoryTree ( $categories ) );
				
				//var_dump( $app->getParams('com_k2')->get('categoriesFilter') ); die;
			}
			
		}
		
		
		
		private	function getCategoryTree($categories, $associations = false)
	{
		$mainframe = JFactory::getApplication();
		$db = JFactory::getDBO();
		$user = JFactory::getUser();
		$aid = (int)$user->get('aid');
		if (!is_array($categories))
		{
			$categories = (array)$categories;
		}
		JArrayHelper::toInteger($categories);
		$categories = array_unique($categories);
		sort($categories);
		$key = implode('|', $categories);
		$clientID = $mainframe->getClientId();
		static $K2CategoryTreeInstances = array();
		if (isset($K2CategoryTreeInstances[$clientID]) && array_key_exists($key, $K2CategoryTreeInstances[$clientID]))
		{
			return $K2CategoryTreeInstances[$clientID][$key];
		}
		$array = $categories;
		while (count($array))
		{
			$query = "SELECT id
						FROM #__k2_categories 
						WHERE parent IN (".implode(',', $array).") 
						AND id NOT IN (".implode(',', $array).") ";
			if ($mainframe->isSite())
			{
				$query .= "
								AND published=1 
								AND trash=0";
				if (K2_JVERSION != '15')
				{
					$query .= " AND access IN(".implode(',', $user->getAuthorisedViewLevels()).")";
					if ($mainframe->getLanguageFilter())
					{
						$query .= " AND language IN(".$db->Quote(JFactory::getLanguage()->getTag()).", ".$db->Quote('*').")";
					}
				}
				else
				{
					$query .= " AND access<={$aid}";
				}
			}
			$db->setQuery($query);
			$array = K2_JVERSION == '30' ? $db->loadColumn() : $db->loadResultArray();
			$categories = array_merge($categories, $array);
		}
		JArrayHelper::toInteger($categories);
		$categories = array_unique($categories);
		$K2CategoryTreeInstances[$clientID][$key] = $categories;
		
	
		return $categories;
	}
		



    }
}