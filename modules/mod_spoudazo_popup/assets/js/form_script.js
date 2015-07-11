function fn_spoudazo_submit_form(el,event)
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
	jQuery(".spoudazo_popup_step_1").slideToggle(1000);
	jQuery(".spoudazo_popup_step_2").slideToggle(1000);
	jQuery(".twt_btn").addClass('twitter-share-button');
	
	/*twitter button */
	twttr.widgets.load();
	
	/*facebook button*/
	(function(){
		if(document.id('fb-auth') == null) {
			var root = document.createElement('div');
			root.id = 'fb-root';
			$$('.itemFacebookButton')[0].appendChild(root);
				(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) {return;}
				js = d.createElement(s); js.id = id;
				js.src = document.location.protocol + "//connect.facebook.net/el_GR/all.js#xfbml=1";
				fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk')); 
			}
	}());
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

window.twttr = (function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0],
		t = window.twttr || {};
	if (d.getElementById(id)) return t;
	js = d.createElement(s);
	js.id = id;
	js.src = "https://platform.twitter.com/widgets.js";
	fjs.parentNode.insertBefore(js, fjs);
	
	t._e = [];
	t.ready = function(f) {
		t._e.push(f);
	};
	
	return t;
}(document, "script", "twitter-wjs"));