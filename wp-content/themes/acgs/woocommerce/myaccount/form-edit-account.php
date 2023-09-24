<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_edit_account_form' ); ?>

<div class="custom-content-account">
	<ul class="my-account-tabs desktop-show">
		<li><a href="<?php echo get_site_url();?>/my-account/" class="active">MY PROFILE</a></li>
		<li><a href="<?php echo get_site_url();?>/my-account/subscription/">MY SUBSCRIPTION</a>
			<li><a href="<?php echo get_site_url();?>/my-account/orders/">MY ORDERS</a>
	</ul>
	<div class="my-tabs mobile-show">
		<div class="current-tab">MY PROFILE</div>
		<div class="dropdown-tabs">
			<div><a href="<?php echo get_site_url();?>/my-account/" class="active">MY PROFILE</a></div>
			<div><a href="<?php echo get_site_url();?>/my-account/subscription/">MY SUBSCRIPTION</a></div>
			<div><a href="<?php echo get_site_url();?>/my-account/orders/">MY ORDERS</a></div>
		</div>
	</div>
</div>

<div id="my-profile-content" class="my-ac-tab active top-m">
	<form class="woocommerce-EditAccountForm edit-account custom-edit-account" action="" method="post">

		<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

		<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first" style="display:none;">
			<label for="account_first_name"><?php _e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last" style="display:none;">
			<label for="account_last_name"><?php _e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" />
		</p>
		<div class="clear"></div>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide" style="display:none;">
			<label for="account_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>" />
		</p>

		<p></p>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" /> <span><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em></span>
		</p>
		<div class="clear"></div>

		<fieldset>
			<legend><?php _e( 'Password change', 'woocommerce' ); ?></legend>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password_current"><?php _e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" />
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password_1"><?php _e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" />
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password_2"><?php _e( 'Confirm new password', 'woocommerce' ); ?></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" />
			</p>
		</fieldset>
		<div class="clear"></div>

		<p></p>

		<?php do_action( 'woocommerce_edit_account_form' ); ?>

		<p>
			<?php wp_nonce_field( 'save_account_details' ); ?>
			<input type="submit" class="woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e( 'Save Changes', 'woocommerce' ); ?>" />
			<input type="hidden" name="action" value="save_account_details" />
		</p>
		<p>&nbsp;</p>

		<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
	</form>
</div>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
