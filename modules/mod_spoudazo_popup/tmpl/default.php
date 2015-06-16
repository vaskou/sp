<?php

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');

?>

<div class="spoudazo_wrapper" style="display:none;">
	<div id="spoudazo_popup">
		<h1><?php echo JText::_('MOD_SPOUDAZO_POPUP_TITLE');?></h1>
        <div class="spoudazo_popup_step_1">
            <form action="<?php echo JRoute::_('index.php'); ?>" method="post" id="select-city-form" class="form-inline form-validate" onsubmit="fn_spoudazo_submit_form(this);">
                <select name="cityID" required="required">
                    <?php foreach($cities as $city){?>
                        <option value="<?php echo $city->id;?>" ><?php echo htmlspecialchars($city->name); ?></option>
                    <?php } ?>
                </select>
                <input type="email" required="required" class="validate-email" id="email" city="email" placeholder="E-mail" />
                <input type="hidden" name="option" value="com_spoudazo" />
                <input type="hidden" name="return_url" value="<?php echo JRoute::_(JUri::getInstance()->toString()); ?>" />
                <button type="submit" class="validate"><?php echo JText::_('JSUBMIT'); ?></button>
            </form>
            <a href="<?php echo JRoute::_('index.php?option=com_users&view=login');?>" ><?php echo JText::_('JLOGIN'); ?></a><br/>
            <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration');?>" ><?php echo JText::_('JREGISTER'); ?></a><br/>
            <a href="#" id="spoudazo_not_again" onclick="fn_dont_show_again();"><?php echo JText::_('MOD_SPOUDAZO_POPUP_DO_NOT_SHOW_AGAIN');?></a>
        </div>
        <div class="spoudazo_popup_step_2" style="display:none;">
        	<h3><?php echo JText::_('MOD_SPOUDAZO_POPUP_CONGRATULATIONS');?></h3>
        	<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration');?>" ><?php echo JText::_('JREGISTER'); ?></a>
            <a href="#" onclick="SqueezeBox.close($('spoudazo_popup'));"><?php echo JText::_('MOD_SPOUDAZO_POPUP_CONTINUE');?></a>
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
		url: '<?php echo JRoute::_('index.php?option=com_spoudazo'); ?>',
		success: function(response){
			SqueezeBox.close();
		}
	});
}

</script>