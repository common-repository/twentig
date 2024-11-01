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
	
	api.controlConstructor['select-optgroup'] = api.Control.extend( {
		ready: function() {		
			this.container.find( 'select' ).selectWoo();	
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

		$.each( {
			'custom_logo': {
				controls: [ 'twentig_custom_logo_alt', 'twentig_logo_width', 'twentig_logo_width_mobile' ],
				callback: function( to ) { return !! to; }
			},
			'display_title_and_tagline': {
				controls: [ 'twentig_hide_tagline', 'twentig_branding_color', 'twentig_fonts_section_title_logo', 'twentig_logo_font', 'twentig_logo_font_weight', 'twentig_logo_font_size', 'twentig_logo_font_size_mobile', 'twentig_logo_letter_spacing', 'twentig_logo_text_transform' ],
				callback: function( to ) { return to; }
			},
			'twentig_button_background_color': {
				controls: [ 'twentig_button_hover_background_color' ],
				callback: function( to ) { return !! to; }
			},	
			'twentig_site_width': {
				controls: [ 'twentig_inner_background_color' ],
				callback: function( to ) { return !! to; }
			},		
			'twentig_blog_layout': {
				controls: [ 'twentig_blog_columns' ],
				callback: function( to ) { return ( 'grid' === to ); }
			},
			'twentig_blog_image': {
				controls: [ 'twentig_blog_image_ratio', 'twentig_blog_image_width', 'twentig_blog_image_placement' ],
				callback: function( to ) { return !! to; }
			},
			'twentig_post_hero_layout' : {
				controls: [ 'twentig_post_image_placement' ],
				callback: function( to ) { return ( 'no-image' !== to && 'cover' !== to && 'cover-full' !== to ); }
			},
			'twentig_post_sidebar' : {
				controls: [ 'twentig_post_title_width' ],
				callback: function( to ) { return ! to; }
			},
			'twentig_page_hero_layout' : {
				controls: [ 'twentig_page_image_placement' ],
				callback: function( to ) { return ( 'no-image' !== to && 'cover' !== to && 'cover-full' !== to ); }
			},
			'twentig_footer_credit': {
				controls: [ 'twentig_footer_credit_text' ],
				callback: function( to ) { return 'custom' === to; }
			},
			'show_on_front' : {
				controls: [ 'twentig_blog_show_title' ],
				callback: function( to ) { return 'page' === to && ( '1.4' === twentigCustomizerSettings.themeVersion || '1.5' === twentigCustomizerSettings.themeVersion ) }
			}
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
		
		api( 'twentig_footer_layout', function( setting ) {
			var onChange = function( layout ) {
				$.each( [ 'twentig_footer_width', 'twentig_footer_credit', 'twentig_footer_credit_text', 'twentig_footer_branding', 'twentig_footer_social_icons' ], function( i, controlId ) {
					api.control( controlId, function( control ) {
						control.container.toggle( 'custom' !== layout && 'hidden' !== layout );				
					});								
				});				
		api.control( 'twentig_footer_content' ).container.toggle( 'custom' === layout );
				if ( 'custom' !== layout && 'hidden' !== layout ) {
					api.control( 'twentig_footer_credit_text' ).container.toggle( 'custom' === api( 'twentig_footer_credit' ).get() );
				}					
			};	
			onChange( setting.get() );
			setting.bind( onChange );
		} );


		api( 'display_excerpt_or_full_post', function( setting ) {			
			var onChange = function( to ) {
				var blog_show_content = api( 'twentig_blog_content' ).get();
				if ( 'excerpt' === to && blog_show_content ) {
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
				var blog_content = api( 'display_excerpt_or_full_post' ).get();
				if ( 'excerpt' === blog_content && to ) {
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
			};	
			onChange( setting.get() );
			setting.bind( onChange );
		} );

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

		api( 'twentig_post_sidebar', function( setting ) {
			var onChange = function( to ) {
				api.control( 'twentig_post_hero_layout', function( control ) {
					var value = control.setting.get();
					control.container.find( 'option' ).removeAttr( 'disabled' );
					if ( to ) {
						control.container.find( 'option[value="narrow-image"]' ).attr( 'disabled', 'disabled' );
						control.container.find( 'option[value="full-image"]' ).attr( 'disabled', 'disabled' );
						control.container.find( 'option[value="cover"]' ).attr( 'disabled', 'disabled' );
						control.container.find( 'option[value="cover-full"]' ).attr( 'disabled', 'disabled' );
						if ( 'narrow-image' === value || 'full-image' === value || 'cover' === value || 'cover-full' === value ) {
							control.setting.set( '' );
						}					
					}				
				});
			};	
			onChange( setting.get() );
			setting.bind( onChange );
		} );

		$.each( ['background_color', 'twentig_inner_background_color', 'twentig_site_width' ], function( key, settingId ) {
			api( settingId, function( setting ) {
				var onChange = function( to ) {
					var page_width       = api( 'twentig_site_width' ).get();
					var background_color = api( 'background_color' ).get();
					var page_background  = api( 'twentig_inner_background_color' ).get();
					var color_reference  = background_color;
					if ( page_width && page_background ) {
						color_reference = page_background;
					}
					var newColor = generateSubtleColor( color_reference );
					wp.customize( 'twentig_subtle_background_color' ).set( newColor );		
				};	
				onChange( setting.get() );
				setting.bind( onChange );
			} );
		});	

		$.each( [ 
			'twentig_primary_color',
			'twentig_content_link_color',
			'twentig_branding_color',
			'twentig_header_link_color',
			'twentig_header_link_hover_color',
			'twentig_footer_text_color',
			'twentig_footer_link_color',
			'twentig_widgets_text_color',
			'twentig_widgets_link_color',
      'twentig_blog_title_size'
			], 
			function( key, settingId ) {
				api( settingId, function( setting ) {
					var onChange = function( to ) {
						if ( '' === to ) {
							api.previewer.refresh();
						}
					};
					setting.bind( onChange );
				} );
			}
		);
	
		// Live fonts: tells the Customizer previewer to update the CSS
		var cssTemplate = wp.template( 'twentig-customizer-live-style' );
		var live_settings = [ 
			'twentig_body_font',
			'twentig_body_font_size',
			'twentig_body_line_height',
			'twentig_heading_font',
			'twentig_heading_font_weight',
			'twentig_heading_letter_spacing',
			'twentig_h1_font_size',
			'twentig_post_h1_font_size',
			'twentig_secondary_elements_font',
			'twentig_menu_font',
			'twentig_menu_font_weight',
			'twentig_menu_font_size',
			'twentig_menu_letter_spacing',
			'twentig_menu_text_transform',
			'twentig_logo_font',
			'twentig_logo_font_weight',
			'twentig_logo_font_size',
			'twentig_logo_font_size_mobile',
			'twentig_logo_text_transform',
			'twentig_logo_letter_spacing',
			'twentig_wide_width',
			'twentig_default_width',
			'twentig_subtle_background_color',
			'twentig_primary_color',
			'twentig_content_link_color',
			'twentig_branding_color',
			'twentig_header_link_color',
			'twentig_header_link_hover_color',
			'twentig_footer_text_color',
			'twentig_footer_link_color',
			'twentig_widgets_text_color',
			'twentig_widgets_link_color',
			'twentig_header_decoration',			
			'twentig_footer_link_style',
			'twentig_footer_widgets_columns',
			'twentig_blog_image_ratio',
			'twentig_blog_title_size',
			'twentig_border_thickness',
			'twentig_button_shape',
			'twentig_button_size',
			'twentig_button_text_transform'
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
				$( '#_customize-input-twentig_body_font' ).trigger( 'change' );
				$( '#_customize-input-twentig_heading_font' ).trigger( 'change' );
				$( '#_customize-input-twentig_logo_font' ).trigger( 'change' );
			}			
		});

		api.previewer.bind( 'twentig-refresh-preview', function () {
			api.previewer.refresh();
		} );

	});

	// Generate Subtle Color
	function generateSubtleColor( to ) {
		var backgroundColor = Color( to );
		var textColor = backgroundColor.getMaxContrastColor();
	
		var lightenColor = Color( to ).lighten(4);
		var darkenColor = Color( to ).darken(4);
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
		return newColor.toCSS();
	}

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

		if ( selectedFont ) {
			weightOpt = '';	
			var fontObj = _.find( twentigCustomizerSettings.fonts, function( font ) { return font.family === selectedFont; } );
			if ( ! $.isEmptyObject( fontObj ) && ! _.isUndefined( fontObj.variants ) ) {
				$.each( fontObj.variants, function( key, value ) {
					if ( value.indexOf( 'italic' ) === -1 ) {
						weightOpt += '<option value="' + value + '">' + twentigCustomizerSettings.fontVariants[ value ] + '</option>';
					}
				});									
			}
		}

		api.control( fontWeightControl, function( control ) {
			var value = control.setting.get();
			control.container.find( 'select' ).empty().append( weightOpt ).find( 'option[value="' + value + '"]' ).prop( 'selected', true );
			control.setting.set( control.container.find( 'select' ).val() );
		});	
	}


})( wp.customize, jQuery );
