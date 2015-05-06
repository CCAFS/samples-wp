// toggle open and closed the search function in the nav bar
jQuery( document ).ready(function() {
    jQuery( ".nav-trigger" ).click(function() {
	  jQuery("#nav-search").fadeToggle( 100, "linear" );
	});
});