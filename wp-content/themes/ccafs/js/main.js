// toggle open and closed the search function in the nav bar
jQuery( document ).ready(function() {
    /* open and close the nav search box */
    jQuery( ".nav-trigger" ).click(function() {
	  jQuery("#nav-search").fadeToggle( 100, "linear" );
	});
	
	/* open and close Show More links */
	jQuery('.show-hide-trigger').click(function(){
        jQuery('.show-hide-wrapper').fadeToggle(300, function() {
            jQuery('.show-hide-trigger').text(function(i, v){
               return v === 'Close' ? 'Show More' : 'Close'
            });
        });
    });

    /* open and close Show More links */
	jQuery('.mm-caret').click(function(){
        jQuery(this).next('.mm-subnav').fadeToggle(200);
        jQuery(this).toggleClass('open');
    });
});

