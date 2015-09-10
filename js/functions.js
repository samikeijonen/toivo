
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
		var navMain = responsiveNav(".main-navigation", {     // Selector
			transition: 350,                                  // Integer: Speed of the transition, in milliseconds
			customToggle: "#nav-toggle",                      // Selector: Specify the ID of a custom toggle
			enableFocus: true,                                // Boolean: Do we use use 'focus' class in our nav
			enableDropdown: navSettings.dropdown,             // Boolean: Do we use multi level dropdown
			dropDown: "menu-item-has-children",               // String: Class that is added to link element that have sub menu
			openDropdown: navSettings.expand,                 // String: Label for opening sub menu
			closeDropdown: navSettings.collapse,              // String: Label for closing sub menu
			init: function () {                               // Set ARIA for menu toggle button
				buttonMain.setAttribute( 'aria-expanded', 'false' );
				buttonMain.setAttribute( 'aria-pressed', 'false' );
				buttonMain.setAttribute( 'aria-controls', 'menu-primary' );
			},
			open: function () {
				buttonMain.setAttribute( 'aria-expanded', 'true' );
				buttonMain.setAttribute( 'aria-pressed', 'true' );
			},
			close: function () {
				buttonMain.setAttribute( 'aria-expanded', 'false' );
				buttonMain.setAttribute( 'aria-pressed', 'false' );
			},
		});
		
	}
	
	if ( containerTop ) {

		var buttonTop = document.getElementById( 'top-nav-toggle' );
		var navTop = responsiveNav(".top-navigation", { // Selector
			transition: 350,                 // Integer: Speed of the transition, in milliseconds
			customToggle: "#top-nav-toggle", // Selector: Specify the ID of a custom toggle
			enableFocus: true,               // Boolean: Do we use use 'focus' class in our nav
			init: function () {              // Set ARIA for menu toggle button
				buttonTop.setAttribute( 'aria-expanded', 'false' );
				buttonTop.setAttribute( 'aria-pressed', 'false' );
				buttonTop.setAttribute( 'aria-controls', 'menu-top' );
			},
			open: function () {
				buttonTop.setAttribute( 'aria-expanded', 'true' );
				buttonTop.setAttribute( 'aria-pressed', 'true' );
				navSocial.close();
			},
			close: function () {
				buttonTop.setAttribute( 'aria-expanded', 'false' );
				buttonTop.setAttribute( 'aria-pressed', 'false' );
			},
		});
		
	}
	
	if ( containerSocial ) {

		var buttonSocial = document.getElementById( 'social-nav-toggle' );
		var navSocial = responsiveNav(".social-navigation", { // Selector
			transition: 350,                    // Integer: Speed of the transition, in milliseconds
			customToggle: "#social-nav-toggle", // Selector: Specify the ID of a custom toggle
			init: function () {                 // Set ARIA for menu toggle button
				buttonSocial.setAttribute( 'aria-expanded', 'false' );
				buttonSocial.setAttribute( 'aria-pressed', 'false' );
				buttonSocial.setAttribute( 'aria-controls', 'menu-social' );
			},
			open: function () {
				buttonSocial.setAttribute( 'aria-expanded', 'true' );
				buttonSocial.setAttribute( 'aria-pressed', 'true' );
				navTop.close();
			},
			close: function () {
				buttonSocial.setAttribute( 'aria-expanded', 'false' );
				buttonSocial.setAttribute( 'aria-pressed', 'false' );
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
