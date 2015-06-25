<?php

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');

JHtml::stylesheet(JURI::base().'modules/mod_spoudazo_popup/assets/css/style.css');
?>

<div style="display:none;"> 
    <div id="spoudazo_popup">
    	<div class="spoudazo_wrapper">
            <div class="spoudazo_popup_step_1">
            	<h1><?php echo JText::_('MOD_SPOUDAZO_POPUP_TITLE');?></h1>
                <img src="http://spoudazo.yes-internet.gr/images/logo/logo.png" alt="SpoudaZO.gr">
                <div class="sp-popup-subtitle"><?php echo JText::_('MOD_SPOUDAZO_POPUP_SUBTITLE');?></div>
                <form action="<?php echo JRoute::_('index.php'); ?>" method="post" id="select-city-form" class="form-inline form-validate" onsubmit="fn_spoudazo_submit_form(this);">
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
                    <input type="hidden" name="option" value="com_spoudazo" />
                    <input type="hidden" name="task" value="spoudazo.addSubscriber" />
                    <input type="hidden" name="return_url" value="<?php echo JRoute::_(JUri::getInstance()->toString()); ?>" />
                    <div class="sp-popup-button">
                        <button type="submit" class="validate button"><?php echo JText::_('MOD_SPOUDAZO_POPUP_SUBMIT'); ?></button>
                    </div>
                </form>
                <div class="sp-eula"><?php echo JText::_('MOD_SPOUDAZO_POPUP_EULA'); ?></div>
                <div class="sp-signin-register">
                	<div>
                    	<?php echo JText::_('MOD_SPOUDAZO_POPUP_ALREADY_ACCOUNT'); ?>
                    	<a href="<?php echo JRoute::_('index.php?option=com_users&view=login');?>" ><?php echo JText::_('MOD_SPOUDAZO_POPUP_LOGIN'); ?></a>
                    </div>
                    <div>
	                    <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration');?>" ><?php echo JText::_('MOD_SPOUDAZO_POPUP_BECOME_MEMBER'); ?></a>
						<?php echo JText::_('MOD_SPOUDAZO_POPUP_BECOME_MEMBER_OF'); ?>
                    </div>
                </div>
                <div>
                    <a href="#" id="spoudazo_not_again" onclick="fn_dont_show_again();"><?php echo JText::_('MOD_SPOUDAZO_POPUP_DO_NOT_SHOW_AGAIN');?></a>
                </div>
            </div>
            <div class="spoudazo_popup_step_2" style="display:none;">
                <h1><?php echo JText::_('MOD_SPOUDAZO_POPUP_CONGRATULATIONS');?></h1>
                <div class="">
                	<div class="sp-popup-left">
                    	<h4><?php echo JText::_('MOD_SPOUDAZO_POPUP_BECOME_MEMBER_2'); ?></h4>
                        <div class="sp-popup-bullets">
                        	<?php if($params->get('bullets_icon')){ echo '<i class="fa '.$params->get('bullets_icon').'"></i>';} ?>
							<?php echo $params->get('bullet1'); ?>
                        </div>
                        <div class="sp-popup-bullets">
                        	<?php if($params->get('bullets_icon')){ echo '<i class="fa '.$params->get('bullets_icon').'"></i>';} ?>
							<?php echo $params->get('bullet2'); ?>
                        </div>
                        <div class="sp-popup-bullets">
                        	<?php if($params->get('bullets_icon')){ echo '<i class="fa '.$params->get('bullets_icon').'"></i>';} ?>
							<?php echo $params->get('bullet3'); ?>
                        </div>
                        <div class="sp-popup-bullets">
                        	<?php if($params->get('bullets_icon')){ echo '<i class="fa '.$params->get('bullets_icon').'"></i>';} ?>
							<?php echo $params->get('bullet4'); ?>
                        </div>
                        <div class="sp-popup-button">
	                        <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration');?>" class="button"><?php echo JText::_('MOD_SPOUDAZO_POPUP_BECOME_MEMBER_NOW'); ?></a>
                        </div>
                    </div>
                    <div class="sp-popup-right">
                    	<img src="http://static7.depositphotos.com/1278120/774/i/950/depositphotos_7741977-Couple-of-students-smiling.jpg" />
                    </div>
                </div>
                <div class="sp-signin-register">
	                <a href="<?php echo JURI::getInstance()->toString(); ?>" ><?php echo JText::_('MOD_SPOUDAZO_POPUP_CONTINUE');?></a>
                </div>
            </div>
    	</div>
    </div>
</div>

<script>

function fn_spoudazo_submit_form(el)
{
	event.preventDefault();
	var form = jQuery(el),
		formData = form.serialize(),
		formMethod = form.attr("method");
	jQuery.ajax({
		type: formMethod,
		data: formData,
		timeout:10000,
		success:function(response){
			try{
				response=jQuery.parseJSON(response);
				console.log(response);
				if(response.success){
					fn_display_step_2();
				}
			}catch(e){
				//console.log(e);
			}
		}
	});
}

function fn_display_step_2()
{
	jQuery(".spoudazo_popup_step_1").slideToggle(500);
	jQuery(".spoudazo_popup_step_2").slideToggle(500);
}

function fn_dont_show_again()
{
	jQuery.ajax({
		url: '<?php echo JRoute::_('index.php?option=com_spoudazo&task=spoudazo.setCookie'); ?>',
		success: function(response){
			SqueezeBox.close();
		}
	});
}

</script>