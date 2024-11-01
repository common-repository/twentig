(function() {

	/**
	 * hasClass utility
	 */
	function hasClass(el, cls) {
		if ( el.classList.contains( cls ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Throttle function
	 * Underscore.js 1.10.2 https://underscorejs.org
	 * (c) 2009-2020 Jeremy Ashkenas, DocumentCloud and Investigative Reporters & Editors
	 * Underscore may be freely distributed under the MIT license.
	 */
	function throttle(func, wait, options) {
		var now = Date.now || function() {
			return new Date().getTime();
		};
		var timeout, context, args, result;
		var previous = 0;
		if (!options) options = {};
		var later = function() {
			previous = options.leading === false ? 0 : now();
			timeout = null;
			result = func.apply(context, args);
			if (!timeout) context = args = null;
		};
		var throttled = function() {
			var _now = now();
			if (!previous && options.leading === false) previous = _now;
			var remaining = wait - (_now - previous);
			context = this;
			args = arguments;
			if (remaining <= 0 || remaining > wait) {
				if (timeout) {
					clearTimeout(timeout);
					timeout = null;
				}
				previous = _now;
				result = func.apply(context, args);
				if (!timeout) context = args = null;
			} else if (!timeout && options.trailing !== false) {
				timeout = setTimeout(later, remaining);
			}
			return result;
		};
		return throttled;
	}

	/**
	 * Runs the burger menu and sticky header functions as soon as the document is `ready`
	 */
	document.addEventListener( 'DOMContentLoaded', function() {

		var modals = document.querySelectorAll( '.cover-modal' );
		modals.forEach( function( modal ) {
			modal.addEventListener( 'toggle-target-before-inactive', function( event ) {
				document.body.classList.add( 'tw-os-modal-fix' );
				document.documentElement.style.setProperty('scroll-behavior', 'auto' );
			});
			modal.addEventListener( 'toggle-target-after-inactive', function( event ) {
				setTimeout( function() {
					document.body.classList.remove( 'tw-os-modal-fix' );
					document.documentElement.style.removeProperty( 'scroll-behavior' );
				}, 550 );
			});
		} );

		var header = document.querySelector( '#site-header' );
		if ( header != null && hasClass( document.body, 'tw-header-sticky' ) ) {
			var scrollToElement = document.querySelector( '.to-the-top' );
			if ( scrollToElement ) {
				scrollToElement.addEventListener( 'click', function( event ) {
					event.preventDefault();
					document.documentElement.scrollTop = 0;
					document.body.scrollTop = 0;
				});
			}

			if ( 'fixed' !== getComputedStyle( header ).position ) {
				modals.forEach( function( modal ) {
					modal.addEventListener( 'toggle-target-before-inactive', function( event ) {
						header.style.setProperty( 'position', 'fixed' );
						document.body.style.setProperty( 'padding-top', header.getBoundingClientRect().height + 'px' );
					});
					modal.addEventListener( 'toggle-target-after-inactive', function( event ) {
						setTimeout( function() {
							header.style.removeProperty( 'position' );
							document.body.style.removeProperty( 'padding-top' );
						}, 550 );
					});
				} );
			}

			if ( hasClass( document.body, 'overlay-header' ) || hasClass( document.body, 'tw-header-transparent' ) ) {
				var modals = document.querySelectorAll( '.cover-modal' );
				modals.forEach( function( modal ) {
					modal.addEventListener( 'toggle-target-before-inactive', function( event ) {
						document.body.classList.add( 'tw-modal-active' );
					});					
					modal.addEventListener( 'toggle-target-after-inactive', function( event ) {
						document.body.classList.remove( 'tw-modal-active' );
					});
				} );

				var scrollTop = window.pageYOffset;
				if ( scrollTop > 30 ) {
					document.body.classList.add( 'has-header-opaque' );
				} 

				window.addEventListener( 'scroll', throttle( function() {
					var scrollTop = window.pageYOffset;
					if ( scrollTop > 30 ) {
						document.body.classList.add( 'has-header-opaque' );
					} else if ( ! hasClass( document.body, 'tw-modal-active' ) ) {
						document.body.classList.remove( 'has-header-opaque' );
					}
				}, 100 ) );
			}
		}
	});
})();
