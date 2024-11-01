/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function( api, $ ) {

	/* Header */

	api( 'twentig_header_width', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( 'tw-header-wide tw-header-full' );
			if ( to ) {
				$( 'body' ).addClass( 'tw-header-' + to );
			}
		} );
	} );

	api( 'twentig_header_padding', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( 'tw-header-padding-small tw-header-padding-medium tw-header-padding-large' );
			if ( to ) {
				$( 'body' ).addClass( 'tw-header-padding-' + to );
			}
		} );
	} );

	api( 'twentig_header_sticky', function( value ) {
		value.bind( function( to ) {
			if ( $( 'body' ).hasClass( 'tw-header-light' ) || $( 'body' ).hasClass( 'page-template-tw-header-transparent' ) ) {
				api.preview.send( 'twentig-refresh-preview');
			}		
			$( 'body' ).removeClass( 'tw-header-sticky' );
			if ( to ) {
				$( 'body' ).addClass( 'tw-header-sticky tw-header-bg' );
			}
		} );
	} );

	api( 'twentig_menu_spacing', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( 'tw-nav-spacing-small tw-nav-spacing-medium tw-nav-spacing-large' );
			if ( to ) {
				$( 'body' ).addClass( 'tw-nav-spacing-' + to );
			}
		} );
	} );

	api( 'twentig_menu_hover', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( 'tw-nav-hover-border tw-nav-hover-none' );
			if ( to ) {
				$( 'body' ).addClass( 'tw-nav-hover-' + to );
			}
		} );
	} );

	/* Footer */

	api( 'twentig_footer_width', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( 'tw-footer-full' );
			if ( to ) {
				$( 'body' ).addClass( 'tw-footer-' + to );
			}
		} );
	} );

	api( 'twentig_footer_widgets_width', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( 'tw-footer-widgets-full' );
			if ( to ) {
				$( 'body' ).addClass( 'tw-footer-widgets-' + to );
			}
		} );
	} );

	api( 'twentig_links_style', function( value ) {
		value.bind( function( to ) {
			if ( 'minimal' === to ) {
				$( 'body' ).addClass( 'tw-link-minimal' ).removeClass( 'has-background-white' );
				if ( $( 'body' ).hasClass( 'is-dark-theme' ) ) {
					$( 'body' ).removeClass( 'is-dark-theme' ).addClass( 'dark-theme' );
				}
			} else {
				api.preview.send( 'twentig-refresh-preview');
			}
		} );
	} );

	/* Page */

	api( 'twentig_page_title_width', function( value ) {
		value.bind( function( to ) {
			$( 'body.page' ).removeClass( 'tw-title-text-width' );
			if ( 'text-width' === to ) {
				$( 'body.page' ).addClass( 'tw-title-text-width');
			} 
		} );
	} );
	
	api( 'twentig_page_title_text_align', function( value ) {
		value.bind( function( to ) {
			$( 'body.page' ).removeClass( 'tw-title-center' );
			if ( 'center' === to ) {
				$( 'body.page' ).addClass( 'tw-title-center');
			} 
		} );
	} );
	
	api( 'twentig_page_title_border', function( value ) {
		value.bind( function( to ) {
			$( 'body.page' ).removeClass( 'tw-title-no-border' );
			if ( ! to ) {
				$( 'body.page' ).addClass( 'tw-title-no-border');
			} 
		} );
	} );

	/* Blog */

	api( 'twentig_post_title_width', function( value ) {
		value.bind( function( to ) {
			$( 'body.single-post' ).removeClass( 'tw-title-text-width' );
			if ( 'text-width' === to ) {
				$( 'body.single-post' ).addClass( 'tw-title-text-width');
			} 
		} );
	} );

	api( 'twentig_post_title_text_align', function( value ) {
		value.bind( function( to ) {
			$( 'body.single-post' ).removeClass( 'tw-title-center' );
			if ( 'center' === to ) {
				$( 'body.single-post' ).addClass( 'tw-title-center');
			} 
		} );
	} );

	api( 'twentig_post_title_border', function( value ) {
		value.bind( function( to ) {
			$( 'body.single-post' ).removeClass( 'tw-title-no-border' );
			if ( ! to ) {
				$( 'body.single-post' ).addClass( 'tw-title-no-border');
			} 
		} );
	} );

	api( 'twentig_blog_columns', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( 'tw-blog-columns-2 tw-blog-columns-3' );
			if ( to ) {
				$( 'body.tw-blog-grid' ).addClass( 'tw-blog-columns-' + to );
			} 
		} );
	} );

	api( 'twentig_blog_image_placement', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( 'tw-blog-image-above tw-blog-image-below' );
			if ( to ) {
				$( 'body.tw-blog-grid, body.tw-blog-stack' ).addClass( 'tw-blog-image-' + to );
			} 
		} );
	} );

	api( 'twentig_blog_image_width', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( 'tw-blog-image-text-width tw-blog-image-wide' );
			if ( to ) {
				$( 'body.tw-blog-grid, body.tw-blog-stack' ).addClass( 'tw-blog-image-' + to );
			} 
		} );
	} );

	api( 'twentig_blog_image_ratio', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( 'tw-blog-img-ratio' );
			if ( to ) {
				$( 'body.tw-blog-grid, body.tw-blog-stack' ).addClass( 'tw-blog-img-ratio' );
			} 
		} );
	} );

	api( 'twentig_blog_text_align', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( 'tw-blog-text-center' );
			if ( to ) {
				$( 'body.tw-blog-grid, body.tw-blog-stack' ).addClass( 'tw-blog-text-' + to );
			} 
		} );
	} );
	
	/* Google Fonts */

	function twentigLoadGoogleFont( context, to ) {
		if ( to ) {
			var font, style, el, styleID, fontVariations;
			font = to.split(',')[0];
			font = font.replace(/'/g, '');
			font = font.replace( / /g, '+' );
			fontVariations = 'body' === context ? 'ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400' : 'wght@100;200;300;400;500;600;700;800;900';
			styleID = 'twentig-customizer-font-' + context;
			style = '<link rel="stylesheet" type="text/css" id="' + styleID + '" href="https://fonts.googleapis.com/css2?family=' + font + ':' + fontVariations + '&display=swap">';
			el = $( '#' + styleID );
				
			if ( el.length ) {
				el.replaceWith( style );
			} else {
				$( 'head' ).append( style );
			}
		}
	}

	$.each( [ 'body', 'heading', 'logo' ], function( index, setting ) {
		api( 'twentig_' + setting + '_font', function( value ) {
			var onChange = function( to ) {
				twentigLoadGoogleFont( setting, to );
			};
			onChange( value.get() );
			value.bind( onChange );
		} );
	} );

	var style = $( '#twentig-customizer-live-css' );
	if ( ! style.length ) {
		style = $( 'head' ).append( '<style type="text/css" id="twentig-customizer-live-css" />' ).find( '#twentig-customizer-live-css' );
	}

	api.bind( 'preview-ready', function() {	
		api.preview.bind( 'update-customizer-live-css', function( css ) {
			style.text( css );
		} );
	} );

})( wp.customize, jQuery );
