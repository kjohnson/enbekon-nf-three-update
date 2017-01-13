<?php

final class NF_Enbekon_Plugin
{
    private $version;
    private $url;
    private $dir;

    public function __construct( $version, $file )
    {
        $this->version = $version;
        $this->url = plugin_dir_url($file);
        $this->dir = plugin_dir_path($file);

        add_filter( 'ninja_forms_register_action',      array( $this, 'register_actions' ) );
        add_filter( 'ninja_forms_render_default_value', array( $this, 'default_value'    ) );
    }

    public function register_actions( $actions )
    {
        require_once $this->dir( 'includes/actions/enbekon.php' );
        $actions[ 'enbekon' ] = new NF_Enbekon_Action();
        return $actions;
    }

    public function default_value( $default_value, $field_type, $field_settings )
    {
        /*
         * Instead of using a field ID, set the Field Key.
         * In the builder: Field Settings -> Administration -> Field Key
         *
         * Field Keys are portable between forms and are human readable,
         *   where as IDs require hard coded custom code.
         */

        if( 'company_lng' == $field_settings[ 'key' ] ){
          $default_value = $this->get_company_info()->lng;
        }

        if( 'company_lat' == $field_settings[ 'key' ] ){
          $default_value = $this->get_company_info()->lat;
        }

        return $default_value;
    }

    private function get_company_info(){
        static $get_company_info; // Only perform the query once per request cycle.
        if( ! isset( $get_company_info ) ){
            $get_company_info = $wpdb->get_results( "SELECT field_1, field_2,.. FROM ..." );
        }
        return $get_company_info[0]; // Return the first result.
    }

    /*
    |--------------------------------------------------------------------------
    | Getter Methods
    |--------------------------------------------------------------------------
    */

    public function version()
    {
        return $this->version;
    }

    public function url( $url = '' )
    {
        return trailingslashit( $this->url ) . $url;
    }

    public function dir( $path = '' )
    {
        return trailingslashit( $this->dir ) . $path;
    }

    public function config( $file_name )
    {
        return include $this->dir( 'includes/config/' . $file_name . '.php' );
    }

    public function template( $file, $args = array() )
    {
        $path = $this->dir( 'templates/' . $file );
        if( ! file_exists(  $path ) ) return '';
        extract( $args );
        ob_start();
        include $path;
        return ob_get_clean();
    }
}
