<?php

final class NF_Enbekon_Action extends NF_Abstracts_Action
{
    protected $_name     = 'enbekon';
    protected $_tags     = array();
    protected $_timing   = 'late';
    protected $_priority = '10';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Enbekon', 'nf-enbekon' );

        $settings = NF_Enbekon()->config( 'enbekon-action-settings' );
        $this->_settings = array_merge( $this->_settings, $settings );
    }

    public function save( $action_settings )
    {
        // This section intentionally left blank.
    }

    public function process( $action_settings, $form_id, $data )
    {
        $email         = $account_settings[ 'enbekon_email' ];
        $firstname     = $account_settings[ 'enbekon_firstname' ];
        $lastname      = $account_settings[ 'enbekon_lastname' ];
        $username      = $account_settings[ 'enbekon_username' ];
        $street        = $account_settings[ 'enbekon_street' ];
        $street_number = $account_settings[ 'enbekon_street_number' ];

        // Validate Username
        if( ! is_username_valid( $username ) ){
            $errors[ 'enbekon-username' ] = __( 'User name can only contain letters, numbers, ., -, *, and @', 'nf-enbekon' );
        }

        // Check if account already exists.
        $email   = email_exists( $email );
        $user_id = username_exists( $username );
        if( $user_id ){
            $errors[ 'enbekon-username' ] = __( 'Please choose other user name, this one already exists', 'nf-enbekon' );
        } elseif( ! empty( $email ) && ! empty( $user_id ) ){
            $errors[ 'enbekon-account' ] = __( 'Your account already exists, please logon', 'nf-enbekon' );
        }

        // TODO: Check Address

        if( ! $errors ){
            $user_id = wp_create_user( $username, $password, $email );
            $user = new WP_User( $user_id );
        } else {
            // Return error messages.
            $data[ 'errors' ][ 'form' ] = $errors;
        }

        return $data;
    }

    private function is_username_valid( $username )
    {
        return preg_match( '/^[a-zA-Z0-9@_*.]*$/', $username );
    }
}
