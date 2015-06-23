<?php

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');

JHtml::stylesheet(JURI::base().'modules/mod_spoudazo_popup/assets/css/style.css');
?>

<div style="display:none;"> 
    <div id="spoudazo_popup">
    	<div class="spoudazo_wrapper">
            <h1><?php echo JText::_('MOD_SPOUDAZO_POPUP_TITLE');?></h1>
            <div class="spoudazo_popup_step_1">
                <form action="<?php echo JRoute::_('index.php'); ?>" method="post" id="select-city-form" class="form-inline form-validate" onsubmit="fn_spoudazo_submit_form(this);">
                    <div>
                        <input type="email" required="required" class="validate-email" id="email" name="email" placeholder="E-mail" />
                    </div>
                    <div>
                        <select id="city" name="cityID" required="required">
                            <?php foreach($cities as $city){?>
                                <option value="<?php echo $city->id;?>" ><?php echo JText::_(htmlspecialchars($city->name)); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <input type="hidden" name="option" value="com_spoudazo" />
                    <input type="hidden" name="task" value="spoudazo.addSubscriber" />
                    <input type="hidden" name="return_url" value="<?php echo JRoute::_(JUri::getInstance()->toString()); ?>" />
                    <div>
                        <button type="submit" class="validate"><?php echo JText::_('JSUBMIT'); ?></button>
                    </div>
                </form>
                <div>
                    <a href="<?php echo JRoute::_('index.php?option=com_users&view=login');?>" ><?php echo JText::_('JLOGIN'); ?></a>
                    <?php echo JText::_('MOD_SPOUDAZO_POPUP_OR'); ?>
                    <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration');?>" ><?php echo JText::_('JREGISTER'); ?></a>
                </div>
                <div>
                    <a href="#" id="spoudazo_not_again" onclick="fn_dont_show_again();"><?php echo JText::_('MOD_SPOUDAZO_POPUP_DO_NOT_SHOW_AGAIN');?></a>
                </div>
            </div>
            <div class="spoudazo_popup_step_2" style="display:none;">
                <h3><?php echo JText::_('MOD_SPOUDAZO_POPUP_CONGRATULATIONS');?></h3>
                <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration');?>" ><?php echo JText::_('MOD_SPOUDAZO_POPUP_REGISTER'); ?></a><br />
                <?php echo JText::_('MOD_SPOUDAZO_POPUP_OR'); ?><br />
                <a href="<?php echo JURI::getInstance()->toString(); ?>" ><?php echo JText::_('MOD_SPOUDAZO_POPUP_CONTINUE');?></a>
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