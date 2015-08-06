<?php

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');

JHtml::stylesheet(JURI::base().'modules/mod_spoudazo_popup/assets/css/style.css');
JHtml::script(JURI::base().'modules/mod_spoudazo_popup/assets/js/form_script.js');

?>

<?php 
if(!$city){ ?>

<div class="spoudazo_popup_newsletter">
	
    <form action="<?php echo JRoute::_('index.php'); ?>" method="post" id="select-city-form" class="form-inline form-validate" >
    	<h3 class="sp-popup-newsletter-title"><?php echo JText::_('MOD_SPOUDAZO_POPUP_NEWSLETTER_TITLE');?></h3>
        <div class="sp-city">
            <select id="city" name="cityID" required="required">
                <?php foreach($cities as $city){?>
                    <option value="<?php echo $city->id;?>" ><?php echo JText::_(htmlspecialchars($city->name)); ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="sp-email">
            <input type="email" required="required" class="validate-email" id="email" name="email" placeholder="E-mail" />
        </div>
        <div class="sp-popup-button">
            <button type="submit" class="validate button"><?php echo JText::_('MOD_SPOUDAZO_POPUP_SUBMIT'); ?></button>
        </div>
        
        
        <input type="hidden" name="option" value="com_spoudazo" />
        <input type="hidden" name="task" value="spoudazo.addSubscriber" />
        <input type="hidden" name="return_url" value="<?php echo base64_encode(JFactory::getURI()->toString()); ?>" />
        <input type="hidden" name="redirect" value="true" />
    </form>
    
</div>

<?php 
}else{?>

<div class="spoudazo_popup_newsletter">
	<?php $username = ($username)?$username:JText::_('MOD_SPOUDAZO_POPUP_NEWSLETTER_VISITOR'); ?>
	<h3 class="sp-popup-newsletter-title"><?php echo JText::sprintf('MOD_SPOUDAZO_POPUP_NEWSLETTER_WELCOME_MESSAGE',$username,$city['name']); ?></h3>
</div>

<?php 
}?>