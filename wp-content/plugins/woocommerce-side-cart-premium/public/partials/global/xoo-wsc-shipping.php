<?php


$packages = WC()->shipping()->get_packages();
$package = $packages[0];

$chosen_method = isset( WC()->session->chosen_shipping_methods[ 0 ] ) ? WC()->session->chosen_shipping_methods[ 0 ] : '';
$product_names = array();

if ( count( $packages ) > 1 ) {
	foreach ( $package['contents'] as $item_id => $values ) {
		$product_names[ $item_id ] = $values['data']->get_name() . ' &times;' . $values['quantity'];
	}
	$product_names = apply_filters( 'woocommerce_shipping_package_details_array', $product_names, $package );
}

$args = array(
	'package'                  => $package,
	'available_methods'        => $package['rates'],
	'show_package_details'     => count( $packages ) > 1,
	'show_shipping_calculator' => apply_filters( 'woocommerce_shipping_show_shipping_calculator', true, 0, $package ),
	'package_details'          => implode( ', ', $product_names ),
	/* translators: %d: shipping package number */
	'index'                    => 0,
	'chosen_method'            => $chosen_method,
	'formatted_destination'    => WC()->countries->get_formatted_address( $package['destination'], ', ' ),
	'has_calculated_shipping'  => WC()->customer->has_calculated_shipping(),
);

extract($args);


$formatted_destination    = isset( $formatted_destination ) ? $formatted_destination : WC()->countries->get_formatted_address( $package['destination'], ', ' );
$has_calculated_shipping  = ! empty( $has_calculated_shipping );
$show_shipping_calculator = ! empty( $show_shipping_calculator );
$calculator_text          = '';
$toggle_html 			  = false;	

?>

<span class="xoo-wsc-tools-value">
	<?php if( $available_methods ): ?>
		<a href="#" class="xoo-wsc-shp-tgle xoo-wsc-icon-pencil"></a>
		<?php echo WC()->cart->get_cart_shipping_total() ?>
	<?php else: ?>
		<a href="#" class="xoo-wsc-shp-tgle"><?php _e( 'Calculate', 'side-cart-woocommerce' ) ?></a>
	<?php endif; ?>
</span>

<div class="xoo-wsc-shptgl-cont">

	<?php if ( $available_methods ) : ?>

		<ul id="shipping_method" class="woocommerce-shipping-methods">
			<?php foreach ( $available_methods as $method ) : ?>
				<li>
					<?php
					if ( 1 < count( $available_methods ) ) {
						printf( '<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" %4$s />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ) ); // WPCS: XSS ok.
					} else {
						printf( '<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ) ); // WPCS: XSS ok.
					}
					printf( '<label for="shipping_method_%1$s_%2$s">%3$s</label>', $index, esc_attr( sanitize_title( $method->id ) ), wc_cart_totals_shipping_method_label( $method ) ); // WPCS: XSS ok.
					do_action( 'woocommerce_after_shipping_rate', $method, $index );
					?>
				</li>
			<?php endforeach; ?>
		</ul>

		<?php
		if ( $formatted_destination ) {
			$toggle_html .=  sprintf( esc_html__( 'Shipping to %s.', 'woocommerce' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' );
			$calculator_text = esc_html__( 'Change address', 'woocommerce' );
		} else {
			$toggle_html .= wp_kses_post( apply_filters( 'woocommerce_shipping_estimate_html', __( 'Shipping options will be updated during checkout.', 'woocommerce' ) ) );
		}
		?>

	<?php else: ?>

		<?php

		if ( ! $has_calculated_shipping || ! $formatted_destination ) :
			if ( 'no' === get_option( 'woocommerce_enable_shipping_calc' ) ) {
				$toggle_html .= wp_kses_post( apply_filters( 'woocommerce_shipping_not_enabled_on_cart_html', __( 'Shipping costs are calculated during checkout.', 'woocommerce' ) ) );
			} else {
				$toggle_html .= wp_kses_post( apply_filters( 'woocommerce_shipping_may_be_available_html', __( 'Enter your address to view shipping options.', 'woocommerce' ) ) );
			}
		else :
			// Translators: $s shipping destination.
			$toggle_html .= wp_kses_post( apply_filters( 'woocommerce_cart_no_shipping_available_html', sprintf( esc_html__( 'No shipping options were found for %s.', 'woocommerce' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' ) ) );
			$calculator_text = esc_html__( 'Enter a different address', 'woocommerce' );
		endif;

		?>

	<?php endif; ?>


	<?php if ( $show_shipping_calculator ) : ?>
		<?php 
		ob_start();
		woocommerce_shipping_calculator( $calculator_text );
		$toggle_html .= ob_get_clean();
		?>
	<?php endif; ?>

	<?php echo $toggle_html; ?>

</div>