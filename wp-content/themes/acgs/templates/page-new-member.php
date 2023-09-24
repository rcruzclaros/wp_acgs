<?php
/**
* Template Name: New Member Page
* Description: Used as a page template to show page contents, followed by a loop 
* through the "Member Page"
*/
// Add our custom loop
remove_action( 'genesis_loop', 'genesis_do_loop' );
// add_action( 'genesis_after_header', 'new_member_loop' );
function new_member_loop() {
    echo 'This is a test for new users, thanks for visit us: <br>';
    /**
     * Read CSV File
     */
    $emails = [];
    $logins = [];
    if (($gestor = fopen("active_members.csv", "r")) !== FALSE) {
        while (($datos = fgetcsv($gestor, 1000, ";")) !== FALSE) {
                $member_import_id = $datos[0];
                $first_name = $datos[1];
                $middle_name = $datos[2];
                $last_name = $datos[3];
                $email = $datos[10];
                $origin_email = $email;
                $phone = $datos[14];
                $member_type = $datos[5];
                $address_1 = $datos[6];
                $address_2 = $datos[12];
                $city = $datos[7];
                $state = $datos[8];
                $country = $datos[11];
                $zip = $datos[9];
                $m_date = $datos[15];

                /**
                 * Compare Duplicate Emails
                 */
                // if (in_array($email, $emails) || $email == '') 
                    $email = 'acgs'.$member_import_id.'@acgs.com';
                
                // $emails[] = $email;

                /**
                 * Compare Duplicate User Login
                 */
                $login = explode('@', $email);
                $user_login = $login[0];
                if (in_array($user_login, $logins)) 
                    $user_login = $user_login.$member_import_id;
                
                $logins[] = $user_login;

                /**
                 * Format of Dates
                 */
                // $dd = explode('/', $m_date);
                // if($dd[0]<10)
                //     $day = '0'.$dd[0];
                // else
                //     $day = $dd[0];
                
                // if($dd[1]<10)
                //     $month = '0'.$dd[1];
                // else
                //     $month = $dd[1];
                
                // $year = '20'.$dd[2];

                // $origin_date = $year.'/'.$month.'/'.$day;
                // $end_date = '2019/'.$month.'/'.$day;

                /**
                 * Wordpress format Country
                 */
                switch ($country) {
                    case 'USA':
                        $country = 'US';
                        break;
                    case 'Canada':
                        $country = 'CA';
                        break;
                }

                /**
                 * Wordpress format State
                 */
                switch ($state) {
                    case 'Quebec':
                        $state = 'US';
                        break;
                    case 'Alberta':
                        $state = 'QC';
                        break;
                }

                /**
                 * Select Member Plan ID
                 */
                // switch ($member_type) {
                //     case 'Individual':
                //         $plan_id = 763;
                //         break;
                //     case 'Individual Canada':
                //         $plan_id = 763;
                //         break;
                //     case 'Family':
                //         $plan_id = 782;
                //         break;
                //     case 'Student':
                //         $plan_id = 801;
                //         break;
                //     case 'E-International':
                //         $plan_id = 801;
                //         break;
                //     case 'Lifetime':
                //         $plan_id = 802;
                //         break;
                //     case 'Life':
                //         $plan_id = 802;
                //         break;
                //     case 'Life Associate':
                //         $plan_id = 803;
                //         break;
                //     case 'Family Life':
                //         $plan_id = 803;
                //         break;
                //     case 'Overseas':
                //         $plan_id = 804;
                //         break;
                //     case 'Institution':
                //         $plan_id = 805;
                //         break;
                //     case 'Institution Canada':
                //         $plan_id = 805;
                //         break;
                // }

            /**
             * Import to Wordpress DB
             */
            $userdata = array(
                'user_login'  =>  $user_login,
                'user_pass'   =>  '.acgs.2018.',
                'user_email'    =>  $email,
                'display_name' => $first_name.' '.$last_name,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'role' => 'editor',
            );

            $user_id = wp_insert_user( $userdata ) ;
            //     // $user_id = 18;
            // On success
            if ( ! is_wp_error( $user_id ) ) {
                echo "User created : ". $user_id;
                update_user_meta( $user_id, 'middle_name', $middle_name );
                update_user_meta( $user_id, 'origin_email', $origin_email );
                update_user_meta( $user_id, 'origin_id', $member_import_id );
                update_user_meta( $user_id, 'origin_mdate', $m_date );
                update_user_meta( $user_id, 'origin_mtype', $member_type );
                update_user_meta( $user_id, 'billing_address_1', $address_1 );
                update_user_meta( $user_id, 'billing_address_2', $address_2 );
                update_user_meta( $user_id, 'billing_city', $city );
                update_user_meta( $user_id, 'billing_state', $state );
                update_user_meta( $user_id, 'billing_country', $country );
                update_user_meta( $user_id, 'billing_email', $email );
                update_user_meta( $user_id, 'billing_postcode', $zip );
                update_user_meta( $user_id, 'billing_phone', $phone );

            //     /**
            //      * Membership Plan
            //      */
                // $args = array(
                //     'plan_id' => $plan_id,
                //     'user_id' => $user_id,
                // );
                // wc_memberships_create_user_membership( $args );
                // $user_membership = wc_memberships_get_user_membership($user_id, $args['plan_id']);
                // $user_membership->set_start_date($origin_date);
                // $user_membership->set_end_date($end_date);        

            } else {
                echo "we have an issue";
            }

            echo ' '.$first_name.' '.$middle_name.' '.$last_name.' '.$email.' '.$origin_email.'<br>';
        }
        fclose($gestor);
    }
}

add_action( 'genesis_after_header', 'update_member_loop' );
function update_member_loop() {
    echo 'This is a test for new users, thanks for visit us: <br>';
    /**
     * Read Users and Update
     */
    $count=0;
    $usuarios = get_users('orderby=id');
    // $usuarios = get_users();
    foreach ($usuarios as $usuario) {
        $user_id = $usuario->ID;
        $m_date = get_the_author_meta( 'origin_mdate', $user_id );
        $member_type = get_the_author_meta( 'origin_mtype', $user_id );
        if($member_type != ''){
            $count++;
                /**
                 * Format of Dates
                 */
                $dd = explode('/', $m_date);
                if($dd[0]<10)
                    $day = '0'.$dd[0];
                else
                    $day = $dd[0];
                
                if($dd[1]<10)
                    $month = '0'.$dd[1];
                else
                    $month = $dd[1];
                
                $year = '20'.$dd[2];

                $origin_date = $year.'-'.$month.'-'.$day;
                $end_date = '2019-'.$month.'-'.$day;

                /**
                 * Select Member Plan ID
                 */
                // switch ($member_type) {
                //     case 'Individual':
                //         $plan_id = 795;
                //         break;
                //     case 'Individual Canada':
                //         $plan_id = 795;
                //         break;
                //     case 'Family':
                //         $plan_id = 796;
                //         break;
                //     case 'Student':
                //         $plan_id = 797;
                //         break;
                //     case 'E-International':
                //         $plan_id = 797;
                //         break;
                //     case 'Lifetime':
                //         $plan_id = 798;
                //         break;
                //     case 'Life':
                //         $plan_id = 798;
                //         break;
                //     case 'Life Associate':
                //         $plan_id = 799;
                //         break;
                //     case 'Family Life':
                //         $plan_id = 799;
                //         break;
                //     case 'Overseas':
                //         $plan_id = 800;
                //         break;
                //     case 'Institution':
                //         $plan_id = 801;
                //         break;
                //     case 'Institution Canada':
                //         $plan_id = 801;
                //         break;
                // }

                /**
                 * Membership Plan
                 */
                // if($count > 0 && $count <= 10){

                    // $args = array(
                    //     'plan_id' => $plan_id,
                    //     'user_id' => $user_id,
                    // );
                    // wc_memberships_create_user_membership( $args );
                    // echo $count.' => ('.$plan_id.') '.$user_id.' '.$usuario->display_name.' '.$m_date.' '.$member_type . '<br>';   

                    // $user_membership = wc_memberships_get_user_membership($user_id, $plan_id);
                    // $user_membership->set_start_date($origin_date);
                    // $user_membership->set_end_date($end_date);  
                    
                    $user_membership = wc_memberships_get_user_memberships($user_id);
                    // print_r($user_membership[0]->id);echo '<br><br>';
                    echo "UPDATE wp_postmeta SET meta_value='".$origin_date." 00:00:00' WHERE post_id=".$user_membership[0]->id." AND meta_key='_start_date';<br>";
                    echo "UPDATE wp_postmeta SET meta_value='".$end_date." 00:00:00' WHERE post_id=".$user_membership[0]->id." AND meta_key='_end_date';<br>";
                // }   
        }
    }
}


genesis(); 