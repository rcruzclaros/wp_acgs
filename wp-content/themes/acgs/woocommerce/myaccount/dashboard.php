<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/*$args = array(
    'status' => 'active'
);*/
//$args = array( 'status' => array( 'active' ));
//$user_membership = wc_memberships_get_user_membership( get_current_user_id(),$args );
/*foreach($user_membership as $plan){
    echo $plan->plan_id;
}*/
$active = '';
$plan_id = '';
if (wc_memberships_is_user_member()) {	
	$user_membership = wc_memberships_get_user_membership(get_current_user_id());
	$memberships = wc_memberships_get_user_memberships();
	if ($memberships) {
		foreach( $memberships as $membership ) {
		    //echo $membership->get_id();
		    //echo $membership->get_end_date();
		    $plan_id = $membership->get_plan_id();
		    //echo get_the_title($membership->get_plan_id());
		    $active = wc_memberships_is_user_active_member( get_current_user_id(), $membership->get_plan_id() );
		}
	}
}else{
}

if($active){
	?>
	<div class="custom-content-account">
		<ul class="my-account-tabs desktop-show">
			<li><a href="<?php echo get_site_url();?>/my-account/" class="active">MY PROFILE</a></li>
			<li><a href="<?php echo get_site_url();?>/my-account/subscription/">MY SUBSCRIPTION</a></li>
			<li><a href="<?php echo get_site_url();?>/my-account/orders/">MY ORDERS</a></li>
		</ul>
		<div class="my-tabs mobile-show">
			<div class="current-tab">MY PROFILE</div>
			<div class="dropdown-tabs">
				<div><a href="<?php echo get_site_url();?>/my-account/" class="active">MY PROFILE</a></div>
				<div><a href="<?php echo get_site_url();?>/my-account/subscription/">MY SUBSCRIPTION</a></div>
				<div><a href="<?php echo get_site_url();?>/my-account/orders/">MY ORDERS</a></div>
			</div>
		</div>
		<div class="my-account-content-t" style="clear:both;">
			<div id="my-profile-content" class="my-ac-tab active top-m my-account-acgs-content">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h2>Member Information</h2>
							<hr>
						</div>
					</div>
					
					<!--<div class="row smb">
						<div class="one-half first">Payment info</div>
						<div class="one-half text-right"><a href="payment-methods/">Update payment info</a></div>
					</div>-->
				</div>
				<!--<div class="container secured-by">
					<div class="row">
						<div class="col-md-10">
							<p><strong>Secured By</strong><br>All funds secured by this bank and processed by lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua quis nostrud exercitation.</p>
						</div>
					</div>
				</div>-->
				<div class="container last-c">
					<?php
					if ($current_user->user_firstname) {
						?>
						<table class="tbl-dashboard-info">
							<tr>
								<th>Full Name:</th>
								<td width="80%"><?php echo $current_user->user_firstname.' '.$current_user->user_lastname; ?></td>
							</tr>
							<tr>
								<th>Email:</th>
								<td><?php echo $current_user->user_email; ?></td>
							</tr>
							<tr>
								<th>Address:</th>
								<td><?php echo get_user_meta( $current_user->id, 'billing_address_1', true ); ?></td>
							</tr>
							<tr>
								<th>Country:</th>
								<td><?php echo get_user_meta( $current_user->id, 'billing_country', true ); ?></td>
							</tr>
							<tr>
								<th>City:</th>
								<td><?php echo get_user_meta( $current_user->id, 'billing_city', true ); ?></td>
							</tr>
							<tr>
								<th>State / Province:</th>
								<td><?php echo get_user_meta( $current_user->id, 'billing_state', true ); ?></td>
							</tr>
							<tr>
								<th>Zip/Postal Code:</th>
								<td><?php echo get_user_meta( $current_user->id, 'billing_postcode', true ); ?></td>
							</tr>
							<tr>
								<th>Address Line 2:</th>
								<td><?php echo get_user_meta( $current_user->id, 'billing_address_2', true ); ?></td>
							</tr>
							<tr>
								<th>Home Phone:</th>
								<td><?php echo get_user_meta( $current_user->id, 'billing_phone', true ); ?></td>
							</tr>
							<tr>
								<th>Password</th>
								<td><a href="edit-account">Change Password</a></td>
							</tr>
						</table>
						<a href="edit-address/billing/" class="green-btn-acgs">Edit My Profile</a>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}else{
	?>
	<div class="custom-content-account">
        <ul class="my-account-tabs desktop-show">
            <li><a class="active">MY SUBSCRIPTION</a></li>
        </ul>
        <div class="my-tabs mobile-show">
            <div class="current-tab">MY SUBSCRIPTION</div>
            <div class="dropdown-tabs">
                <div><a href="<?php echo get_site_url();?>/my-account/">MY PROFILE</a></div>
                <div><a href="<?php echo get_site_url();?>/my-account/subscription/" class="active">MY SUBSCRIPTION</a></div>
                <div><a href="<?php echo get_site_url();?>/my-account/orders/">MY ORDERS</a></div>
            </div>
        </div>
        <div class="my-account-content-t" style="clear:both;">
        <div id="my-profile-content" class="my-ac-tab active top-m my-subscription-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12"><h2>My Subscription</h2><hr></div>
                </div>
                <table class="tbl-dashboard-info">
                    <?php
                    $memberships = wc_memberships_get_user_memberships();
					if ($memberships) {
						foreach( $memberships as $membership ) {
						    //echo $membership->get_id();
						    //echo $membership->get_end_date();
						    $plan_id = $membership->get_plan_id();
						    //echo get_the_title($membership->get_plan_id());
						    echo '<tr><th>Membership type:</th><td>'.get_the_title($plan_id).'</td></tr>';
						}
					}
                    ?>
                    <tr>
                        <th>Member since:</th>
                        <td width="75%">
                            <?php
                            $memberships = wc_memberships_get_user_memberships();
							if ($memberships) {
								foreach( $memberships as $membership ) {
								    //echo $membership->get_id();
								    //echo $membership->get_end_date();
								    $plan_id = $membership->get_plan_id();
								    //echo get_the_title($membership->get_plan_id());
								    echo date("d/m/Y", strtotime($membership->get_start_date()));
								}
							}
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Membership expires:</th>
                        <td >
                            <?php
                            $memberships = wc_memberships_get_user_memberships();
							if ($memberships) {
								foreach( $memberships as $membership ) {
								    //echo $membership->get_id();
								    //echo $membership->get_end_date();
								    $plan_id = $membership->get_plan_id();
								    //echo get_the_title($membership->get_plan_id());
								    echo '<span class="expire-membership">'.date("d/m/Y", strtotime($membership->get_end_date())).'</span>';
								}
							}
                            ?>
                        </td>
                    </tr>
                </table>
                <div>
                	<?php
                	$memberships = wc_memberships_get_user_memberships();
					if ($memberships) {
						foreach( $memberships as $membership ) {
						    //echo $membership->get_id();
						    //echo $membership->get_end_date();
						    $plan_id = $membership->get_plan_id();
						    //echo get_the_title($membership->get_plan_id());
						    if ($plan_id == '795') {
						    	?>
						    	<a href="<?php echo get_site_url() ?>/membership-individual/" class="green-btn-acgs">RENEW MY SUBSCRIPTION</a>
						    	<?php
						    }
						    if ($plan_id == '796') {
						    	?>
						    	<a href="<?php echo get_site_url() ?>/family/" class="green-btn-acgs">RENEW MY SUBSCRIPTION</a>
						    	<?php
						    }
						    if ($plan_id == '797') {
						    	
						    }
						    if ($plan_id == '798') {
						    	?>
						    	<a href="<?php echo get_site_url() ?>/member-lifetime/" class="green-btn-acgs">RENEW MY SUBSCRIPTION</a>
						    	<?php
						    }
						    if ($plan_id == '799') {
						    	?>
						    	<a href="<?php echo get_site_url() ?>/member-life-associate/" class="green-btn-acgs">RENEW MY SUBSCRIPTION</a>
						    	<?php
						    }
						    if ($plan_id == '800') {
						    	?>
						    	<a href="<?php echo get_site_url() ?>/membership-overseas/" class="green-btn-acgs">RENEW MY SUBSCRIPTION</a>
						    	<?php
						    }
						    if ($plan_id == '801') {
						    	?>
						    	<a href="<?php echo get_site_url() ?>/membership-institutions/" class="green-btn-acgs">RENEW MY SUBSCRIPTION</a>
						    	<?php
						    }
						    if ($plan_id == '7414') {
						    	?>
						    	<a href="<?php echo get_site_url() ?>/member-e-international/" class="green-btn-acgs">RENEW MY SUBSCRIPTION</a>
						    	<?php
						    }
						}
					}
                	?>                    
                </div>
            </div>
        </div>      
    </div>
	<?php
}

//echo date("d/m/Y", strtotime($user_membership->get_end_date()));

?>

<!--<p><?php
	printf(
		__( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a> and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' ),
		esc_url( wc_get_endpoint_url( 'orders' ) ),
		esc_url( wc_get_endpoint_url( 'edit-address' ) ),
		esc_url( wc_get_endpoint_url( 'edit-account' ) )
	);
?></p>-->

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
