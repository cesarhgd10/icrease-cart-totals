<?php

// First Register the Tab by hooking into the 'woocommerce_product_data_tabs' filter
function ict_product_data_tab( $product_data_tabs ) {
  $product_data_tabs['ict_tab'] = array(
    'label'  => __( 'Increase Cart Totals', 'increase-cart-totals' ),
    'target' => 'ict_product_data',
    'class'  => array( 'show_if_simple' ),
  );

  return $product_data_tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'ict_product_data_tab' );


/** CSS To Add Custom tab Icon */
function wcpp_custom_style() {?>
<style>
#woocommerce-product-data ul.wc-tabs li.ict_tab_options a:before { font-family: WooCommerce; content: '\e01d'; }
</style>
<?php 
}
add_action( 'admin_head', 'wcpp_custom_style' );


function woocom_custom_product_data_fields() {
  global $post;

  // Note the 'id' attribute needs to match the 'target' parameter set above
  ?> <div id = 'ict_product_data'
  class = 'panel woocommerce_options_panel' > <?php
      ?> <div class = 'options_group' > <?php

  $is_active = get_post_meta( $post->ID, '_checkbox', true );  


	woocommerce_wp_checkbox(
	  array(
	    'id' => '_ict_is_active',
	    'label' => __('Activate', 'increase-cart-totals' ),
	    'description' => __( 'This product will increase the cart totals?', 'increase-cart-totals' )
	  )
  );

  $amount = get_post_meta( $post->ID, '_text_field', true );

  error_log($amount);


  woocommerce_wp_text_input(
    array(
      'id' => '_ict_product_amount',
      'label' => __( 'Amount', 'increase-cart-totals' ),
      'wrapper_class' => 'show_if_simple',
      'placeholder' => '10%',
      'desc_tip' => 'true',
      'description' => __( 'Enter the amount in percentage, the default value is 10%.', 'increase-cart-totals' ),
    )
  );

 
  ?> </div>

  </div><?php
}
// functions you can call to output text boxes, select boxes, etc.
add_action('woocommerce_product_data_panels', 'woocom_custom_product_data_fields');


/** Hook callback function to save custom fields information */
function woocom_save_proddata_custom_fields( $post_id ) {
 	// Save Checkbox
  $checkbox = isset($_POST['_ict_is_active']) ? 'yes' : 'no';
  update_post_meta($post_id, '_ict_is_active', $checkbox);

  // Save Text Field
  $text_field = $_POST['_ict_product_amount'];
  if (!empty($text_field)) {
    update_post_meta($post_id, '_ict_product_amount', esc_attr($text_field));
  }
}
add_action( 'woocommerce_process_product_meta_simple', 'woocom_save_proddata_custom_fields'  );

// You can uncomment the following line if you wish to use those fields for "Variable Product Type"
//add_action( 'woocommerce_process_product_meta_variable', 'woocom_save_proddata_custom_fields'  );