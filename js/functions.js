
/**
 * Enable tab support for dropdown menus.
 */
( function() {
	var container, containerTop, ContainerSocial, menuTop;
	
	// Primary menu
	container = document.getElementById( 'menu-primary' );
	
	// Top menu
	containerTop = document.getElementById( 'menu-top' );
	
	// Social menu
	containerSocial = document.getElementById( 'menu-social' );

	/**
	 * Make dropdown menus keyboard accessible.
	 */
	 
	if ( container ) {
		
		var buttonMain = document.getElementById( 'nav-toggle' );
		var navMain = responsiveNav(".main-navigation", {                   // Selector
			transition: 350,                                                // Integer: Speed of the transition, in milliseconds
			customToggle: "#nav-toggle",                                    // Selector: Specify the ID of a custom toggle
			enableFocus: true,                                              // Boolean: Do we use use 'focus' class in our nav
			enableDropdown: navSettings.dropdown,                           // Boolean: Do we use multi level dropdown
			openDropdown: navSettings.expand,                               // String: Label for opening sub menu
			closeDropdown: navSettings.collapse,                            // String: Label for closing sub menu
			resizeMobile: function () {                                     // Set ARIA for menu toggle button
				buttonMain.setAttribute( 'aria-controls', 'menu-primary' );
			},
			resizeDesktop: function () {                                    // Remove ARIA from menu toggle button
				buttonMain.removeAttribute( 'aria-controls' );
			},
		});
		
	}
	
	if ( containerTop ) {

		var buttonTop = document.getElementById( 'top-nav-toggle' );
		var navTop = responsiveNav(".top-navigation", { // Selector
			transition: 350,                                           // Integer: Speed of the transition, in milliseconds
			customToggle: "#top-nav-toggle",                           // Selector: Specify the ID of a custom toggle
			enableFocus: true,                                         // Boolean: Do we use use 'focus' class in our nav
			resizeMobile: function () {                                // Set ARIA for menu toggle button
				buttonTop.setAttribute( 'aria-controls', 'menu-top' );
			},
			resizeDesktop: function () {                               // Remove ARIA from menu toggle button
				buttonTop.removeAttribute( 'aria-controls' );
			},
			open: function () {
				navSocial.close();
			},
		});
		
	}
	
	if ( containerSocial ) {

		var buttonSocial = document.getElementById( 'social-nav-toggle' );
		var navSocial = responsiveNav(".social-navigation", { // Selector
			transition: 350,                                                 // Integer: Speed of the transition, in milliseconds
			customToggle: "#social-nav-toggle",                              // Selector: Specify the ID of a custom toggle
			resizeMobile: function () {                                      // Set ARIA for menu toggle button
				buttonSocial.setAttribute( 'aria-controls', 'menu-social' );
			},
			resizeDesktop: function () {                                     // Remove ARIA from menu toggle button
				buttonSocial.removeAttribute( 'aria-controls' );
			},
			open: function () {
				navTop.close();
			},
		});	
		
	}
	
	// Fix child menus for touch devices.
	function fixMenuTouchTaps( container ) {
		var touchStartFn,
		    parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		if ( 'ontouchstart' in window ) {
			touchStartFn = function( e ) {
				var menuItem = this.parentNode;

				if ( ! menuItem.classList.contains( 'focus' ) ) {
					e.preventDefault();
					for( var i = 0; i < menuItem.parentNode.children.length; ++i ) {
						if ( menuItem === menuItem.parentNode.children[i] ) {
							continue;
						}
						menuItem.parentNode.children[i].classList.remove( 'focus' );
					}
					menuItem.classList.add( 'focus' );
				} else {
					menuItem.classList.remove( 'focus' );
				}
			};

			for ( var i = 0; i < parentLink.length; ++i ) {
				parentLink[i].addEventListener( 'touchstart', touchStartFn, false )
			}
		}
	}
	
	if ( container ) {
		fixMenuTouchTaps( container );
	}
	
} )();

/**
 * Skip link focus fix.
 */
( function() {
	var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	    is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
	    is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( is_webkit || is_opera || is_ie ) && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var element = document.getElementById( location.hash.substring( 1 ) );

			if ( element ) {
				if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) )
					element.tabIndex = -1;

				element.focus();
			}
		}, false );
	}
})();
