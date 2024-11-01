/**
 * Theme Customizer enhancements and logic.
 */

(function( api, $ ) {

	api.sectionConstructor['twentig-more'] = api.Section.extend( {
		attachEvents: function () {},
		isContextuallyActive: function () {
			return true;
		}
	} );

	api.controlConstructor['checkbox-multiple'] = api.Control.extend( {
		ready: function() {	
			var control = this,
				container = this.container;	

			container.on( 'change', 'input[type="checkbox"]', function() {
				var values = container.find( 'input[type="checkbox"]:checked' ).map( function() {
					return this.value;
				} ).get();

				if ( null === values ) {
					control.setting.set( '' );
				} else {
					control.setting.set( values );
				}
			});
		}
	});

	api.controlConstructor['tw-range'] = api.Control.extend( {
		ready: function() {
			var control = this,
				$input = this.container.find( '.tw-control-range-value' ),
				$slider = this.container.find( '.tw-control-range' );

				$slider.on( 'input change keyup', function() {
					$input.val( $(this).val() ).trigger( 'change' );
				});

				if ( control.setting() === '' ) {
					$slider.val( parseFloat( $slider.attr( 'min' ) ) ) ;
				}					

				$input.on('change keyup', function() {
					var value = $( this ).val();						
					control.setting.set( value );	
					if ( value ) {
						$slider.val( parseFloat( value ) );
					} else {
						$slider.val( parseFloat( $slider.attr( 'min' ) ) );
					}						
				});	

				// Update the slider if the setting changes.
				control.setting.bind( function( value ) {
					$slider.val( parseFloat( value ) );
				});
		}
	});
	
	api.bind( 'ready', function() {

		$( '.collapse-sidebar' ).on( 'click', function() {
			api.previewer.send( 'twentig-customizer-sidebar-expanded', $( this ).attr( 'aria-expanded' ) );
		});

		$.each( {
			'accent_hue_active'	: {
				controls: [ 'twentig_accent_hex_color' ],
				callback: function( to ) { return 'hex' === to; }
			},	
			'twentig_cover_page_height': {
				controls: [ 'twentig_cover_page_scroll_indicator' ],
				callback: function( to ) { return '' === to; }
			},
			'twentig_footer_credit': {
				controls: [ 'twentig_footer_credit_text' ],
				callback: function( to ) { return 'custom' === to; }
			},
			'twentig_footer_layout': {
				controls: [ 'twentig_footer_content' ],
				callback: function( to ) { return 'custom' === to; }
			},			
			'twentig_blog_layout': {
				controls: [ 'twentig_blog_columns' ],
				callback: function( to ) { return ( 'grid-basic' === to || 'grid-card' === to ); }
			},
			'twentig_blog_image': {
				controls: [ 'twentig_blog_image_ratio' ],
				callback: function( to ) { return !! to; }
			},
			'twentig_body_font': {
				controls: [ 'twentig_body_font_custom', 'twentig_body_font_fallback' ],
				callback: function( to ) { return 'custom-google-font' === to; }
			},
			'twentig_heading_font': {
				controls: [ 'twentig_heading_font_custom', 'twentig_heading_font_fallback' ],
				callback: function( to ) { return 'custom-google-font' === to; }
			},
			'twentig_logo_font': {
				controls: [ 'twentig_logo_font_custom', 'twentig_logo_font_fallback' ],
				callback: function( to ) { return 'custom-google-font' === to; }
			},
		}, function( settingId, o ) {
			wp.customize( settingId, function( setting ) {
				$.each( o.controls, function( i, controlId ) {
					api.control( controlId, function( control ) {
						var visibility = function( to ) {
							control.container.toggle( o.callback( to ) );
						};
						visibility( setting.get() );
						setting.bind( visibility );
					});
				});
			});
		});

		api( 'custom_logo', function( setting ) {			
			var onChange = function( logo ) {
				api.control( 'twentig_fonts_section_title_logo', function( control ) {
					control.container.find( '.description' ).toggle( !! logo );				
				});	
				$.each( [ 'twentig_custom_logo_transparent', 'twentig_logo_mobile_width' ], function( i, controlId ) {
					api.control( controlId, function( control ) {
						control.container.toggle( !! logo );				
					});					
				});
				$.each( [ 'twentig_logo_font', 'twentig_logo_font_weight', 'twentig_logo_font_size', 'twentig_logo_mobile_font_size', 'twentig_logo_letter_spacing', 'twentig_logo_text_transform' ], function( i, controlId ) {
					api.control( controlId, function( control ) {
						control.container.toggle( '' === logo );				
					});					
				});
				$.each( [ 'twentig_logo_font_custom', 'twentig_logo_font_fallback' ], function( i, controlId ) {
					api.control( controlId, function( control ) {
						control.container.toggle( '' === logo && 'custom-google-font' === api( 'twentig_logo_font' ).get() );				
					});					
				});
			};	
			onChange( setting.get() );
			setting.bind( onChange );
		} );

		api( 'blog_content', function( setting ) {			
			var onChange = function( to ) {
				var blog_show_content = api( 'twentig_blog_content' ).get();
				if ( 'summary' === to && blog_show_content ) {
					api.control( 'twentig_blog_excerpt_length' ).container.show();
					api.control( 'twentig_blog_excerpt_more' ).container.show();
				} else {
					api.control( 'twentig_blog_excerpt_length' ).container.hide();
					api.control( 'twentig_blog_excerpt_more' ).container.hide();
				}
			};	
			onChange( setting.get() );
			setting.bind( onChange );
		} );

		api( 'twentig_blog_content', function( setting ) {			
			var onChange = function( to ) {
				var blog_content = api( 'blog_content' ).get();
				if ( 'summary' === blog_content && to ) {
					api.control( 'twentig_blog_excerpt_length' ).container.show();
					api.control( 'twentig_blog_excerpt_more' ).container.show();
				} else {
					api.control( 'twentig_blog_excerpt_length' ).container.hide();
					api.control( 'twentig_blog_excerpt_more' ).container.hide();
				}
			};	
			onChange( setting.get() );
			setting.bind( onChange );
		} );

		api( 'twentig_heading_font', function( setting ) {
			var onChange = function( font ) {

				if ( '' === font || 'custom-google-font' === font ) {
					api.previewer.refresh();
				}

				updateControlFontWeights( 'twentig_heading_font_weight', font );

				var menu_font = api( 'twentig_menu_font' ).get();
				if ( 'heading' === menu_font ) {
					updateControlFontWeights( 'twentig_menu_font_weight', font );					
				}
			
				var logo_font = api( 'twentig_logo_font' ).get();
				if ( '' === logo_font ) {
					updateControlFontWeights( 'twentig_logo_font_weight', font );					
				}
			};	
			onChange( setting.get() );
			setting.bind( onChange );
		} );

		api( 'twentig_body_font', function( setting ) {
			var onChange = function( font ) {

				if ( '' === font || 'custom-google-font' === font ) {
					api.previewer.refresh(); 
				}

				var menu_font = api( 'twentig_menu_font' ).get();
				if ( 'body' === menu_font ) {
					updateControlFontWeights( 'twentig_menu_font_weight', font );					
				}
			};	
			onChange( setting.get() );
			setting.bind( onChange );
		} );
	
		api( 'twentig_logo_font', function( setting ) {
			var onChange = function( font ) {
				if ( '' === font ) {		
					updateControlFontWeights( 'twentig_logo_font_weight', api( 'twentig_heading_font' ).get() );
					api.previewer.refresh();
				} else if ( 'custom-google-font' === font ) {
					updateControlFontWeights( 'twentig_logo_font_weight', font );
					api.previewer.refresh();
				} else {
					updateControlFontWeights( 'twentig_logo_font_weight', font );
				}				
			};	
			onChange( setting.get() );
			setting.bind( onChange );
		} );				

		api( 'twentig_menu_font', function( setting ) {
			var onChange = function( font ) {
				updateControlFontWeights( 'twentig_menu_font_weight', font );
				if ( 'custom-google-font' === api( 'twentig_body_font' ).get() || 'custom-google-font' === api( 'twentig_heading_font' ).get() ) {
					api.previewer.refresh(); 
				}
			};	
			onChange( setting.get() );
			setting.bind( onChange );
		} );

		api( 'twentig_heading_font_weight', function( setting ) {
			var onChange = function( value ) {
				if ( 'custom-google-font' === api( 'twentig_heading_font' ).get() ) {
					api.previewer.refresh(); 
				}
			};	
			setting.bind( onChange );
		} );

		$.each( [ 'twentig_menu_font_weight', 'twentig_secondary_font', ], function( index, setting_name ) {
			api( setting_name, function( setting ) {
				var onChange = function( value) {
					if ( 'custom-google-font' === api( 'twentig_body_font' ).get() || 'custom-google-font' === api( 'twentig_heading_font' ).get() ) {
						api.previewer.refresh(); 
					}
				};
				setting.bind( onChange );
			} );
		});

		api( 'custom_logo', function( setting ) {
			var onChange = function( value ) {
				if ( '' === value && 'custom-google-font' === api( 'twentig_logo_font' ).get() ) {
					api.previewer.refresh(); 
				}
			};	
			setting.bind( onChange );
		} );

		$.each( [ 'twentig_logo_font_weight', 'twentig_logo_text_transform', ], function( index, setting_name ) {
			api( setting_name, function( setting ) {
				var onChange = function( value ) {
					if ( 'custom-google-font' === api( 'twentig_logo_font' ).get() ) {
						api.previewer.refresh(); 
					}
				};
				setting.bind( onChange );
			} );
		});

		api( 'twentig_logo_font_size', function( setting ) {
			var onChange = function( size ) {
				if ( size === '' ) {					
					api.previewer.refresh(); 
				}
			};	
			setting.bind( onChange );
		} );

		api( 'twentig_page_404', function( setting ) {
			setting.bind( function( to ) {
				api.previewer.previewUrl.set( api.settings.url.home + '404-page-not-found' );
			} );
		} );

		api( 'background_color', function( setting ) {
			var onChange = function( to ) {
				var backgroundColor = Color( to );
				var textColor = backgroundColor.getMaxContrastColor();
			
				var lightenColor = Color( to ).lighten(5);
				var darkenColor = Color( to ).darken(5);
				var newColor;
			
				if ( textColor == '#ffffff' ) {
					var contrastWithLight = textColor.getDistanceLuminosityFrom( lightenColor );
					newColor = contrastWithLight >= 4.5 ? lightenColor : darkenColor;
				} else {
					var contrastWithDark = textColor.getDistanceLuminosityFrom( darkenColor );
					newColor = contrastWithDark >= 4.5 ? darkenColor : lightenColor;
				}	

				if ( '#000000' == to ) {
					newColor = backgroundColor.lighten(7);			
				}			
				
				wp.customize( 'twentig_subtle_background_color' ).set( newColor.toCSS() );

			};	
			onChange( setting.get() );
			setting.bind( onChange );
		} );

		// Live fonts: tells the Customizer previewer to update the CSS
 		var cssTemplate = wp.template( 'twentig-customizer-live-style' );
		var live_settings = [ 
			'twentig_body_font',
			'twentig_body_font_custom',
			'twentig_heading_font',
			'twentig_heading_font_custom',
			'twentig_heading_font_weight',
			'twentig_secondary_font',
			'twentig_menu_font',
			'twentig_menu_font_weight',
			'twentig_logo_font',
			'twentig_logo_font_custom',
			'twentig_logo_font_weight',
			'twentig_logo_font_size',
			'twentig_logo_letter_spacing',
			'twentig_subtle_background_color',
			'twentig_button_uppercase'
		];

		// Update the CSS whenever a live setting is changed.
		_.each( live_settings, function( set ) {
			api( set, function( setting ) {		
				setting.bind( function( to ) {				
					updateCSS();	
				});
			});
		});
		
		// Generate the CSS for the current live settings.
		function updateCSS() {	
			var css,		
				styles = _.object( );	
			_.each( live_settings, function( setting ) {	
				styles[ setting ] = api( setting ) !== undefined ? api( setting )() : '';
			});	
			css = cssTemplate( styles );
			css = _.unescape(css);
			css = css.replace(/\s{2,}/g, ' ' );	
			api.previewer.send( 'update-customizer-live-css', css );
		}

		api.previewer.bind( 'twentig-refresh-preview', function () {
			api.previewer.refresh();
		} );
	
		var twentigBgColors = twentigCustomizerSettings['colorVars'];

		// Add a listener for accent-color changes.
		wp.customize( 'accent_hue', function( value ) {
			value.bind( function( to ) {
				Object.keys( twentigBgColors ).forEach( function( context ) {
					var backgroundColorValue;
					if ( twentigBgColors[ context ].color ) {
						backgroundColorValue = twentigBgColors[ context ].color;
					} else {
						backgroundColorValue = wp.customize( twentigBgColors[ context ].setting ).get();
					}
					twentigSetAccessibleColorsValue( context, backgroundColorValue, to );
				} );
			} );
		} );

		// Add a listener for background-color changes.
		Object.keys( twentigBgColors ).forEach( function( context ) {
			wp.customize( twentigBgColors[ context ].setting, function( value ) {
				value.bind( function( to ) {
					// Update the value for our accessible colors for this area.
					twentigSetAccessibleColorsValue( context, to, wp.customize( 'accent_hue' ).get() );
				} );
			} );
		} );

			// Handle the font presets panel.
		$( '.twentig-preset-panel-toggle' ).on( 'click', function( event ) {
			$( this ).parents( '.twentig-preset-panel' ).toggleClass( 'is-open' );
			$( this ).attr( 'aria-expanded', 'true' === $(this).attr( 'aria-expanded' ) ? 'false' : 'true' );			
			event.preventDefault();
		});

	 	$( '.twentig-preset-item' ).on( 'click touchend keydown', function( event ) {
	 		if ( 'keydown' === event.type && ( event.keyCode !== 13 && event.keyCode !== 32 ) ) {
	 			return;
	 		}
	 		var presetName = $( this ).attr( 'data-value' );	
	 		var preset = _.find( twentigCustomizerSettings.fontPresets, function( preset ) { return preset.name === presetName; } );
	 		if ( preset ) {	
				$.each( preset.mods, function( settingId, value ) {
					api( settingId, function( setting ) {
						setting.set( value );						
					});			
				});	
			}			
	 	});

	});

	// Update font-weight controls options
	function updateControlFontWeights( fontWeightControl, fontFamily ) {
		var selectedFont = fontFamily;
		if ( 'heading' === fontFamily ) {
			selectedFont = api( 'twentig_heading_font' ).get();
		} else if ( 'body' === fontFamily ) {
			selectedFont = api( 'twentig_body_font' ).get();
		} 

		var weightOpt = '';
		$.each( [ '400', '500', '600', '700', '800', '900' ], function( key, value) {
			weightOpt += '<option value="' + value + '">' + twentigCustomizerSettings.fontVariants[ value ] + '</option>';
		});

		if ( selectedFont && 'sans-serif' !== selectedFont && 'custom-google-font' !== selectedFont ) {
			weightOpt = '';	
			var fontObj = _.find( twentigCustomizerSettings.fonts, function( font ) { return font.family === selectedFont; } );
			if ( ! $.isEmptyObject( fontObj ) && ! _.isUndefined( fontObj.variants ) ) {
				$.each( fontObj.variants, function( key, value ) {
					weightOpt += '<option value="' + value + '">' + twentigCustomizerSettings.fontVariants[ value ] + '</option>';
				});									
			}
		}

		api.control( fontWeightControl, function( control ) {
			var value = control.setting.get();
			control.container.find( 'select' ).empty().append( weightOpt ).find( 'option[value="' + value + '"]' ).prop( 'selected', true );
			control.setting.set( control.container.find( 'select' ).val() );
		});	
	}

	//Updates the value of the "accent_accessible_colors" setting.
	function twentigSetAccessibleColorsValue( context, backgroundColor, accentHue ) {
		var value, colors;

		value = wp.customize( 'twentig_accessible_colors' ).get();
		value = ( _.isObject( value ) && ! _.isArray( value ) ) ? value : {};

		colors = twentyTwentyColor( backgroundColor, accentHue );

		if ( colors.getAccentColor() && 'function' === typeof colors.getAccentColor().toCSS ) {
			
			value[ context ] = {
				text: colors.getTextColor(),
				accent: colors.getAccentColor().toCSS(),
				background: backgroundColor
			};

			value[ context ].borders = colors.bgColorObj
				.clone()
				.getReadableContrastingColor( colors.bgColorObj, 1.36 )
				.toCSS();

			value[ context ].secondary = colors.bgColorObj
				.clone()
				.getReadableContrastingColor( colors.bgColorObj )
				.s( colors.bgColorObj.s() / 2 )
				.toCSS();
		}

		// Important to trigger change.
		wp.customize( 'twentig_accessible_colors' ).set( '' );		
		wp.customize( 'twentig_accessible_colors' ).set( value );
		// Small hack to save the option.
		wp.customize( 'twentig_accessible_colors' )._dirty = true;
	}

})( wp.customize, jQuery );
