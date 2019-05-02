<?php
/*
Plugin Name:    Subscriptions
Plugin URI:     xxx
Description:    A plugin to run the subscription system for xxx
Author:         xxx
Author URI:     xxx
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

function sub_my_custom_status_creation(){
        register_post_status( 'won', array(
            'label'                     => _x( 'Won', 'post' ),
            'label_count'               => _n_noop( 'Won <span class="count">(%s)</span>', 'Won <span class="count">(%s)</span>'),
            'public'                    => false,
            'protected'                 => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => false,
            'show_in_admin_status_list' => true
        ));
    }
    add_action( 'init', 'sub_my_custom_status_creation' );

    function sub_my_custom_status_add_in_quick_edit() {
      $screen = get_current_screen();
      if( $screen->post_type == 'subscription' ) {
        echo "<script>
        jQuery(document).ready( function() {
            jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"won\">Won</option>' );      
        }); 
        </script>";}
    }
    add_action('admin_footer-edit.php','sub_my_custom_status_add_in_quick_edit');
    function sub_my_custom_status_add_in_post_page() {
      $screen = get_current_screen();
      if( $screen->post_type == 'subscription' ) {
        echo "<script>
        jQuery(document).ready( function() {        
            jQuery( 'select[name=\"post_status\"]' ).append( '<option value=\"won\">Won</option>' );
        });
        </script>";}
    }
    add_action('admin_footer-post.php', 'sub_my_custom_status_add_in_post_page');
    add_action('admin_footer-post-new.php', 'sub_my_custom_status_add_in_post_page');

function sub_my_custom_status_creation_lost(){
        register_post_status( 'lost', array(
            'label'                     => _x( 'Lost', 'post' ),
            'label_count'               => _n_noop( 'Lost <span class="count">(%s)</span>', 'Lost <span class="count">(%s)</span>'),
            'public'                    => false,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => false,
            'show_in_admin_status_list' => true
        ));
    }
    add_action( 'init', 'sub_my_custom_status_creation_lost' );

    function sub_my_custom_status_add_in_quick_edit_lost() {
      $screen = get_current_screen();
      if( $screen->post_type == 'subscription' ) {
        echo "<script>
        jQuery(document).ready( function() {
            jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"lost\">Lost</option>' );      
        }); 
        </script>";}
    }
    add_action('admin_footer-edit.php','sub_my_custom_status_add_in_quick_edit_lost');
    function sub_my_custom_status_add_in_post_page_lost() {
      $screen = get_current_screen();
      if( $screen->post_type == 'subscription' ) {
        echo "<script>
        jQuery(document).ready( function() {        
            jQuery( 'select[name=\"post_status\"]' ).append( '<option value=\"lost\">Lost</option>' );
        });
        </script>";}
    }
    add_action('admin_footer-post.php', 'sub_my_custom_status_add_in_post_page_lost');
    add_action('admin_footer-post-new.php', 'sub_my_custom_status_add_in_post_page_lost');

// add_filter( 'gform_field_value', 'populate_fields_subscrip', 10, 3 );
// function populate_fields_subscrip( $value, $field, $name ) {

//     $subscrip_customer_information = get_field('subscrip_customer_information');
//     $subscrip_semi_custom_development = get_field('subscrip_semi_custom_development');
//     $subscrip_company_address = $subscrip_customer_information['company_address'];
//     $subscrip_monthly_total = $subscrip_semi_custom_development['subscrip_semi_price'] + $subscrip_semi_custom_development['subscrip_semi_content_price'] + $subscrip_semi_custom_development['subscrip_social_brand_price'] + $subscrip_semi_custom_development['subscrip_social_media_price'];

//     $values = array(
//         'subscrip_company_name' => $subscrip_customer_information['company_name'],
//         'subscrip_first_name' => $subscrip_customer_information['contact_first_name'],
//         'subscrip_last_name' => $subscrip_customer_information['contact_last_name'],
//         'subscrip_company_phone' => $subscrip_customer_information['company_phone'], 
//         'subscrip_domain_ownership' => $subscrip_semi_custom_development['domain_name'],
//         'subscrip_contact_email' => $subscrip_customer_information['contact_email'],
//         'subscrip_street_address' => $subscrip_company_address['street_address'],
//         'subscrip_address_line_2' => $subscrip_company_address['address_line_2'],
//         'subscrip_city' => $subscrip_company_address['city'],
//         'subscrip_state' => $subscrip_company_address['state'],
//         'subscrip_zip' => $subscrip_company_address['zip'],
//         'subscrip_country' => $subscrip_company_address['country'],
//         'subscrip_start_date' => get_field('subscrip_start_date'),
//         'subscrip_monthly' => $subscrip_monthly_total,
//         'subscrip_down_payment_total' => get_field('subscrip_down_payment')


//     );

//     return isset( $values[ $name ] ) ? $values[ $name ] : $value;
// }

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
 
    // get the amount from field and convert it to the smallest unit required by Stripe for the currency being used.
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


