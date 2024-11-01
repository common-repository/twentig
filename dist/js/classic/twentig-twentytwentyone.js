(function() {

	/**
	 * hasClass utility
	 */
	function hasClass(el, cls) {
		if ( el.classList.contains( cls ) ){
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
		var header = document.querySelector( '#masthead' );
		if ( header != null && hasClass( document.body, 'tw-header-sticky' ) ) {
			if ( hasClass( document.body, 'tw-header-light' ) || hasClass( document.body, 'page-template-tw-header-transparent' ) ) {
				var scrollTop = window.pageYOffset;
				if ( scrollTop > 30 ) {
					document.body.classList.add( 'tw-header-opaque' );
				}
				window.addEventListener( 'scroll', throttle( function() {
					var scrollTop = window.pageYOffset;
					if ( scrollTop > 30 ) {
						document.body.classList.add( 'tw-header-opaque' );
					} else {
						document.body.classList.remove( 'tw-header-opaque' );
					}
				}, 100 ) );
			}
		}
	});
})();
