<?php
/**
 * Plugin Name: Css3 Cube
 * Plugin URI: https://github.com/fracalo/css3cube
 * Description: Integrates a cube-template for displaying page previews on front page in css3 cube fashion, configurable through the wp-customizer  .
 * Version: 1.0.1
 * Author: Fra Calo
 * Author URI:  http://ps13.org
 * License: GPL2
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
    echo ' It\'s like a jungle sometimes makes me wonder how I keep from going under';
    exit;
}

define( 'WPCSS3CUBE_VERSION', '1.0.1' );
define( 'WPCSS3CUBE__MINIMUM_WP_VERSION', '4.1.0' );
define( 'WPCSS3CUBE__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WPCSS3CUBE__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPCSS3CUBE_BASENAME',plugin_basename(__FILE__) );




class CubeCustomizer {

    /**
     * A reference to an instance of this class.
     */
    private static $instance;


    /**
     * Returns an instance of this class.
     */
    public static function get_instance() {

        if( null == self::$instance ) {
            self::$instance = new CubeCustomizer();
        }

        return self::$instance;

    }

    private function __construct() {

        add_action( 'customize_register', array('CubeCustomizer','css3cube_customize_register') );
        add_action( 'customize_preview_init', array('CubeCustomizer','css3cube_customizer_live_preview') );
        add_action( 'customize_preview_init', array('CubeCustomizer','css3cube_receiver_scripts') );
        add_action( 'customize_controls_enqueue_scripts', array('CubeCustomizer','css3cube_controls_enqueue_scripts') );

        add_filter("plugin_action_links_".WPCSS3CUBE_BASENAME , array('CubeCustomizer','plugin_settings_link_css3cube') );

    }



    public static function css3cube_customize_register($wp_customize){

        /*take out section setting static-front*/
        $wp_customize->remove_section('static_front_page');

 /*--------------------------------------------------------------*\
   set customizer panel for the CUBE (and all that comes with it)
 \*--------------------------------------------------------------*/
//todo integrate defaults to match random generator and inject on front page when no option is saved


        $wp_customize->add_panel( 'panel_cube', array(
            'priority'       => 200,
            'title'          => 'Cube Sides',
            'description'    => 'configure cube sides',
            'active_callback' => 'is_front_page'
        ) );

        $wp_customize->add_section( 'section_front', array(
            'title'          => __( 'Front', 'themename' ),
            'priority'       => 60,
            'panel'  => 'panel_cube',
        ) );
        /*setting-control for page-content*/
        $wp_customize->add_setting( 'css3cube_options[featured_content_front]', array(
            'type'           => 'option',
            'capability'     => 'edit_theme_options',
            array(
                'sanitize_callback' => 'example_sanitize_integer',
            )
        ) );
        $wp_customize->add_control( 'featured_content_front', array(
            'label'      => __( 'Front Side Page', 'themename' ),
            'section'    => 'section_front',
            'settings'    => 'css3cube_options[featured_content_front]',
            'type'       => 'dropdown-pages',
        ) );
        $wp_customize->add_setting( 'css3cube_options[front_text_color]', array(
            'transport'      => 'postMessage',
            'type'           => 'option',
            'capability'     => 'edit_theme_options',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'front_text_color', array(
            'label'   => __( 'front text color', 'themename' ),
            'section' => 'section_front',
            'settings'   => 'css3cube_options[front_text_color]',
        ) ) );
      $wp_customize->add_setting( 'css3cube_options[front_bg_color]', array(
            'default'        => '#81d742',
            'transport'      => 'postMessage',
            'type'           => 'option',
            'capability'     => 'edit_theme_options',
        ) );
        /* @todo-maio add RGBA support */
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'front_bg_color', array(
            'label'   => __( 'front background color', 'themename' ),
            'section' => 'section_front',
            'settings'   => 'css3cube_options[front_bg_color]',
        ) ) );

        /*left side*/
        $wp_customize->add_section( 'section_left', array(
            'title'          => __( 'Left', 'themename' ),
            'priority'       => 60,
            'panel'  => 'panel_cube',
        ) );
        $wp_customize->add_setting( 'css3cube_options[featured_content_left]', array(
            'type'           => 'option',
            'capability'     => 'edit_theme_options',
            array(
                'sanitize_callback' => 'example_sanitize_integer',
            )
        ) );
        $wp_customize->add_control( 'featured_content_left', array(
            'label'      => __( 'Left Side Page', 'themename' ),
            'section'    => 'section_left',
            'type'       => 'dropdown-pages',
            'settings'   => 'css3cube_options[featured_content_left]'
        ) );
        $wp_customize->add_setting( 'css3cube_options[left_text_color]', array(
            'transport'      => 'postMessage',
            'type'           => 'option',
            'capability'     => 'edit_theme_options',
            array(
                'sanitize_js_callback' => '#',
            )
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'left_text_color', array(
            'label'   => __( 'left text color', 'themename' ),
            'section' => 'section_left',
            'settings'   => 'css3cube_options[left_text_color]',
        ) ) );
        $wp_customize->add_setting( 'css3cube_options[left_bg_color]', array(
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'      => 'postMessage',
            'type'           => 'option',
            'capability'     => 'edit_theme_options',

        ) );

        /* @todo-maio add RGBA support */
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'left_bg_color', array(
            'label'   => __( 'left background color', 'themename' ),
            'section' => 'section_left',
            'settings'   => 'css3cube_options[left_bg_color]',
        ) ) );

        /*right side*/
        $wp_customize->add_section( 'section_right', array(
            'title'          => __( 'Right', 'themename' ),
            'priority'       => 60,
            'panel'  => 'panel_cube',
        ) );
        $wp_customize->add_setting( 'css3cube_options[featured_content_right]', array(
            'type'           => 'option',
            'capability'     => 'edit_theme_options',
            array(
                'sanitize_callback' => 'example_sanitize_integer',
            )
        ) );
        $wp_customize->add_control( 'featured_content_right', array(
            'label'      => __( 'Right Side Page', 'themename' ),
            'section'    => 'section_right',
            'type'       => 'dropdown-pages',
            'settings'  => 'css3cube_options[featured_content_right]'
        ) );
        $wp_customize->add_setting( 'css3cube_options[right_text_color]', array(
//            'default'        => '#eeee33',
            'transport'      => 'postMessage',
            'type'           => 'option',
            'capability'     => 'edit_theme_options',
            array(
                'sanitize_js_callback' => '#',
            )
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'right_text_color', array(
            'label'   => __( 'right text color', 'themename' ),
            'section' => 'section_right',
            'settings'   => 'css3cube_options[right_text_color]',
        ) ) );
        $wp_customize->add_setting( 'css3cube_options[right_bg_color]', array(
            'transport'      => 'postMessage',
            'type'           => 'option',
            'capability'     => 'edit_theme_options',

        ) );
        /* @todo-maio add RGBA support */
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'right_bg_color', array(
            'label'   => __( 'right background color', 'themename' ),
            'section' => 'section_right',
            'settings'   => 'css3cube_options[right_bg_color]',
        ) ) );

        /*back side*/
        $wp_customize->add_section( 'section_back', array(
            'title'          => __( 'Back', 'themename' ),
            'priority'       => 60,
            'panel'  => 'panel_cube',
        ) );
        $wp_customize->add_setting( 'css3cube_options[featured_content_back]', array(
            'type'           => 'option',
            'capability'     => 'edit_theme_options',
            array(
                'sanitize_callback' => 'example_sanitize_integer',
            )
        ) );
        $wp_customize->add_control( 'featured_content_back', array(
            'label'      => __( 'Back Side Page', 'themename' ),
            'section'    => 'section_back',
            'type'       => 'dropdown-pages',
            'settings'   => 'css3cube_options[featured_content_back]'
        ) );
        $wp_customize->add_setting( 'css3cube_options[back_text_color]', array(
            'transport'      => 'postMessage',
            'type'           => 'option',
            'capability'     => 'edit_theme_options',
            array(
                'sanitize_js_callback' => '#',
            )
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'back_text_color', array(
            'label'   => __( 'back text color', 'themename' ),
            'section' => 'section_back',
            'settings'   => 'css3cube_options[back_text_color]',
        ) ) );
        $wp_customize->add_setting( 'css3cube_options[back_bg_color]', array(
            'transport'      => 'postMessage',
            'type'           => 'option',
            'capability'     => 'edit_theme_options',
        ) );
        /* @todo-maio add RGBA support */
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'back_bg_color', array(
            'label'   => __( 'back background color', 'themename' ),
            'section' => 'section_back',
            'settings'   => 'css3cube_options[back_bg_color]',
        ) ) );

        /*top side*/
        $wp_customize->add_section( 'section_top', array(
            'title'          => __( 'Top', 'themename' ),
            'priority'       => 60,
            'panel'  => 'panel_cube',
        ) );
        $wp_customize->add_setting( 'css3cube_options[featured_content_top]', array(
            'type'           => 'option',
            'capability'     => 'edit_theme_options',
            array(
                'sanitize_callback' => 'example_sanitize_integer',
            ),
         ) );
        $wp_customize->add_control( 'featured_content_top', array(
            'label'      => __( 'Top Side Page', 'themename' ),
            'section'    => 'section_top',
            'type'       => 'dropdown-pages',
            'settings' => 'css3cube_options[featured_content_top]'
        ) );
        $wp_customize->add_setting( 'css3cube_options[top_text_color]', array(
            'transport'      => 'postMessage',
            'type'           => 'option',
            'capability'     => 'edit_theme_options',
            array(
                'sanitize_js_callback' => '#',
            )
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'top_text_color', array(
            'label'   => __( 'top text color', 'themename' ),
            'section' => 'section_top',
            'settings'   => 'css3cube_options[top_text_color]',
        ) ) );
        $wp_customize->add_setting( 'css3cube_options[top_bg_color]', array(
            'transport'      => 'postMessage',
            'type'           => 'option',
            'capability'     => 'edit_theme_options',
        ) );
        /* @todo-maio add RGBA support */
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'top_bg_color', array(
            'label'   => __( 'top background color', 'themename' ),
            'section' => 'section_top',
            'settings'   => 'css3cube_options[top_bg_color]',
        ) ) );

        /*bottom side*/
        $wp_customize->add_section( 'section_bottom', array(
            'title'          => __( 'Bottom', 'themename' ),
            'priority'       => 60,
            'panel'  => 'panel_cube',
        ) );

        $wp_customize->add_setting( 'css3cube_options[featured_content_bottom]', array(
            'type'           => 'option',
            'capability'     => 'edit_theme_options',
            array(
                'sanitize_callback' => 'example_sanitize_integer',
            ),
        ) );
        $wp_customize->add_control( 'featured_content_bottom', array(
            'label'      => __( 'Bottom Side Page', 'themename' ),
            'section'    => 'section_bottom',
            'type'       => 'dropdown-pages',
            'settings'   => 'css3cube_options[featured_content_bottom]',
        ) );
        $wp_customize->add_setting( 'css3cube_options[bottom_text_color]', array(
            'transport'      => 'postMessage',
            'type'           => 'option',
            'capability'     => 'edit_theme_options',
            array(
                'sanitize_js_callback' => '#',
            )
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bottom_text_color', array(
            'label'   => __( 'bottom text color', 'themename' ),
            'section' => 'section_bottom',
            'settings'   => 'css3cube_options[bottom_text_color]',
        ) ) );
        $wp_customize->add_setting( 'css3cube_options[bottom_bg_color]', array(
            'transport'      => 'postMessage',
            'type'           => 'option',
            'capability'     => 'edit_theme_options',
        ) );
        /* @todo-maio add RGBA support */
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bottom_bg_color', array(
            'label'   => __( 'bottom background color', 'themename' ),
            'section' => 'section_bottom',
            'settings'   => 'css3cube_options[bottom_bg_color]',
        ) ) );
        /*cube opacity*/
        $wp_customize->add_section( 'cube_opacity', array(
            'title'          => __( 'Cube opacity', 'themename' ),
            /*'description'    =>__('configure opacity of cube sides','themename' ),*/
            'priority'       => 90,
            'panel'  => 'panel_cube',
        ) );

        $wp_customize->add_setting( 'css3cube_options[cube_opacity]', array(
            'type'           => 'option',
            'capability'     => 'edit_theme_options',
            'transport'      => 'postMessage',
//            array(
//                'sanitize_callback' => 'example_sanitize_integer',
//            ),
        ) );
        $wp_customize->add_control( 'cube_opacity', array(
            'type' => 'range',
            'priority' => 10,
            'settings'   => 'css3cube_options[cube_opacity]',
            'section' => 'cube_opacity',
            'label' => 'Range',
            'description' => __('Configure opacity of cube sides','themename' ),
            'input_attrs' => array(
                'min' => 0,
                'max' => 1,
                'step' => 0.05 ,
                'class' => 'test-class test',
                'style' => 'color: #0a0000',
            ),
        ) );
    }

/* adding postMessage script for live theme-customizer */
    public static function css3cube_customizer_live_preview()
    {
        wp_register_script( 'themecustomizer.js', WPCSS3CUBE__PLUGIN_URL . '_inc/themecustomizer.js', array( 'jquery','customize-preview' ), WPCSS3CUBE_VERSION, true );
        wp_enqueue_script('themecustomizer.js' );
    }

/* add a JS method to react to settings change in Accordion menu */
    public static function css3cube_controls_enqueue_scripts()
    {
        wp_register_script( 'control-customizer.js', WPCSS3CUBE__PLUGIN_URL . '_inc/control-customizer.js', '', WPCSS3CUBE_VERSION, true );
        wp_enqueue_script('control-customizer.js' );
    }
    public static function css3cube_receiver_scripts()
    {
        wp_register_script( 'receiver.js', WPCSS3CUBE__PLUGIN_URL . '_inc/receiver.js', '', WPCSS3CUBE_VERSION, true );
        wp_enqueue_script('receiver.js' );
    }

/* add link to customize  from plugin page */
    static function plugin_settings_link_css3cube($links)
    {
        $settings_link = '<a href="customize.php">Customize</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

}

add_action( 'plugins_loaded', array( 'CubeCustomizer', 'get_instance' ) );



class CubeTemplater {

    /**
     * A reference to an instance of this class.
     */
    private static $instance;

    /**
     * Returns an instance of this class.
     */
    public static function get_instance() {

        if( null == self::$instance ) {
            self::$instance = new CubeTemplater();
        }

        return self::$instance;
    }

    /**
     * Initializes the plugin by setting filters and administration functions.
     */
    private function __construct() {

        // Add a filter to the template include assign cube-template template
        // to front page
        add_filter(
            'template_include',
            array( $this, 'view_cube_template')
        );

        //load Css and JS
        add_action(
            'wp_enqueue_scripts',
            array( 'CubeTemplater', 'load_resources' ),
            false,
            '88',
            true
        );

    }


    /**
     *  functions used in template
     */

    public static function get_random_color(){
        $c = '#';
        for ($i = 0; $i<6; $i++)
        {
            $c .=  dechex(rand(0,15));
        }
        return "$c";
    }



    /**
     * defining variable and sides
     */
    public static function cube_sides($side){
        $side_lit  = $side;
        $cube_opt =get_option('css3cube_options');
        $p_side_id =  (isset($cube_opt['featured_content_'.$side])) ? $cube_opt['featured_content_'.$side] : '';//@todo-maio create defaults

        $p_side    =  get_post($p_side_id);
        $permalink =  get_post_permalink($p_side_id);
        $title     = apply_filters( 'the_title'  , $p_side->post_title);
        //$time      =  get_the_time();
        //$date      = apply_filters( 'the_time'   ,  get_the_time( 'j F, Y' ), $p_side->post_date );
        //$author    = apply_filters( 'the_author',   get_userdata($p_side->post_author)->display_name );
        $excerpt   = apply_filters( 'the_excerpt', $p_side->post_excerpt );
        $full_content   = apply_filters( 'the_content', $p_side->post_content );
        $body_content = (empty($excerpt)) ? $full_content : $excerpt;


        /*styling var*/
        $text_color=    (isset($cube_opt[$side.'_text_color'])) ? $cube_opt[$side.'_text_color'] : CubeTemplater::get_random_color() ;
        $bg_color=      (isset($cube_opt[$side.'_bg_color'])) ? $cube_opt[$side.'_bg_color'] : CubeTemplater::get_random_color();
        $sides_opacity =(isset($cube_opt['cube_opacity'])) ? $cube_opt['cube_opacity'] : 1;

        $z= "
        <figure class='$side_lit' style='background: " . $bg_color . " ; opacity: " . $sides_opacity . " '>
            <article id='post-$p_side_id ' class='$side_lit' style='color: $text_color'>
                <h2 id='post-$side' ><a href='$permalink' > $title</a></h2>

            <span class='content'>
            $body_content
            </span>
                <span id='more'></span>
            </article>
        </figure>
        ";

        return $z ;
    }

    public static function getcube_sides(){

        $sidelist= ["front","back","left","right","top","bottom"];
            foreach ($sidelist as $v) {
                echo CubeTemplater::cube_sides("$v");
            };
}
    /**
     * Checks if the template  exists and is_front_page
     */
    public function view_cube_template( $template ) {

        $file = plugin_dir_path(__FILE__). 'templates/cube-template.php' ;

        // Just to be safe, we check if the file exist first
        if( file_exists($file) && is_front_page() ) {
            return $file;
        }
        else { null; }

        return $template;

    }

    /**
     * hook css and JS only on cube template
     */
    public static function load_resources() {

                if(is_front_page()){
                //If page is using template then load our script and css
                wp_register_script( 'cube.js', WPCSS3CUBE__PLUGIN_URL . '_inc/cube.js', '', WPCSS3CUBE_VERSION, true );
                wp_enqueue_script( 'cube.js' );;
            }

        wp_register_style( 'cube.css', WPCSS3CUBE__PLUGIN_URL . '_inc/cube.css', '', WPCSS3CUBE_VERSION );
        wp_enqueue_style( 'cube.css');

    }

}

add_action( 'init', array( 'CubeTemplater', 'get_instance' ) );


