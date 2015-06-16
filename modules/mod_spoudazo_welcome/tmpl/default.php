<?php

defined('_JEXEC') or die;
$app = JFactory::getApplication();
$menu = $app->getMenu();
$menuID=$menu->getItems(array('link'),array('index.php?option=com_socialconnect&view=login'),true)->id;
$user = JFactory::getUser();
$isGuest = $user->get('guest');
?>

<div class="spoudazo-welcome">
    <div class="spoudazo-message">
    	<div class="spoudazo-hello">
	        <?php echo JText::_('MOD_SPOUDAZO_WELCOME_MESSAGE') .' '.$userName;?>
        </div>
        <div>
	        <?php echo ($cityName!='')?$cityName:'<a href="#spoudazo_popup" class="modal" id="spoudazo-popup-link">'.JText::_('MOD_SPOUDAZO_WELCOME_SELECT_CITY').'</a>'; ?>
        </div>
    </div>	
	<a class="spoudazo-login" href="<?php echo JRoute::_('index.php?option=com_socialconnect&view=login&tmpl=blankpage&Itemid='.$menuID.'&returnURL='.base64_encode(JFactory::getURI()->toString()));?>">
    	<i class="fa fa-2x fa-<?php echo ($isGuest)?'sign-in':'sign-out'; ?>"></i>
		<span><?php echo ($isGuest)?JText::_('JLOGIN'):JText::_('JLOGOUT'); ?></span>
	</a>
    
</div>