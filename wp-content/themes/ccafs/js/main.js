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

    /* initialize the tooltip */
    jQuery(function () {
      jQuery('[data-toggle="tooltip"]').tooltip()
    });

    /* active class for about us subnav menu */
    jQuery(function() {
      var me=location.pathname;
      jQuery('.sidebar-box-list a[href^="' + me).addClass('active');
    });
});

/* smoothscroll 
https://css-tricks.com/snippets/jquery/smooth-scrolling/ 
*/

jQuery(function() {
  jQuery('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = jQuery(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        jQuery('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});