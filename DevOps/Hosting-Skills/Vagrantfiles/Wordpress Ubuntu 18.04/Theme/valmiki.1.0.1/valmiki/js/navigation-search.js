( function() {
	'use strict';

    if ( 'querySelector' in document && 'addEventListener' in window ) {
		/**
		 * Navigation search.
		 *
		 * @param e The event.
		 * @param _this The clicked item.
		 */
		var toggleSearch = function( e, item ) {
			e.preventDefault();

			if ( ! item ) {
				var item = this;
			}

			var nav = item.closest( 'nav' );

			if ( item.getAttribute( 'data-nav' ) ) {
				nav = document.querySelector( this.getAttribute( 'data-nav' ) );
			}

			var form = nav.querySelector( '.inside-navigation .search-form' );

			var focusableEls = document.querySelectorAll('a[href], area[href], input:not([disabled]):not(.inside-navigation .search-form), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), [tabindex="0"]');

			if ( form.classList.contains( 'nav-search-active' ) ) {
				item.classList.remove( 'close-search' );
				item.classList.remove( 'active' );
				document.activeElement.blur();
				item.classList.remove( 'sfHover' );
				form.classList.remove( 'nav-search-active' );
				item.style.float = '';

				// Allow tabindex on items again.
				for ( var i = 0; i < focusableEls.length; i++ ) {
					if ( ! focusableEls[i].closest( '.inside-navigation .search-form' ) && ! focusableEls[i].closest( '.search-item' ) ) {
						focusableEls[i].removeAttribute( 'tabindex' );
					}
				};
			} else {
				item.classList.add( 'active' );
				form.classList.add( 'nav-search-active' );
				form.querySelector( '.search-field' ).focus();

				// Trap tabindex within the search element
				for ( var i = 0; i < focusableEls.length; i++ ) {
					if ( ! focusableEls[i].closest( '.inside-navigation .search-form' ) && ! focusableEls[i].closest( '.search-item' ) ) {
						focusableEls[i].setAttribute( 'tabindex', '-1' );
					}
				};

				// Set a delay to stop conflict with toggleFocus() in a11y.js
				setTimeout( function() {
					item.classList.add( 'sfHover' );
				}, 50 );

				if ( ! document.body.classList.contains( 'nav-aligned-center' ) ) {
					item.classList.add( 'close-search' );
				} else {
					item.style.opacity = 0;
					setTimeout( function() {
						item.classList.add( 'close-search' );
						item.style.opacity = 1;
						if ( document.body.classList.contains ( 'rtl' ) ) {
							item.style.float = 'left';
						} else {
							item.style.float = 'right';
						}
					}, 250 );
				}
			}
		}

		if ( document.body.classList.contains( 'nav-search-enabled' ) ) {
			var searchItems = document.querySelectorAll( '.search-item' );

			for ( var i = 0; i < searchItems.length; i++ ) {
				searchItems[i].addEventListener( 'click', toggleSearch, false );
			}

			// Close navigation search on click elsewhere
			document.addEventListener( 'click', function ( event ) {
				if ( document.querySelector( '.inside-navigation .search-form.nav-search-active' ) ) {
					if ( ! event.target.closest( '.inside-navigation .search-form' ) && ! event.target.closest( '.search-item' ) ) {
						var activeSearchItems = document.querySelectorAll( '.search-item.active' );
						for ( var i = 0; i < activeSearchItems.length; i++ ) {
							toggleSearch( event, activeSearchItems[i] );
						}
					}
				}
			}, false);

			// Close navigation search on escape key
			document.addEventListener( 'keydown', function( e ) {
				if ( document.querySelector( '.inside-navigation .search-form.nav-search-active' ) ) {
					var key = e.which || e.keyCode;

					if ( key === 27 ) { // 27 is esc
						var activeSearchItems = document.querySelectorAll( '.search-item.active' );
						for ( var i = 0; i < activeSearchItems.length; i++ ) {
							toggleSearch( e, activeSearchItems[i] );
						}
					}
				}
			}, false );
		}
	}
})();
