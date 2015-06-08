//
jQuery.noConflict();

jQuery(document).ready(function() {

    //Move Item Gallery after extra fields 
    jQuery(".sigFreeContainer").detach().insertAfter('.itemExtraFields');
    
});

jQuery(window).scroll(function() {
        jQuery('#gkLogoSmall>img').attr('src','images/logo/logo-fixedMenu.png');

});
