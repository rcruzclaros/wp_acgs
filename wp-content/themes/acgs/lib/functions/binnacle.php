<?php

/**
* Utility class for change detection and store them on database.
*/
class MemberBinnacle
{
    /* @var @data stores data before the changes */
    static $data = [];
    static $action = 'unknown';

    public static function before_update($user_id) {

        if ( $user_id <= 0 || !current_user_can( 'edit_user', $user_id )) {
          return;
        }

        // if on backend check member only
        if (is_admin()) {
          $memberships = wc_memberships_get_user_active_memberships($user_id);

          if( empty($memberships) ) {
            return;
          }
        }

        $user = get_user_by( 'id', $user_id );
        self::$data = [
            'first_name'  => $user->first_name,
            'middle_name' => $user->middle_name,
            'last_name'   => $user->last_name,
            'user_email'  => $user->user_email,
            'country_region'  => $user->billing_country,
            'address'         => $user->billing_address_1,
            'address2'        => $user->billing_address_2,
            'city'            => $user->billing_city,
            'state_province'  => $user->billing_state,
            'zipcode'         => $user->billing_postcode,
            'phone'           => $user->billing_phone,
            'billing_company' => $user->billing_company,
        ];
    }

    public static function after_update($user_id, $action) {
        global $wpdb;

        if ( empty( self::$data ) || $user_id <= 0 || !current_user_can( 'edit_user', $user_id )) {
          return;
        }

        // on backend only store members binnacle
        if (is_admin()) {
          $memberships = wc_memberships_get_user_active_memberships($user_id);

          if( empty($memberships) ) {
            return;
          }
        }

        self::$action = $action;
        $user = get_user_by( 'id', $user_id );

        $new_data = [
            'first_name'  => $user->first_name,
            'middle_name' => $user->middle_name,
            'last_name'   => $user->last_name,
            'user_email'  => $user->user_email,
            'country_region'  => $user->billing_country,
            'address'         => $user->billing_address_1,
            'address2'        => $user->billing_address_2,
            'city'            => $user->billing_city,
            'state_province'  => $user->billing_state,
            'zipcode'         => $user->billing_postcode,
            'phone'           => $user->billing_phone,
            'billing_company' => $user->billing_company,
        ];

        $diff_data = self::get_diff($new_data);
        // error_log("after_update called: " . print_r($diff_data, true));

        if( empty( $diff_data ) ) {
            return;
        }

        $fields = [
            'user_id'   => $user->ID,
            'action'    => self::$action,
            'edited_at' => date('Y-m-d h:i:s'),
            'status'    => 0,
            'metadata'  => serialize(self::$data),
            'diff_data' => serialize($diff_data),
        ];
        $fields_format = ['%d', '%s', '%s', '%d', '%s', '%s'];

        // insert data into db
        $tblname = self::get_tbl_name();
        $wpdb->insert($tblname, $fields, $fields_format);
    }

    private static function get_tbl_name() {
        global $wpdb; 
        return $wpdb->prefix . "binnacle_member";
    }

    /* Compare old with new data and get diff array with new data values */
    private static function get_diff($new_data) {
        $diff = [];
        foreach (self::$data as $key => $value) {
            if ( isset($new_data[$key]) && strcmp($value, $new_data[$key]) !== 0 ) {
                $diff[$key] = $new_data[$key];
            }
        }
        return $diff;
    }
}

/*  Binnacle member when update profile
***************************************/

function acgs_binnacle_profile_update_before($user_id) {
    MemberBinnacle::before_update($user_id);
}
add_action( 'edit_user_profile_update', 'acgs_binnacle_profile_update_before', 1);
add_action( 'personal_options_update', 'acgs_binnacle_profile_update_before', 1);

function acgs_binnacle_profile_updated_errors($errors, $user) {
    if ( wc_notice_count( 'error' ) === 0 ) {
        acgs_binnacle_profile_update_before(get_current_user_id());
    }
}
add_action('woocommerce_save_account_details_errors', 'acgs_binnacle_profile_updated_errors', 10, 2);

function acgs_binnacle_profile_update_after($user_id) {
    MemberBinnacle::after_update($user_id, 'profile_update');
}
add_action( 'edit_user_profile_update', 'acgs_binnacle_profile_update_after');
add_action( 'personal_options_update', 'acgs_binnacle_profile_update_after');
add_action( 'woocommerce_save_account_details', 'acgs_binnacle_profile_update_after');

/*  Binnacle member when update address
****************************************/
function acgs_binnacle_save_address_before($user_id) {
    MemberBinnacle::before_update(get_current_user_id());
}

function acgs_woocommerce_customer_save_address_validation($user_id) {
    if( 0 === wc_notice_count( 'error' ) ) {
        acgs_binnacle_save_address_before($user_id);
    }
}
add_action('woocommerce_after_save_address_validation', 'acgs_woocommerce_customer_save_address_validation');

function acgs_binnacle_save_address_after($user_id) {    
    update_usermeta( $user_id, 'first_name', $_POST['billing_first_name'] );
    update_usermeta( $user_id, 'last_name', $_POST['billing_last_name'] );
    wp_update_user( array( 'ID' => $user_id, 'user_email' => $_POST['billing_email'] ) );
    MemberBinnacle::after_update($user_id, 'address_update');
}
add_action('woocommerce_customer_save_address', 'acgs_binnacle_save_address_after');

/*  Binacle deleting 
******************************/

add_action( 'wp_enqueue_scripts', 'acgs_enqueue_binnacle_scripts' );
function acgs_enqueue_binnacle_scripts($hook) {
    wp_enqueue_script( 'custom-ajax', get_stylesheet_directory_uri().'/lib/js/custom-ajax.js', array('jquery'), null, true);
    wp_localize_script( 'custom-ajax', 'ajax_object', array( 
        'ajax_url' => admin_url( 'admin-ajax.php', 'admin' ) 
    ) );
}

add_action( 'wp_ajax_acgs_binnacle_remove', 'acgs_binnacle_remove' );
function acgs_binnacle_remove() {
    global $wpdb;

    $binnacle_id = intval( $_POST['bid'] );

    $tblname = $wpdb->prefix . "binnacle_member";
    $result = $wpdb->query(
            'DELETE  FROM ' . $tblname . '
            WHERE id = "' . $binnacle_id . '"'
    );
    wp_send_json( array(
        'success' => $result !== false,
        'message' => 'Binnacle deleted',
    ) );
    wp_die();
}