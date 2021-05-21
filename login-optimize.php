<?php
/**
 * Plugin Name:       CHAMPLAIN PHP - WP Utilities
 * Description:       Plugin with useful features such as custom login page as well as a combined cart and checkout page.
 * Version:           1.0.0
 * Author:            Tristan Giguere
 */

// Declare custom login code
function giguere_custom_login() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
        width:300px;
		background-size: 200px!important;
        background-repeat: no-repeat;
        }
		body {
			color: #ffffff!important;
			background-color:black!important;
			font-family: Europa!important;
			text-transform:uppercase!important;
			letter-spacing:1.5px!important;
        }
		#loginform{
			border:none;
			background-color:black;
		}
		#backtoblog{
			display:none;
		}
		.input{
			background-color:#FFDB27!important;
			border:none!important;
			color:black!important;
			margin-top:10px!important;
			border-radius:50px!important;
		}
		#wp-submit{
			background-color:#FFDB27;
			border:none;
			color:black;
			border-radius:50px;
		}
		#rememberme{
			border:none;
			border-radius:50px;
		}
		*:focus {
    	outline: none!important;
		}
		.dashicons{
			display:none!important;
		}
		
		@font-face {font-family: "Europa";
    	src: url("http://db.onlinewebfonts.com/t/23c0fcab84d99da0de762de7e220a6e1.woff") format("woff")}
    </style>
<?php }

// Register function for custom login code
add_action( 'login_enqueue_scripts', 'giguere_custom_login' );

// --------------------------------------------------------------------

// Define functions for WooCommerce same page checkout.

// Place Cart on Checkout Page.
function giguere_cart_on_checkout_only() {
 
	if ( is_wc_endpoint_url( 'order-received' ) ) return;
	 
	// Display cart table on checkout.
	echo do_shortcode('[woocommerce_cart]');
	 
	}
	
	// Redirect user to homepage is cart is empty.
	function giguere_redirect_if_cart_empty() {
	   if ( is_cart() && is_checkout() && 0 == WC()->cart->get_cart_contents_count() && ! is_wc_endpoint_url( 'order-pay' ) && ! is_wc_endpoint_url( 'order-received' ) )
	   {
		  wp_safe_redirect( home_url() );
		  exit;
	   }
	}
	
	// Redirect Cart to Checkout
	function giguere_change_cart_url_to_checkout() {
		return wc_get_checkout_url();
	 }
	
	// Register functions
	
	add_action( 'woocommerce_before_checkout_form', 'giguere_cart_on_checkout_only', 5 );
	
	add_action( 'template_redirect', 'giguere_redirect_if_cart_empty' );
	
	add_filter('woocommerce_get_cart_url', 'giguere_change_cart_url_to_checkout', 10, 1 );


// ---------------------------------------------------------------------------------------

// Add the custom menu page with documentation abut the plugin.

function giguere_docu_menu() {
	add_menu_page(
		__( 'WP Utilities', 'my-textdomain' ),
		__( 'WP Utilities Documentation', 'my-textdomain' ),
		'manage_options',
		'wp-utils-documentation',
		'giguere_docu_page_contents',
		'dashicons-info',
		3
	);
}

// Register the menu item
add_action( 'admin_menu', 'giguere_docu_menu' );


function giguere_docu_page_contents() {
	?>
		<h1>Thank you for using my plugin!</h1>
		<p>WP Utilities is a plugin that allows you to do two very demanded features with your WordPress & WooCommerce website.</p>
		<ol>
		<li><strong>Change the appearance of the WordPress Login Form - </strong>the default login form of WordPress is pretty boring. With this plugin, custom styling will be implemented so that your login page looks badass!</li>
		<li><strong>Regroup the cart and checkout sections on the same checkout page - </strong>it becomes pretty cumbersome for the customers on an online store when you have to navigate to different pages<br>from your cart to the checkout. Now, with the power of this plugin and WooCommerce, we can combine the cart on the checkout page, so that users are more enticed into finalizing the purchase,<br>since we are reducing the steps required to checkout!</li>
		</ol>
		<h5>Yours truly,</h5>
		<h3>Tristan Giguere :)</h3>
	<?php
}