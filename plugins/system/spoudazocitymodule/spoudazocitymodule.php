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
			}
		}
		
		function onExtensionBeforeSave($context, $table, $isNew)
		{
			$app = JFactory::getApplication();
			$city_list['selectedcities']=$app->getUserState('com_spoudazo.city_list');
			var_dump($city_list);
			$params = json_decode($table->params, true);
			var_dump($params);
			$params = array_merge($params, $city_list);
			var_dump($params);
			$table->params = json_encode($params);
			$app->setUserState('com_spoudazo.city_list', array());
		}		
		
    }
}