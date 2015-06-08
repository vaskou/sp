//
jQuery.noConflict();

jQuery(document).ready(function() {

//Move Item Gallery after extra fields 

jQuery(".sigFreeContainer").detach().insertAfter('.itemExtraFields');
});