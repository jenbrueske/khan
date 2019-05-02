<?php
/**
 * The template for displaying all single posts and attachments
 */


if ( $overridden_template = locate_template( 'header-subscription.php' ) ) {
    /*
     * locate_template() returns path to file.
     * if either the child theme or the parent theme have overridden the template.
     */
    load_template( $overridden_template );
} else {
    /*
     * If neither the child nor parent theme have overridden the template,
     * we load the template from the 'templates' sub-directory of the directory this file is in.
     */
    load_template( dirname( __FILE__ ) . '/header-subscription.php' );
}
	
	// print header title
	if( get_post_type() == 'post' ){
		get_template_part('header/header', 'title-blog');
	}

        $subscrip_maintenance = get_field('subscrip_maintenance_mode', 'option');
        $subscrip_maintenance_mode_settings = get_field('subscrip_maintenance_mode_settings', option);
        $background_image = $subscrip_maintenance_mode_settings['subscrip_maintenance_background_image'];
    

        if( !is_user_logged_in() && true == $subscrip_maintenance ){ 

            ?>


            <div class="iceberg-maintenance" style="background-image: url(<?php echo $background_image['url']; ?>); background-size: cover; height: 800px;"> 

                <div class="iceberg-maintenance-content" style="padding-top: 350px;">

                    <?php echo $subscrip_maintenance_mode_settings['subscrip_maintenance_content']; ?>

                </div>
            


            </div>

               

            
            <?php
        }else{

	while( have_posts() ){ the_post();

		$post_option = iceberg_get_post_option(get_the_ID());

		if( empty($post_option['sidebar']) || $post_option['sidebar'] == 'default' ){
			$sidebar_type = iceberg_get_option('general', 'blog-sidebar', 'none');
			$sidebar_left = iceberg_get_option('general', 'blog-sidebar-left');
			$sidebar_right = iceberg_get_option('general', 'blog-sidebar-right');
		}else{
			$sidebar_type = empty($post_option['sidebar'])? 'none': $post_option['sidebar'];
			$sidebar_left = empty($post_option['sidebar-left'])? '': $post_option['sidebar-left'];
			$sidebar_right = empty($post_option['sidebar-right'])? '': $post_option['sidebar-right'];
		}

		echo '<div class="iceberg-content-container iceberg-container">';
		echo '<div class="' . iceberg_get_sidebar_wrap_class($sidebar_type) . '" >';

		// sidebar content
		echo '<div class="' . iceberg_get_sidebar_class(array('sidebar-type'=>$sidebar_type, 'section'=>'center')) . '" >';
		echo '<div class="iceberg-content-wrap iceberg-item-pdlr clearfix" >';

		// change order vars and calculations

			setlocale(LC_MONETARY, 'en_US.utf8');
			$subscrip_customer_information = get_field('subscrip_customer_information');
    		$subscrip_semi_custom_development = get_field('subscrip_semi_custom_development');
            $sales_email = get_the_author_meta( 'user_email');

		// single content

        
		if( empty($post_option['show-content']) || $post_option['show-content'] == 'enable' ){
	
			echo '<div class="iceberg-content-area" >';
			?>

			<div class="top-info">
            <div class="iceberg-info">
                <div class="proposal-logo">
                    <img src="https://support.icebergwebdesign.com/wp-content/uploads/2016/09/IcebergWebDesign.png">
                </div>
                <!-- <div class="proposal-name"><h2>Iceberg Web Design</h2></div> -->
                <div class="proposal-address">203 Jackson Street<br>Suite 201<br>Anoka, MN 55303</div>
                <div class="proposal-phone">763-350-8762</div>

            </div>
            <div class="proposal-customer-info">

                <?php
                $subscrip_customer_information = get_field('subscrip_customer_information');
                $subscrip_company_address = $subscrip_customer_information['company_address'];
                $subscrip_semi_custom_development = get_field('subscrip_semi_custom_development');
                $image = $subscrip_customer_information['company_logo'];
                $goals = get_field('subscrip_goals');
                $subscrip_options = get_field('subscrip_options');

                if($subscrip_options && in_array('semicontent', $subscrip_options)){
                    $subscrip_semicontent_monthly = $subscrip_semi_custom_development['subscrip_semi_content_price']; 
                }else{
                    $subscrip_semicontent_monthly = 0;
                }

                if($subscrip_options && in_array('semibase', $subscrip_options)){
                    $subscrip_semibase_monthly = $subscrip_semi_custom_development['subscrip_semi_price']; 
                }else{
                    $subscrip_semibase_monthly = 0;
                }

                if($subscrip_options && in_array('socialcampaign', $subscrip_options)){
                    $subscrip_socialbrand_monthly = $subscrip_semi_custom_development['subscrip_social_brand_price']; 
                }else{
                    $subscrip_socialbrand_monthly = 0;
                }

                if($subscrip_options && in_array('socialmanage', $subscrip_options)){
                    $subscrip_socialadvertise_monthly = $subscrip_semi_custom_development['subscrip_social_media_price']; 
                }else{
                    $subscrip_socialadvertise_monthly = 0;
                }

                
                $subscrip_monthly_total = $subscrip_semicontent_monthly + $subscrip_semibase_monthly + $subscrip_socialbrand_monthly + $subscrip_socialadvertise_monthly;

                $size = 'full'; // (thumbnail, medium, large, full or custom size)
                date_default_timezone_set('America/Chicago');

                $fifteen = strtotime(date('Y-m-15 00:00'));
                $now = strtotime('today 00:00');

                if($now < $fifteen){
                    $unix_timestamp = strtotime('first day of +1 month 00:00');
                    // echo '<p>Subscription Day  ';
                    // echo $unix_timestamp . '<br>';
                    // echo Date('m-d-Y', $unix_timestamp);
                    // echo '</p>';
                }
                else{
                    $unix_timestamp = strtotime('first day of +2 month 00:00');
                    // echo '<p>Subscription Day  ';
                    // echo $unix_timestamp . '<br>';
                    // echo Date('m-d-Y', $unix_timestamp);
                    // echo '</p>';
                }    

                if( $image ) {

                    echo '<div class="proposal-logo">'; ?>
                    <img src="<?php echo $image; ?>">
                    <?php echo '</div>';

                }

                else { ?> <div class="proposal-name"><h6><?php echo $subscrip_customer_information['company_name']; ?></h6></div> <?php }

                ?>

                <div class="proposal-address">
                    <?php if($subscrip_company_address['street_address']) { ?> <?php echo $subscrip_company_address['street_address']; ?><br> <?php } ?>
                    <?php if($subscrip_company_address['address_line_2']) { ?> <?php echo $subscrip_company_address['address_line_2']; ?><br> <?php } ?>
                    <?php if($subscrip_company_address['city']) { ?> <?php echo $subscrip_company_address['city']; ?>, <?php } ?>
                    <?php if($subscrip_company_address['state']) { ?> <?php echo $subscrip_company_address['state']; ?> <?php } ?>
                    <?php if($subscrip_company_address['zip']) { ?> <?php echo $subscrip_company_address['zip']; ?> <?php } ?>
                </div>
                <div class="proposal-phone"><?php echo $subscrip_customer_information['company_phone']; ?></div>

                <div class="proposal-contact_name"><?php echo $subscrip_customer_information['contact_first_name']; ?> <?php echo $subscrip_customer_information['contact_last_name']; ?></div>

                <div class="proposal-contact_email"><?php echo $subscrip_customer_information['contact_email']; ?></div>

            </div>
        </div>

        <div class="proposal-company-title">
            <h2>Proposal</h2><strong>for</strong>
            <div class="proposal-name"><h3><?php echo $subscrip_customer_information['company_name']; ?></h3></div>
            <div class="proposal-sent"><?php the_field('subscrip_proposal_sent'); ?><br><small><em>Proposals are valid for 30 days</em></small></div>
        </div>
			<!-- password protect the custom fields -->
			<?php if( !post_password_required( $post )): ?>

				<?php if( !empty($goals )) { ?>
                <div class="proposal-title proposal-goal_info"><h4>Goals</h4>

                    <div class="proposal-goal">
                        <?php echo $goals ?>
                    </div>
                </div>
            <?php } ?>

        <div class="proposal-title proposal-website_domain_info"><!-- <h4>Domain</h4> -->

                <div class="proposal-domain_name">
                    <?php if($subscrip_semi_custom_development['domain_ownership'] == 1) { ?>
                        <?php echo $subscrip_semi_custom_development['domain_name']; ?>
                    <?php }
                    else { ?>
                        <a href="<?php echo $subscrip_semi_custom_development['domain_name']; ?>" target="_blank"><?php echo $subscrip_semi_custom_development['domain_name']; ?></a>
                    <?php } ?>
                </div>
        </div>

        <div class="proposal-domain_ownership">
                <?php if($subscrip_semi_custom_development['domain_ownership'] == 1) { ?>
                    <small><em>Iceberg will purchase and manage this domain name for <?php echo $subscrip_customer_information['company_name']; ?>. This is included in the price of hosting.</em></small>  <?php }
                else {?><small><em> <?php echo $subscrip_customer_information['company_name']; ?> already owns this domain name.</em></small> <?php }
                ?>
        </div>

        <div class="proposal-project-info">
        	
        	<?php if(($subscrip_options && in_array('semicontent', $subscrip_options)) || ($subscrip_options && in_array('semibase', $subscrip_options)) ): ?>
        	<div class="proposal-title proposal-website_development">
        		<!-- <h4>Website Development</h4> -->

  				<?php if($subscrip_options && in_array('semicontent', $subscrip_options)): ?>	

                    <?php if($subscrip_semi_custom_development['subscrip_custom_semi_title']){	?>	
  					<div class="custom-feature print-background"><?php echo $subscrip_semi_custom_development['subscrip_custom_semi_title']; ?>
                        <?php
                        }else{ ?>
                    <div class="custom-feature print-background">Semi-Custom Development + Content  
                        <?php } ?> 
  				       	<span class="proposal-price"><?php echo money_format('%n', $subscrip_semi_custom_development['subscrip_semi_content_price']); ?> / month</span>
                    
                	</div>
                	<div class="proposal-description"><?php echo $subscrip_semi_custom_development ['semi_description']; ?></div>
                <?php endif; ?>

                <?php if($subscrip_options && in_array('semibase', $subscrip_options)): ?>  

                <?php if($subscrip_semi_custom_development['subscrip_custom_semi_title']){  ?>  
                    <div class="custom-feature print-background"><?php echo $subscrip_semi_custom_development['subscrip_custom_semi_title']; ?>
                        <?php
                        }else{ ?>
                    <div class="custom-feature print-background">Semi-Custom Development 
                        <?php } ?> 

                        <span class="proposal-price"><?php echo money_format('%n', $subscrip_semi_custom_development['subscrip_semi_price']); ?> / month</span>
                    </div>
                    <div class="proposal-description"><?php echo $subscrip_semi_custom_development ['semi_description']; ?></div>
                <?php endif; ?>

                </div>
            <?php endif; ?>

            <?php if(($subscrip_options && in_array('socialcampaign', $subscrip_options)) || ($subscrip_options && in_array('socialmanage', $subscrip_options)) ): ?>
            <div class="proposal-title proposal-seo_development">
                <!-- <h4>Social Media</h4> -->

                <?php if($subscrip_options && in_array('socialcampaign', $subscrip_options)): ?>   

                    <?php if($subscrip_semi_custom_development['subscrip_custom_social_brand_title']){  ?>  
                    <div class="custom-feature print-background"><?php echo $subscrip_semi_custom_development['subscrip_custom_social_brand_title']; ?>
                        <?php
                        }else{ ?>
                    <div class="custom-feature print-background">Social Media Branding Camppaign
                        <?php } ?> 

                        <span class="proposal-price"><?php echo money_format('%n', $subscrip_semi_custom_development['subscrip_social_brand_price']); ?> / month</span>
                    </div>
                    <div class="proposal-description"><?php echo $subscrip_semi_custom_development ['seo_media_description']; ?></div>
                <?php endif; ?>

                <?php if($subscrip_options && in_array('socialmanage', $subscrip_options)): ?>  

                    <?php if($subscrip_semi_custom_development['subscrip_custom_social_media_title']){  ?>  
                    <div class="custom-feature print-background"><?php echo $subscrip_semi_custom_development['subscrip_custom_social_media_title']; ?>
                        <?php
                        }else{ ?>
                    <div class="custom-feature print-background">Social Media Advertising Managment
                        <?php } ?>

                        <span class="proposal-price"><?php echo money_format('%n', $subscrip_semi_custom_development['subscrip_social_media_price']); ?> / month</span>
                    </div>
                    <div class="proposal-description"><?php echo $subscrip_semi_custom_development ['seo_advertising_description']; ?></div>
                <?php endif; ?>
                	</div>
            <?php endif; ?>

            <div class="monthly">               
                <hr>
                <h4 class="custom-feature">Down Payment due at sign up
                <span class="proposal-price"><?php echo money_format('%n', get_field('subscrip_down_payment')); ?></span></h4>
                <h4 class="custom-feature">Monthly Total due on <?php echo Date('m-d-Y', $unix_timestamp); ?>
                <span class="proposal-price"><?php echo money_format('%n', $subscrip_monthly_total); ?> / month</span></h4>
            </div>

            

        </div>

                            <div class="proposal-order-form" id="order">
                                <a href="/orderform-monthly/?subscrip_company_name=<?php echo urlencode($subscrip_customer_information['company_name']); ?>&subscrip_first_name=<?php echo urlencode($subscrip_customer_information['contact_first_name']); ?>&subscrip_last_name=<?php echo urlencode($subscrip_customer_information['contact_last_name']); ?>&subscrip_company_phone=<?php echo $subscrip_customer_information['company_phone']; ?>&subscrip_domain_ownership=<?php echo $subscrip_semi_custom_development['domain_name']; ?>&subscrip_contact_email=<?php echo $subscrip_customer_information['contact_email']; ?>&subscrip_street_address=<?php echo urlencode($subscrip_company_address['street_address']); ?>&subscrip_address_line_2=<?php echo urlencode($subscrip_company_address['address_line_2']); ?>&subscrip_city=<?php echo urlencode($subscrip_company_address['city']); ?>&subscrip_state=<?php echo urlencode($subscrip_company_address['state']); ?>&subscrip_zip=<?php echo urlencode($subscrip_company_address['zip']); ?>&subscrip_country=<?php echo urlencode($subscrip_company_address['country']); ?>&subscrip_start_date=<?php echo Date('m-d-Y', $unix_timestamp); ?>&unix_timestamp=<?php echo $unix_timestamp; ?>&subscrip_monthly=<?php echo $subscrip_monthly_total; ?>&subscrip_down_payment_total=<?php echo get_field('subscrip_down_payment'); ?>&sales_email=<?php echo $sales_email; ?>&subscrip_link=<?php the_permalink(); ?>" target="_blank">Start Your Project</a>
                            </div>
        <div style="padding-top: 10px; float: right;"><?php echo do_shortcode('[print-me title="Print Proposal" printstyle="false" do_not_print=".proposal-order-form, .printomatictext"]'); ?></div>

        <div class="additional-costs">

            <?php the_field('subscrip_terms_conditions', 'option'); ?>

        </div>
        <div style="padding-top: 10px; float: right;"><?php echo do_shortcode('[print-me do_not_print=".proposal-price, .proposal-order-form, .monthly, .custom-feature-total, .project-total, .printomatictext"]'); ?></div>
     

			<?php endif; ?>
			<?php
			if( in_array(get_post_format(), array('aside', 'quote', 'link')) ){
				get_template_part('content/content', get_post_format());
			}else{
				get_template_part('content/content', 'single');
			}
			echo '</div>';

			if( !post_password_required() ){
				if( $sidebar_type != 'none' ){
					do_action('iwd_core_print_page_builder');
				}else{
					ob_start();
					do_action('iwd_core_print_page_builder');
					$pb_content = ob_get_contents();
					ob_end_clean();

					if( !empty($pb_content) ){
						echo '</div>'; // iceberg-content-area
						echo '</div>'; // iceberg_get_sidebar_class
						echo '</div>'; // iceberg_get_sidebar_wrap_class
						echo '</div>'; // iceberg_content_container
						echo iwd_core_escape_content($pb_content);
						echo '<div class="iceberg-bottom-page-builder-container iceberg-container" >'; // iceberg-content-area
						echo '<div class="iceberg-bottom-page-builder-sidebar-wrap iceberg-sidebar-style-none" >'; // iceberg_get_sidebar_class
						echo '<div class="iceberg-bottom-page-builder-sidebar-class" >'; // iceberg_get_sidebar_wrap_class
						echo '<div class="iceberg-bottom-page-builder-content iceberg-item-pdlr" >'; // iceberg_content_container
					}
				}
			}
		}else{
			do_action('iwd_core_print_page_builder');
		}

		echo '</div>'; // iceberg-content-area
		echo '</div>'; // iceberg-get-sidebar-class

		// sidebar left
		if( $sidebar_type == 'left' || $sidebar_type == 'both' ){
			echo iceberg_get_sidebar($sidebar_type, 'left', $sidebar_left);
		}

		// sidebar right
		if( $sidebar_type == 'right' || $sidebar_type == 'both' ){
			echo iceberg_get_sidebar($sidebar_type, 'right', $sidebar_right);
		}

		echo '</div>'; // iceberg-get-sidebar-wrap-class
	 	echo '</div>'; // iceberg-content-container

        if( !post_password_required( $post )): ?>
                <div class="iceberg_fixedbar">
                    <div class="iceberg_boxfloat">
 
                        <div id="ice_button">
                            <div id="ice_phone">
                                <div id="ice_logo">
                                    <img src="/wp-content/uploads/2016/09/Iceberg_White.png">
                                </div>
                                <div id="ice_phone_number">
                                    <a href="tel:763-350-8762">Questions? Call 763-350-8762</a>
                                </div>
                            </div>
                            <div id="ice_form">
                                <a href="/orderform-monthly/?subscrip_company_name=<?php echo urlencode($subscrip_customer_information['company_name']); ?>&subscrip_first_name=<?php echo urlencode($subscrip_customer_information['contact_first_name']); ?>&subscrip_last_name=<?php echo urlencode($subscrip_customer_information['contact_last_name']); ?>&subscrip_company_phone=<?php echo $subscrip_customer_information['company_phone']; ?>&subscrip_domain_ownership=<?php echo $subscrip_semi_custom_development['domain_name']; ?>&subscrip_contact_email=<?php echo $subscrip_customer_information['contact_email']; ?>&subscrip_street_address=<?php echo urlencode($subscrip_company_address['street_address']); ?>&subscrip_address_line_2=<?php echo urlencode($subscrip_company_address['address_line_2']); ?>&subscrip_city=<?php echo urlencode($subscrip_company_address['city']); ?>&subscrip_state=<?php echo urlencode($subscrip_company_address['state']); ?>&subscrip_zip=<?php echo urlencode($subscrip_company_address['zip']); ?>&subscrip_country=<?php echo urlencode($subscrip_company_address['country']); ?>&subscrip_start_date=<?php echo Date('m-d-Y', $unix_timestamp); ?>&unix_timestamp=<?php echo $unix_timestamp; ?>&subscrip_monthly=<?php echo $subscrip_monthly_total; ?>&subscrip_down_payment_total=<?php echo get_field('subscrip_down_payment'); ?>&sales_email=<?php echo $sales_email; ?>&subscrip_link=<?php the_permalink(); ?>" target="_blank">Start Your Project</a>
                            </div>
                        </div>

                    </div>
                </div>

<?php endif;

	} }// while

	get_footer(); ?>

    <script type="text/javascript">
jQuery(document).ready(function($) {
    $(window).scroll(function() {
        ($(document).scrollTop() + $(window).height()) / $(document).height() > 0.60 ? $('.iceberg_fixedbar').fadeIn() : $('.iceberg_fixedbar').fadeOut();
    });
})
</script>

<?php	



?>