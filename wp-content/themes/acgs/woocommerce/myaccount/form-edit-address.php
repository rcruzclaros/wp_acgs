<?php
/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
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
 * @version 3.0.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$page_title = ( 'billing' === $load_address ) ? __( 'Billing address', 'woocommerce' ) : __( 'Shipping address', 'woocommerce' );

do_action( 'woocommerce_before_edit_account_address_form' ); ?>

<?php if ( ! $load_address ) : ?>
	<?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php else : ?>
<div class="custom-content-account">
	<ul class="my-account-tabs desktop-show">
		<li><a href="<?php echo get_site_url();?>/my-account/" class="active">MY PROFILE</a></li>
		<li><a href="<?php echo get_site_url();?>/my-account/subscription/">MY SUBSCRIPTION</a></li>
		<li><a href="<?php echo get_site_url();?>/my-account/orders/">MY ORDERS</a></li>
	</ul>
	<div class="my-tabs mobile-show">
		<div class="current-tab">MY ADDRESS</div>
		<div class="dropdown-tabs">
			<div><a href="<?php echo get_site_url();?>/my-account/" class="active">MY PROFILE</a></div>
			<div><a href="<?php echo get_site_url();?>/my-account/subscription/">MY SUBSCRIPTION</a></div>
			<div><a href="<?php echo get_site_url();?>/my-account/orders/">MY ORDERS</a></div>
		</div>
	</div>
</div>

<div id="my-profile-content" class="my-ac-tab active top-m">
	<form method="post">

		<h3>Edit Profile</h3>

		<div class="woocommerce-address-fields">
			<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>

			<div class="woocommerce-address-fields__field-wrapper">
				<?php
					foreach ( $address as $key => $field ) {
						if ( isset( $field['country_field'], $address[ $field['country_field'] ] ) ) {
							$field['country'] = wc_get_post_data_by_key( $field['country_field'], $address[ $field['country_field'] ]['value'] );
						}
						woocommerce_form_field( $key, $field, wc_get_post_data_by_key( $key, $field['value'] ) );
					}
				?>
			</div>

			<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>

			<p>
				<input type="submit" class="button" name="save_address" value="<?php esc_attr_e( 'Save address', 'woocommerce' ); ?>" />
				<?php wp_nonce_field( 'woocommerce-edit_address' ); ?>
				<input type="hidden" name="action" value="edit_address" />
			</p>
		</div>

	</form>
</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>
