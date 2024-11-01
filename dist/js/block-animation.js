(function() {

	document.addEventListener( 'DOMContentLoaded', function() {
		const blocks_to_animate = document.querySelectorAll( '.tw-block-animation' );
		
		if ( blocks_to_animate.length > 0 && "IntersectionObserver" in window ) {
			
			const options = {
				rootMargin: '0px 0px -80px 0px',
				threshold: 0,
			}

			const callback = ( entries ) => {
				entries.forEach( ( entry ) => {
					if ( entry.isIntersecting ) {
						entry.target.classList.add( 'animated' );
						observer.unobserve( entry.target );
					}
				})
			};
			
			const observer = new IntersectionObserver( callback, options );
			
			blocks_to_animate.forEach( ( block ) => {
				observer.observe( block );
			});
		}
	});
})();
