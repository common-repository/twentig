/**
 * Twentig Starter Content.
 */

(function( api, $ ) {

	api.bind( 'ready', function() {
		
		var urlParser = document.createElement( 'a' ), queryParams;			
		urlParser.href = location.href;
		queryParams = api.utils.parseQueryString( urlParser.search.substr( 1 ) );
		
		if ( queryParams[ 'starter' ] ) {

			var starter = queryParams[ 'starter' ];
			var type = queryParams[ 'type' ] 
			
			delete queryParams.starter;
			delete queryParams.type;
			queryParams[ 'starter_load'] = 'ok';
			urlParser.search = $.param( queryParams );
			history.replaceState( {}, '', urlParser.href );

			var data = api.previewer.query();
			data['starter'] = starter;
			data['type'] = type;

			api.notifications.add( new api.OverlayNotification( 'theme_previewing', {
				message: api.l10n.themePreviewWait,
				type: 'info',
				loading: true
			} ) );

			var request = wp.ajax.post( 'customize_load_starter_content', data );
		
			request.done( function( res ) {
				
				if ( res['nav_menus'] !== undefined ) {
					$.each( $( '#sub-accordion-section-menu_locations select' ), function( index, select ) {
						var menu = $( select ).attr( 'data-customize-setting-link' ).replace( /(^.*\[|\].*$)/g, '' );
						if ( res['nav_menus'][ menu ] === undefined ) {
							wp.customize.control( 'nav_menu_locations[' + menu + ']', function( control ) {
								control.setting.set( '0' );		
							});
						}
					} );
				}

				if ( res['theme_mods'] !== undefined && 'twentytwenty' === _wpCustomizeSettings.theme.stylesheet ) {
					$.each( [ 'background_color', 'header_footer_background_color', 'twentig_footer_background_color', 'accent_hue' ], function( i, control ) {
						var value = typeof( res.theme_mods[ control ] ) !== 'undefined' ? res.theme_mods[ control ] : wp.customize( control ).get();
						wp.customize( control ).set( '' );
						wp.customize( control ).set( value );		
					});
				}

				setTimeout( function() {	
					api.panel( 'themes' ).loadThemePreview( api.settings.theme.stylesheet );
				}, 100 );
								
			});

			request.fail( function( res ) {
				alert( res );
				setTimeout( function() {	
					api.panel( 'themes' ).loadThemePreview( api.settings.theme.stylesheet );
				}, 100 );
			} );
		}

		$( '#twentig-customize-starter-button' ).on( 'click', function( e ) {
			e.preventDefault();		

			var starter_content = $( '#twentig-customize-starter-content' ).val();
			var import_type = $( '#twentig-customize-starter-import-type' ).val();

			if ( starter_content ) {
				var urlParser = document.createElement( 'a' ), queryParams;
				urlParser.href = location.href;
				queryParams = api.utils.parseQueryString( urlParser.search.substr( 1 ) );
				delete queryParams.changeset_uuid;
				queryParams['starter'] = starter_content;
				queryParams['type'] = import_type;
				urlParser.search = $.param( queryParams );
				location.replace( urlParser.href );
			}
		} );

		$( '#twentig-customize-starter-content' ).on( 'change', function( e ) {
			var $preview = $( '#twentig-customize-starter-screenshot' );
			
			if ( $( this ).val() ) {
				var image_url = $( this ).find( 'option:selected' ).attr( 'data-screenshot' );
				
				if ( $preview.find( 'img' ).length ) {
					$preview.find( 'img' ).attr( 'src', image_url );
				} else {
					$preview.prepend( '<img src="' + image_url + '" alt=""/>' );
				}
				$( '.twentig-customize-starter-terms' ).removeClass('hidden');
			} else {
				$preview.empty();
				$( '.twentig-customize-starter-terms' ).addClass('hidden');
			}
		});

		$( '#twentig-customize-starter-help' ).on( 'click', function( e ) {
			$( '#sub-accordion-section-twentig_starter_websites .customize-help-toggle ').trigger( 'click' );
		});

	});

})( wp.customize, jQuery );
