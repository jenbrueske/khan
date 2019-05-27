<?php
/*
Plugin Name:    Subscriptions
Plugin URI:     xxx
Description:    A plugin to run the subscription system for xxx
Author:         Jennifer Brueske
Author URI:     https://jenniferbrueske.com
License:        GPL2
License URI:    https://www.gnu.org/licenses/gpl-2.0.html
Version:        1.0
*/

function iceberg_register_cpts_subscription() {

    /**
     * Post Type: Subscriptions.
     */

    $labels = array(
        "name" => __( "Subscriptions", "iceberg-subscriptions" ),
        "singular_name" => __( "Subscription", "iceberg-subscriptions" ),
    );

    $args = array(
        "label" => __( "Subscriptions", "iceberg-subscriptions" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => false,
        "rest_base" => "",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "subscription", "with_front" => true ),
        "query_var" => true,
        "menu_icon" => "dashicons-backup",
        "supports" => array( "title", "thumbnail", "author" ),
    );

    register_post_type( "subscription", $args );
}

add_action( 'init', 'iceberg_register_cpts_subscription' );

if( function_exists('acf_add_options_page') ) {
    
        acf_add_options_page(array(
        'page_title'    => 'Subscription Settings',
        'menu_title'    => 'Subscription Settings',
        'menu_slug'     => 'subscription-settings',
        'capability'    => 'activate_plugins',
        'redirect'      => false
    ));
    
}


// Change parameters before sending to stripe
add_filter( 'gform_stripe_subscription_params_pre_update_customer', 'change_details', 10, 7 );
function change_details( $subscription_params, $customer, $plan, $feed, $entry, $form ){
    $subscription_params ['trial_end'] = rgar( $entry, '218');
    $subscription_params ['prorate'] = false;
    return $subscription_params;
}

// Add invoice item of down payment before charging first invoice and starting free trial
add_action( 'gform_stripe_customer_after_create', 'add_invoice_item', 10, 4 );
function add_invoice_item( $customer, $feed, $entry, $form ) {
 
    $feed_name = rgars( $feed, 'meta/feedName' );
 
    if ( $feed_name != 'Monthly Subscription' ) { // Update this line to your feed name
        return;
    }
 
    // get the currency code for this entry.
    $currency = rgar( $entry, 'currency' );    
 
    // get the amount from field 5 and convert it to the smallest unit required by Stripe for the currency being used.
    $amount = gf_stripe()->get_amount_export( rgar( $entry, '217.2' ), $currency ); // Update 5 to your field id
 
    $item = array(
        'amount'      => $amount,
        'currency'    => $currency,
        'description' => 'Down Payment', // Update this to put your description for the charge
    );
 
    gf_stripe()->log_debug( 'gform_stripe_customer_after_create: Invoice item to be added => ' . print_r( $item, 1 ) );
 
    $result = $customer->addInvoiceItem( $item );
 
    gf_stripe()->log_debug( 'gform_stripe_customer_after_create: Result => ' . print_r( $result, 1 ) );
 
}

// set single template
function load_subscrip_template($template) {
    global $post;

    if ($post->post_type == "subscription" && $template !== locate_template(array("single-subscription.php"))){
        /* This is a "subscription" post 
         * AND a 'single subscription template' is not found on 
         * theme or child theme directories, so load it 
         * from our plugin directory
         */
        return plugin_dir_path( __FILE__ ) . "single-subscription.php";
    }

    return $template;
}

add_filter('single_template', 'load_subscrip_template');

add_filter( 'gpro_disable_datepicker', '__return_true' );