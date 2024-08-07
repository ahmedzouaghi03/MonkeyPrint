<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!class_exists('FPD_Debug')) {

	class FPD_Debug {

		private $required_filters = array(
			'woocommerce_cart_item_thumbnail' => false //custom cart item thumbnail
		);
		private $required_hooks = array(
			'woocommerce_before_single_product_summary' => false, //adding product designer
			'woocommerce_single_product_summary' => false, //add customize button
			'woocommerce_before_add_to_cart_button' => false, //add additional form fields
			'woocommerce_after_single_product_summary' => false,
			'woocommerce_share' => false
		);

		public function __construct() {

			foreach($this->required_filters as $key => $value) {

				add_filter($key, array(&$this, 'check_filter'));

			}

			foreach($this->required_hooks as $key => $value) {

				add_action($key, array(&$this, 'check_wc_hook'));

			}

			add_action( 'wp_footer', array(&$this, 'add_theme_check_modal') );

		}

		public function check_wc_hook() {

			$this->required_hooks[current_filter()] = true;

		}

		public function check_filter($return) {

			$this->required_filters[current_filter()] = true;

			return $return;

		}

		public function add_theme_check_modal() {

			global $post;
			$wc_active = function_exists( 'get_woocommerce_currency' );

			if( is_fancy_product($post->ID) || (function_exists('is_cart') && is_cart()) ) {

				?>
				<div class="fpd-theme-check-wrapper">
					<div class="fpd-theme-check-content">
						<h4><?php _e('Theme Check', 'radykal'); ?><span>&#10005;</span></h4>
						<?php

						if( (function_exists('is_cart') && !is_cart()) && get_post_type($post->ID) === 'product' ) {
							foreach($this->required_hooks as $key => $value) {

								$success_log = __(' hook was found.', 'radykal');
								$error_log = __(' hook is missing in the woocommerce templates of your theme. <a href="https://support.fancyproductdesigner.com/support/solutions/articles/5000582912-using-the-debug-mode-to-inspect-any-missing-hooks-in-woocommerce-product-pages" target="_blank">Help me fixing it</a>.', 'radykal');

								if($value) {
									echo '<p class="fpd-success"><strong>'.$key.'</strong>'.$success_log;
								}
								else {

									if($key == 'woocommerce_single_product_summary') {
										echo '<p class="fpd-warning"><strong>'.$key.'</strong>'.$error_log;
									}
									else {
										echo '<p class="fpd-error"><strong>'.$key.'</strong>'.$error_log;
									}

								}
							}
						}

						foreach($this->required_filters as $key => $value) {

							$success_log = __(' filter was found.', 'radykal');
							$error_log = __(' filter is missing in the woocommerce templates of your theme. <a href="https://support.fancyproductdesigner.com/support/solutions/articles/5000582912-using-the-debug-mode-to-inspect-any-missing-hooks-in-woocommerce-product-pages" target="_blank">Help me fixing it</a>.', 'radykal');

							if($key == 'woocommerce_cart_item_thumbnail' && (function_exists('is_cart') && !is_cart()))
								continue;

							if($value) {
								echo '<p class="fpd-success"><strong>'.$key.'</strong>'.$success_log;
							}
							else {

								if($key == 'woocommerce_single_product_summary') {
									echo '<p class="fpd-warning"><strong>'.$key.'</strong>'.$error_log;
								}
								else {
									echo '<p class="fpd-error"><strong>'.$key.'</strong>'.$error_log;
								}

							}
						}

						?>
						<p>
							<?php _e('If a hook or filter is missing in your theme, you can <a href="http://support.fancyproductdesigner.com/support/solutions/articles/5000582912-using-the-debug-mode-to-inspect-any-missing-hooks-in-woocommerce-product-pages">try fo fix it by yourself</a>.', 'radykal'); ?>
						</p>
					</div>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery('.fpd-theme-check-content h4 span').click(function() {
							jQuery(this).parents('.fpd-theme-check-wrapper').fadeOut(300);
						});
					});
				</script>
				<?php

			}
		}

	}

}

if( fpd_convert_string_value_to_int( get_option('fpd_debug_mode') ) && current_user_can('manage_options') ) {
	new FPD_Debug();
}

?>