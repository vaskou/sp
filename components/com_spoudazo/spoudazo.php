<?php

defined('_JEXEC') or die;

$app = JFactory::getApplication();

$jinput = $app->input;

$option=$jinput->getArray();

$cityID=$jinput->get('cityID','');
$return_url=$jinput->get('return_url','','RAW');
$notAgain=$jinput->get('notAgain','false');

$cookie=$app->input->cookie;

$cookie->set('spoudazoCookie','true',time() + (10*365*24*60*60),'/' );
$cookie->set('spoudazoCityID',$cityID,time() + (10*365*24*60*60),'/' );

//$app->redirect(JRoute::_($return_url));

echo new JResponseJson( array('cityID'=>$cityID, 'return_url'=>$return_url) );

jexit();
