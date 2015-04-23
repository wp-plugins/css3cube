/**
 * Created by tronki on 3/15/15.
 */
/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {



    //update CUBE text color
    wp.customize( 'css3cube_options[front_text_color]', function( value ) {
        value.bind( function( newval ) {
            $( 'article.front' ).css( 'color', newval );
        } );
    } );
    wp.customize( 'css3cube_options[back_text_color]', function( value ) {
        value.bind( function( newval ) {
            $( 'article.back' ).css( 'color', newval );
        } );
    } );
    wp.customize( 'css3cube_options[left_text_color]', function( value ) {
        value.bind( function( newval ) {
            $( 'article.left' ).css( 'color', newval );
        } );
    } );
    wp.customize( 'css3cube_options[right_text_color]', function( value ) {
        value.bind( function( newval ) {
            $( 'article.right' ).css( 'color', newval );
        } );
    } );
    wp.customize( 'css3cube_options[top_text_color]', function( value ) {
        value.bind( function( newval ) {
            $( 'article.top' ).css( 'color', newval );
        } );
    } );
    wp.customize( 'css3cube_options[bottom_text_color]', function( value ) {
        value.bind( function( newval ) {
            $( 'article.bottom' ).css( 'color', newval );
        } );
    } );

    //update CUBE side background color
    wp.customize( 'css3cube_options[front_bg_color]', function( value ) {
        value.bind( function( newval ) {
            $( 'figure.front' ).css( 'background', newval );

        } );
    } );
    wp.customize( 'css3cube_options[back_bg_color]', function( value ) {
        value.bind( function( newval ) {
            $( 'figure.back' ).css( 'background', newval );
        } );
    } );
    wp.customize( 'css3cube_options[left_bg_color]', function( value ) {
        value.bind( function( newval ) {
            $( 'figure.left' ).css( 'background', newval );
        } );
    } );
    wp.customize( 'css3cube_options[right_bg_color]', function( value ) {
        value.bind( function( newval ) {
            $( 'figure.right' ).css( 'background', newval );
        } );
    } );
    wp.customize( 'css3cube_options[top_bg_color]', function( value ) {
        value.bind( function( newval ) {
            $( 'figure.top' ).css( 'background', newval );
        } );
    } );
    wp.customize( 'css3cube_options[bottom_bg_color]', function( value ) {
        value.bind( function( newval ) {
            $( 'figure.bottom' ).css( 'background', newval );
        } );
    } );
    //update CUBE side opacity
    wp.customize( 'css3cube_options[cube_opacity]', function( value ) {
        value.bind( function( newval ) {
            $( 'figure.front' ).css( 'opacity', newval );
            $( 'figure.back' ).css( 'opacity', newval );
            $( 'figure.left' ).css( 'opacity', newval );
            $( 'figure.right' ).css( 'opacity', newval );
            $( 'figure.top' ).css( 'opacity', newval );
            $( 'figure.bottom' ).css( 'opacity', newval );

        } );
    } );





//    wp.customize( 'tcx_display_header', function( value ) {
//        value.bind( function( to ) {
//            false === to ? $( '#header' ).hide() : $( '#header' ).show();
//        } );
//    } );https://make.wordpress.org/core/2014/10/27/toward-a-complete-javascript-api-for-the-customizer/
    //https://make.wordpress.org/core/2014/07/08/customizer-improvements-in-4-0/

} )( jQuery );