<?php

/*
 * Plugin Name: Ninja Forms - Enbekon
 */

 if( ! function_exists( 'NF_Enbekon' ) ) {
     function NF_Enbekon()
     {
         static $instance;
         if( ! isset( $instance ) ) {
             require_once plugin_dir_path(__FILE__) . 'includes/plugin.php';
             $instance = new NF_Enbekon_Plugin( '1.0.0', __FILE__ );
         }
         return $instance;
     }
 }
 NF_Enbekon();
