<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class SpoudazoController extends JControllerLegacy {

    public function display($cachable = false, $urlparams = false) {

        $view = JFactory::getApplication()->input->getCmd('view', '');
        JFactory::getApplication()->input->set('view', $view);

        parent::display($cachable, $urlparams);

        return $this;
    }

}
