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

function fn_dont_show_again(task_url)
{
	jQuery.ajax({
		url: task_url,
		success: function(response){
			SqueezeBox.close();
		}
	});
}