<?php
/**
 * @version     1.6.x
 * @package     SocialConnect
 * @author      JoomlaWorks http://www.joomlaworks.net
 * @copyright   Copyright (c) 2006 - 2015 JoomlaWorks Ltd. All rights reserved.
 * @license     http://www.joomlaworks.net/license
 */

defined('_JEXEC') or die;
$app=JFactory::getApplication();
$jinput=$app->input;
$returnURL=$jinput->get('returnURL');
?>
<div id="comSocialConnectContainer">
    <div class="socialConnectNingSignInBlock socialConnectBlock">
        <h2 class="socialConnectHeading">
            <?php echo JText::_('JW_SC_CONNECT_WITH'); ?> <a href="http://<?php echo $this->params->get('ningCnameDomain'); ?>" target="_blank"><?php echo $this->params->get('ningNetworkName'); ?></a>
        </h2>            
        <?php if($this->params->get('ningPretext')): ?>
        <div class="socialConnectNingPretext"><?php echo $this->params->get('ningPretext'); ?></div>
        <?php endif; ?>
        <form action="<?php echo JRoute::_('index.php', true, $this->params->get('usesecure')); ?>" method="post">
          <div class="socialConnectRow">
            <label class="socialConnectLabel" for="socialConnectUsername"><?php echo JText::_('JW_SC_EMAIL_ADDRESS') ?></label>
            <input class="socialConnectInput" id="socialConnectUsername" type="text" name="username" />
        </div>
        <div class="socialConnectRow">
            <label class="socialConnectLabel" for="socialConnectPassword"><?php echo JText::_('JW_SC_PASSWORD') ?></label><br />
            <input class="socialConnectInput" id="socialConnectPassword" type="password" name="<?php echo $this->passwordFieldName; ?>" />
        </div>
        
        <?php if(JPluginHelper::isEnabled('system', 'remember')) : ?>
        <div class="socialConnectRememberBlock">
            <label class="socialConnectLabel" for="comSocialConnectRemember"><?php echo JText::_('JW_SC_REMEMBER_ME') ?></label>
            <input id="comSocialConnectRemember" type="checkbox" name="remember" value="yes" />
        </div>
        <?php endif; ?>
        <button class="socialConnectButton socialConnectSignInButton socialConnectClearFix" type="submit">
			<i></i>
			<span><?php echo JText::_('JW_SC_SIGN_IN') ?></span>
		</button>
        <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
        <input type="hidden" name="task" value="<?php echo $this->task; ?>" />
        <input type="hidden" name="return" value="<?php echo $returnURL; ?>" />
        <?php echo JHTML::_('form.token'); ?>
        </form>
        <?php if($this->params->get('ningPosttext')): ?>
        <div class="socialConnectNingPosttext"><?php echo $this->params->get('ningPosttext'); ?></div>
        <?php endif; ?>
    </div>
</div>