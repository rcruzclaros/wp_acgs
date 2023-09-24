<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
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
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices(); ?>
<div class="fp-container">
	<form method="post" class="woocommerce-ResetPassword lost_reset_password">
		<p>&nbsp;</p>
		<h3><?php echo apply_filters( 'woocommerce_lost_password_message', __( 'Forgot Password?', 'woocommerce' ) ); ?></h3>
		<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first" style="width:100%;">
			<input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" placeholder="Username or email" />
		</p>

		<div class="clear" style="margin-bottom:20px;"></div>

		<?php do_action( 'woocommerce_lostpassword_form' ); ?>

		<p class="woocommerce-form-row form-row">
			<input type="hidden" name="wc_reset_password" value="true" />
			<input type="submit" class="woocommerce-Button button" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>" />
		</p>

		<?php wp_nonce_field( 'lost_password' ); ?>

	</form>
</div>
<script type="text/javascript">
	document.getElementById("login-head").innerHTML = "Forgot Password";
</script>