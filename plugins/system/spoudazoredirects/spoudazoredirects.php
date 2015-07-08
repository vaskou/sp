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
if (!class_exists('plgSystemspoudazoredirects')) {
	
    /**
     * Plugin entrypoint
     * @link http://docs.joomla.org/Plugin/Events/System
     */
    class plgSystemspoudazoredirects extends JPlugin {
		
		var $_params;
		var $_pluginPath;

        /**
         * Construct method
         * @param type $subject
         * @param type $config
         */
        function plgSystemspoudazoredirects(& $subject, $config) {
            parent::__construct($subject, $config);
			$this->_plugin = JPluginHelper::getPlugin( 'system', 'spoudazoredirects' );
			$this->_params = new JForm( $this->_plugin->params );
			$this->_pluginPath = JPATH_PLUGINS."/system/spoudazoredirects/";
        }
		
		function onContentPrepareForm($form, $data) {
			if ($form->getName()=='com_menus.item') {
				JForm::addFormPath($this->_pluginPath);
				$form->loadFile('parameters', false);
			}
		}

        /**
         * This event is triggered after the framework has loaded and the application initialise method has been called.
         */
        public function onAfterRoute() 
		{
			if (!class_exists('SpoudazoLibrary')) {return false;}
			$app = JFactory::getApplication();
			$jinput = $app->input;
			$cookie=$app->input->cookie;
			
			//Check if we are in frontend
			if(!$app->isSite()){
				return;
			}
			
			//Check if user is Root
			$user = JFactory::getUser();
			$userID=$user->id;
			$isRoot = $user->get('isRoot');
			
			if($jinput->get('option')=='com_spoudazo'){
				return;
			}
	
			$option = $jinput->get('option');
			$view = $jinput->get('view');
			$task = $jinput->get('task');
			$id = $jinput->get('id');
			
			if($option!='com_k2' || $view!='itemlist'){
				return;
			}
			
			if($option=='com_k2' && $task=='category'){
				return;
			}
			
			$menu = $app->getMenu();
			$menuItem = $menu->getItem( $jinput->get('Itemid'));
			
			if(!isset($menuItem)){
				return;
			}
			
			$menuRedirect=$menuItem->params->get('menuredirect');
			if(!isset($menuRedirect) || $menuRedirect==0){
				return;
			}
			
			$menuCategories=$menuItem->params->get('categories');
			
			if(!isset($menuCategories)){
				return;
			}
			
			if( $user->get('guest') && $cookie->get('spoudazoCityID')!='' ){
				$userCity=$cookie->get('spoudazoCityID');
			}else{
				$userCity=SpoudazoLibrary::getUserSelectedCity($userID);
			}
			
			foreach($menuCategories as $menuCategory){
				$category = JTable::getInstance('K2Category', 'Table');
				$category->load($menuCategory);
				if($category->parent==$userCity){
					$catID=$category->id;
					//$link=str_replace('&amp;', '&', urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($category->id.':'.urlencode($category->alias)))));
					$menu_redirected=$app->getMenu('site',array())->getItems(
						array('link','parent_id'),
						array('index.php?option=com_k2&view=itemlist&layout=category&task=category&id='.$category->id,$jinput->get('Itemid')),
						true
					);
					$new_Itemid=$menu_redirected->id;
					$link=str_replace('&amp;', '&', urldecode(JRoute::_('index.php?option=com_k2&view=itemlist&task=category&id='.$category->id.':'.urlencode($category->alias).'&Itemid='.$new_Itemid)));
				}
			}
			
			if(isset($catID) && $catID!=$id){
				$app->redirect($link);
			}else{
				return;
			}
			
        }
		
		
    }
}