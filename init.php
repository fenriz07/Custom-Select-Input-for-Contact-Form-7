<?php

DEFINE('DIR_CSI7',__DIR__);

include DIR_CSI7 . '/helpers/dd.php';
include DIR_CSI7 . '/repositories/OptionsRepository.php';

/*
Plugin Name: Custom Select Input for Contact Form 7
Plugin URI: 
Description: Create a select input to fill  by tabñe
Author: Servio Zambrano
Author URI: 
Text Domain: contact-form-7-select-input
Version: 1.0.0
*/




add_action('wpcf7_init', 'add_custom_select_tag_csi7');

function add_custom_select_tag_csi7()
{
    wpcf7_add_form_tag(
        ['csi7','csi7*'],
        'custom_select_input_handler_csi7',
            [
            'name-attr' => true,
        ]
    );
}

function custom_select_input_handler_csi7($tag)
{
    $tag = new WPCF7_FormTag( $tag );

    $OptionRepository = new OptionRepository( $tag->options );

    if( !$OptionRepository->existAllOptions() ){
        return 'El campo le faltan parametros';
    }

    if ( empty( $tag->name ) ) {
        return '';
    }

    $atts = [];

    $class = wpcf7_form_controls_class( $tag->type );
    $atts['class'] = $tag->get_class_option( $class );
    $atts['id'] = $tag->get_id_option();

    $atts['name'] = $tag->name;
    $atts = wpcf7_format_atts( $atts );

    $options = $OptionRepository->getOptions();

    $html = '<span class="wpcf7-form-control-wrap %s"><select %s>  %s  </select></span>';

    $html = sprintf( $html, $tag->name,$atts,$options );

    return $html;
}


add_filter( 'wpcf7_validate_csi7*', 'custom_select_input__validation_filter_csi7', 20, 2 );
function custom_select_input__validation_filter_csi7( $result, $tag ) {


    if(!isset( $_POST[$tag->name]) ){
        $result->invalidate( $tag, "Debe seleccionar una opción" );
    }

    return $result;
}