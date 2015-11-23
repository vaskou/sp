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
if (!class_exists('plgSystemspoudazocitymodule')) {
	
    /**
     * Plugin entrypoint
     * @link http://docs.joomla.org/Plugin/Events/System
     */
    class plgSystemspoudazocitymodule extends JPlugin {
		
		var $_params;
		var $_pluginPath;

        /**
         * Construct method
         * @param type $subject
         * @param type $config
         */
        function plgSystemspoudazocitymodule(& $subject, $config) {
            parent::__construct($subject, $config);
			$this->_plugin = JPluginHelper::getPlugin( 'system', 'spoudazocitymodule' );
			$this->_params = new JForm( $this->_plugin->params );
			$this->_pluginPath = JPATH_PLUGINS."/system/spoudazocitymodule/";
        }
		
		function onContentPrepareForm($form, $data) {
			if ($form->getName()=='com_modules.module' && $data->module == 'mod_banners') {
				JForm::addFormPath($this->_pluginPath);
				$form->loadFile('parameters', false);

				$app = JFactory::getApplication();
				$app->setUserState('com_spoudazo.'.$data->id.'.city_list', $data->params['selectedcities']);
				$app->setUserState('com_spoudazo.'.$data->id.'.include_exclude', $data->params['include_exclude']);
			}
		}
		
		function onExtensionBeforeSave($context, $table, $isNew)
		{
			$app = JFactory::getApplication();
			
			$city_list['selectedcities']=$app->getUserState('com_spoudazo.'.$table->id.'.city_list');
			$params = json_decode($table->params, true);
			$params = array_merge($params, $city_list);

			$include_exclude = $app->getUserState('com_spoudazo.'.$table->id.'.include_exclude');
			$params['include_exclude'] = (!empty($include_exclude)) ? $include_exclude : 'disabled';

			$table->params = json_encode($params);
		}		
		
		public function onAfterDispatch()
		{
			$app = JFactory::getApplication();
			
			//If not in frontend, return
			if(!$app->isSite()){
				return;
			}
			
			//Get all modules
			$modules=JModuleHelper::getModuleList();

			//Loop through all modules
			foreach ( $modules as $k=> $module)
			{
				//Only for banner modules
				if ( $module->module == 'mod_banners' )
				{
					$banner_module = JModuleHelper::getModule('mod_banners',$module->title);
					$banner_module_params = json_decode ( $module->params, true );
					$banner_module_selectedcities = $banner_module_params['selectedcities'];
					$banner_module_include_exclude = $banner_module_params['include_exclude'];
					
					if($banner_module_include_exclude == 'disabled'){
						continue;
					}
					
					$selectedCity = ( !empty($app->input->cookie->get('spoudazoCityID')) ) ? $app->input->cookie->get('spoudazoCityID') : 'none';
					
					if ( empty($banner_module_selectedcities[$selectedCity]) && $banner_module_include_exclude == 'include')
					{
						$banner_module->position= '';
					}
					
					if ( !empty($banner_module_selectedcities[$selectedCity]) && $banner_module_include_exclude == 'exclude')
					{
						$banner_module->position= '';
					}
					
				}
			}
		}
    }
}