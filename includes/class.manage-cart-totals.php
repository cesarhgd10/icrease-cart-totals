<?php


/**
* 
*/
class ManageCartTotals {
	
	private $amount;

	function __construct() {

		// Default amount
		$this->amount = 10;

		// Events
		// add_action( 'woocommerce_calculate_totals', array( $this, 'ict_add_amount_to_cart_total' ), 10, 1 );
		// add_action( 'woocommerce_after_cart_item_quantity_update', 'limit_cart_item_quantity', 20, 4 );
		// add_action( 'woocommerce_before_cart_item_quantity_zero', 'action_before_cart_item_quantity_zero', 20, 4 );
		

		// Remove amount
		// add_action( 'action_woocommerce_cart_item_removed', array( $this, 'ict_remove_amount_to_cart_total' ), 10, 2 ); 

		add_action( 'woocommerce_cart_calculate_fees', array( $this, 'teste_fee' ) ); 

	}

	public function ict_add_amount_to_cart_total( $cart ) {
		$product_id = '';

		// error_log(WC()->cart->cart_contents_total);
		
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) { // Check if product is being added into cart with AJAX
			$product_id = isset( $_POST['product_id'] ) ? $_POST['product_id'] : false;
		} elseif( isset( $_GET['add-to-cart'] ) ) { // Check if is being added troguth $_GET
			$product_id = $_GET['add-to-cart'];
		} 

		// Check if is a product id
		if ( $product_id ) {
			$_product = wc_get_product( $product_id );

			if ( $_product && $this->will_increase_total( $_product->get_id() ) == 'yes' ) {
				$_amount = $this->get_product_amount( $_product->get_id() );

				$cart_total = WC()->cart->cart_contents_total;

				// error_log('cart_total');
				// error_log($cart_total);

				$cart_total += floatval( $cart_total * ($_amount/100) );
			
				error_log($cart_total);
				$cart->set_cart_contents_total( $cart_total );
				$cart->set_subtotal( $cart_total );
				$cart->subtotal = $cart_total;
				$cart->total = $cart_total;
			}
		} else {
			return;
		}
	}


	public function ict_remove_amount_to_cart_total( $cart_item_key, $cart ) {
		// error_log('message');
		// error_log($cart->cart_contents_total);
	}


	// Alternative functions

	public function teste_fee ( $cart ) {
		write_log('request');
		write_log($_REQUEST);
		// write_log('fee');
		// write_log($fees);

		// Check if we're adding
		// $items = $cart->cart_contents;

		// write_log($items);

	}

	private function will_increase_total( $product_id ) {
		$will_increase = get_post_meta( $product_id, '_ict_is_active', true );

		return ( $will_increase ) ? $will_increase : false;
	}

	private function get_product_amount( $product_id ) {
		$amount = $this->format_product_amount( get_post_meta( $product_id, '_ict_product_amount', true ) );

		return ( $amount ) ? $amount : $this->amount;
	}

	public function format_product_amount( $amount ) {
		if ( ! is_int( $amount ) ) {
			$amount =  floatval( preg_replace('/[^0-9]/', '', $amount) );
		}

		return $amount;
	}
}

new ManageCartTotals();