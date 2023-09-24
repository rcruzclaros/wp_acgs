<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );
// ACF
include_once( get_stylesheet_directory() . '/plugins/init.php' );
// Shortcodes
include_once( get_stylesheet_directory() . '/lib/functions/shortcodes.php' );
//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'ACGS' );
define( 'CHILD_THEME_URL', 'http://acgs.com' );
define( 'CHILD_THEME_VERSION', '1.0' );

//* Enqueue Lato Google font
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {
	wp_enqueue_style( 'font-awesome-free', '//use.fontawesome.com/releases/v5.0.12/css/all.css' );
	wp_enqueue_style( 'google-font-muli', '//fonts.googleapis.com/css?family=Muli:300,400,600,700,800', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'google-font-lato', '//fonts.googleapis.com/css?family=Lato:300,400,700,900', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'animations-css', get_stylesheet_directory_uri().'/lib/stylesheets/animations.css', array(), CHILD_THEME_VERSION );
}
/** Remove jQuery and jQuery-ui scripts loading from header */
add_action('wp_enqueue_scripts', 'crunchify_script_remove_header');
function crunchify_script_remove_header() {
      wp_deregister_script( 'jquery' );
      wp_deregister_script( 'jquery-ui' );
}
 
/** Load jQuery and jQuery-ui script just before closing Body tag */
add_action('genesis_after_footer', 'crunchify_script_add_body');
function crunchify_script_add_body() {
      wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js', false, null);
      wp_enqueue_script( 'jquery');
      
      wp_register_script( 'jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js', false, null);
	  wp_enqueue_script( 'jquery-ui');
	  
	  wp_register_script( 'materialize', get_stylesheet_directory_uri().'/lib/js/materialize.min.js', false, null);
	  wp_enqueue_script( 'materialize');

	  wp_register_script( 'slick-js', get_stylesheet_directory_uri().'/lib/js/slick.min.js', false, null);
	  wp_enqueue_script( 'slick-js');

	  wp_register_script( 'masonry-js', get_stylesheet_directory_uri().'/lib/js/masonry.pkgd.min.js', false, null);
	  wp_enqueue_script( 'masonry-js');

	  wp_register_style( 'lc_lightbox-css', get_stylesheet_directory_uri().'/lib/lightbox/lc_lightbox.css', false, null);
	  wp_enqueue_style( 'lc_lightbox-css');
			
      wp_register_style( 'lc_lightbox-dark', get_stylesheet_directory_uri().'/lib/lightbox/dark.css', false, null);
      wp_enqueue_style( 'lc_lightbox-dark');      		
	  
	  wp_register_script( 'lc_lightbox-js', get_stylesheet_directory_uri().'/lib/js/lc_lightbox.lite.min.js', false, null);
	  wp_enqueue_script( 'lc_lightbox-js');
	  
	  wp_register_script( 'animate-js', get_stylesheet_directory_uri().'/lib/js/css3-animate-it.js', false, null);
      wp_enqueue_script( 'animate-js');

	  wp_register_script( 'custom-js', get_stylesheet_directory_uri().'/lib/js/custom.js', false, null);
	  wp_enqueue_script( 'custom-js');
}

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for custom image size
add_image_size( 'blog-list', 530, 335, true );
add_image_size( 'masonry-large', 305, 200, true );
add_image_size( 'masonry-tall', 150, 200, true );

//* Add support for custom more post
add_filter('excerpt_more', 'custom_excerpt_more');
function custom_excerpt_more( $more ) {
	return '';
}

//* Add support for custom excerpt length
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function custom_excerpt_length( $length ) {
	return 30;
}

//* Add Custom Pagination with numbers
function pagination_bar( $custom_query ) {
    $total_pages = $custom_query->max_num_pages;
    $big = 999999999; // need an unlikely integer
    if ($total_pages > 1){
        $current_page = max(1, get_query_var('paged'));
        echo paginate_links(array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => $current_page,
			'total' => $total_pages,
			'prev_text' => __( '<i class="fas fa-angle-left"></i> Prev' ),
			'next_text' => __( 'Next <i class="fas fa-angle-right"></i>' ),
        ));
    }
}

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Force Genesis Full Width
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Top Banner
genesis_register_sidebar( array(
	'id' => 'top-bar',
	'name' => __( 'Top Bar', 'theme-prefix' ),
	'description' => __( 'This is the top bar above the header.', 'theme-prefix' ),
) );

//add_action( 'genesis_before_header', 'utility_bar' );
function top_bar() {
 
	genesis_widget_area( 'top-bar', array(
		'before' => '<div class="top-bar"><div class="container">',
		'after' => '</div></div>',
	) );
}
add_action( 'genesis_before', 'top_bar' );

/**
 * Responsive Menus
 */
add_action( 'genesis_before', 'top_menus' );
function top_menus(){
	echo '<div class="menu-responsive-left"><span></span><span></span><span></span></div>';
	echo '<div class="menu-responsive-right"><span></span><span></span><span></span></div>';
}

//* Header

/* # Header Schema
---------------------------------------------------------------------------------------------------- */

remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
function custom_site_title() { 
	$logo = get_field( 'header', 'option' );
	echo '<a class="retina logo" href="'.get_bloginfo('url').'" title="TI"><img src="'.$logo['logo'].'" alt="logo"/></a>';
}
add_action( 'genesis_site_title', 'custom_site_title' );

remove_action('genesis_entry_header', 'genesis_do_post_title');

//* Customize the entire footer
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_before_footer', 'subscribe_footer' );
function subscribe_footer() {
	?>
	<div class="subscribe-footer">
		<div class="wrap">
			<?php echo do_shortcode('[gravityform id="1" title="false" description="false" ajax="true"]');?>
		</div>
	</div>
	<?php
}
add_action( 'genesis_footer', 'sp_custom_footer' );
function sp_custom_footer() {
	?>
	<div class="row valign-wrapper">
			<div class="col m10 s12 copy-info">
			<p>&copy; <?php echo date('Y');?> American-Canadian Genealogical Society   |   All Rights Reserved </p>
			</div>
			<div class="col m2 s12">
				<?php 
				$slinks = get_field('footer', 'option');
				// print_r(get_field('footer', 'option'));
				foreach($slinks['social_links'] as $links){
					
					echo '<a href="'.$links['link'].'"><i class="fab fa-'.$links['social_link'].'"></i></a>';
				}
				?>
				<!-- <i class="fa fa-facebook"></i> -->
			</div>
	</div>
	<?php
}


add_filter("gform_submit_button", "form_submit_button", 10, 2);
function form_submit_button($button, $form){
    // The following line is from the Gravity Forms documentation - it doesn't include your custom button text
    // return "<button class='button' id='gform_submit_button_{$form["id"]}'>'Submit'</button>";
    // This includes your custom button text:
    return "<button class='base-button color-red' id='gform_submit_button_{$form["id"]}'>{$form['button']['text']} <i class='fas  fa-angle-right'></i></button>";
}


/**
 * Hero Pages
 */
add_action( 'genesis_after_header', 'display_page_featured_image' );
function display_page_featured_image() {
    if( $hero_block			= get_field('hero')):
        ?>
        <section class="section-hero page" style="background-image: url('<?php echo $hero_block['hero_image']?>')">
            <div class="hero-filter">
                <div class="container">
                    <div class="row valign-wrapper">
                        <div class="txt-content">
                            <?php echo do_shortcode($hero_block['hero_content']); ?>
                            <?php if(isset($hero_block['hero_button']['title'])): ?>
                            <?php echo do_shortcode('[button color="red" url="'.$hero_block['hero_button']['url'].'" target="'.$hero_block['hero_button']['target'].'"]'.$hero_block['hero_button']['title'].'[/button]');?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    endif;
    echo '<style type="text/css">
        .single-product .variations_form select{
            max-width: 200px!important;
            min-width: 150px!important;
            -webkit-appearance: none;
            padding-bottom: 5px!important;
    		padding-top: 5px!important;
    		background: url('.get_stylesheet_directory_uri().'/images/arrow-down.png) no-repeat;
    		background-position: 93% center;
    		background-size: 15px 10px;
        }
        .single-product .variations_form select::-ms-expand{
        	display: none;
        }
        .single-product div.product form.cart .variations td.label{
        	padding-right: 5px;
        }
    </style>';
}

/**
 * Woocommerce New Taxonomy States
 */
function custom_taxonomy_states()  {

	$labels = array(
		'name'                       => 'State',
		'singular_name'              => 'State',
		'menu_name'                  => 'State',
		'all_items'                  => 'All States',
		'parent_item'                => 'Parent State',
		'parent_item_colon'          => 'Parent State:',
		'new_item_name'              => 'New State Name',
		'add_new_item'               => 'Add New State',
		'edit_item'                  => 'Edit State',
		'update_item'                => 'Update State',
		'separate_items_with_commas' => 'Separate State with commas',
		'search_items'               => 'Search State',
		'add_or_remove_items'        => 'Add or remove States',
		'choose_from_most_used'      => 'Choose from the most used State',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'state', 'product', $args );
	
}
add_action( 'init', 'custom_taxonomy_states', 0 );

/**
 * Woocommerce New Taxonomy Topic
 */
function custom_taxonomy_topic()  {

	$labels = array(
		'name'                       => 'Topics',
		'singular_name'              => 'Topic',
		'menu_name'                  => 'Topic',
		'all_items'                  => 'All Topics',
		'parent_item'                => 'Parent Topic',
		'parent_item_colon'          => 'Parent Topic:',
		'new_item_name'              => 'New Topic Name',
		'add_new_item'               => 'Add New Topic',
		'edit_item'                  => 'Edit Topic',
		'update_item'                => 'Update Topic',
		'separate_items_with_commas' => 'Separate Topic with commas',
		'search_items'               => 'Search Topic',
		'add_or_remove_items'        => 'Add or remove Topic',
		'choose_from_most_used'      => 'Choose from the most used Topic',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'topic', 'product', $args );
	
}
add_action( 'init', 'custom_taxonomy_topic', 0 );

/**
 * Woocommerce New Taxonomy Town
 */
function custom_taxonomy_town()  {

    $labels = array(
        'name'                       => 'Town',
        'singular_name'              => 'Town',
        'menu_name'                  => 'Town',
        'all_items'                  => 'All Towns',
        'parent_item'                => 'Parent Town',
        'parent_item_colon'          => 'Parent Town:',
        'new_item_name'              => 'New Town Name',
        'add_new_item'               => 'Add New Town',
        'edit_item'                  => 'Edit Town',
        'update_item'                => 'Update Town',
        'separate_items_with_commas' => 'Separate Town with commas',
        'search_items'               => 'Search Town',
        'add_or_remove_items'        => 'Add or remove Town',
        'choose_from_most_used'      => 'Choose from the most used Town',
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'town', 'product', $args );
    
}
add_action( 'init', 'custom_taxonomy_town', 0 );

/**
 * Woocommerce New Taxonomy Parish
 */
function custom_taxonomy_parish()  {

    $labels = array(
        'name'                       => 'Parish',
        'singular_name'              => 'Parish',
        'menu_name'                  => 'Parish',
        'all_items'                  => 'All Parishs',
        'parent_item'                => 'Parent Parish',
        'parent_item_colon'          => 'Parent Parish:',
        'new_item_name'              => 'New Parish Name',
        'add_new_item'               => 'Add New Parish',
        'edit_item'                  => 'Edit Parish',
        'update_item'                => 'Update Parish',
        'separate_items_with_commas' => 'Separate Parish with commas',
        'search_items'               => 'Search Parish',
        'add_or_remove_items'        => 'Add or remove Parish',
        'choose_from_most_used'      => 'Choose from the most used Parish',
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'parish', 'product', $args );
    
}
add_action( 'init', 'custom_taxonomy_parish', 0 );

/**
 * Woocommerce New Taxonomy Event
 */
function custom_taxonomy_event()  {

    $labels = array(
        'name'                       => 'Event',
        'singular_name'              => 'Event',
        'menu_name'                  => 'Event',
        'all_items'                  => 'All Events',
        'parent_item'                => 'Parent Event',
        'parent_item_colon'          => 'Parent Event:',
        'new_item_name'              => 'New Event Name',
        'add_new_item'               => 'Add New Event',
        'edit_item'                  => 'Edit Event',
        'update_item'                => 'Update Event',
        'separate_items_with_commas' => 'Separate Event with commas',
        'search_items'               => 'Search Event',
        'add_or_remove_items'        => 'Add or remove Event',
        'choose_from_most_used'      => 'Choose from the most used Event',
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'event-product', 'product', $args );
    
}
add_action( 'init', 'custom_taxonomy_event', 0 );

/********************************/
function my_custom_profile() {
    add_rewrite_endpoint( 'my-profile', EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'my-orders', EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'my-address', EP_ROOT | EP_PAGES );
    add_rewrite_endpoint( 'subscription', EP_ROOT | EP_PAGES );
}
add_action( 'init', 'my_custom_profile' );

/**
 * Add new query var.
 *
 * @param array $vars
 * @return array
 */
function my_custom_query_profile( $vars ) {
    $vars[] = 'my-profile';
    $vars[] = 'my-orders';
    $vars[] = 'my-address';
    $vars[] = 'subscription';
    return $vars;
}
add_filter( 'query_vars', 'my_custom_query_profile', 0 );

function my_custom_my_account_menu_items( $items ) {
    // Remove the logout menu item.
    $logout = $items['customer-logout'];
    unset( $items['customer-logout'] );
    // Insert your custom endpoint.
    $items['my-profile'] = __( 'My Profile', 'woocommerce' );
    $items['my-orders'] = __( 'My Orders', 'woocommerce' );
    $items['my-address'] = __( 'My Address', 'woocommerce' );
    $items['subscription'] = __( 'My Subscription', 'woocommerce' );
    // Insert back the logout item.

    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'my_custom_my_account_menu_items' );


require_once get_stylesheet_directory() . '/lib/functions/binnacle.php';

/*  My Events Page Content
******************************/
function subscription_custom_endpoint_content() {
    ?>
    <div class="custom-content-account">
        <ul class="my-account-tabs desktop-show">
            <li><a href="<?php echo get_site_url();?>/my-account/">MY PROFILE</a></li>
            <li><a href="<?php echo get_site_url();?>/my-account/subscription/" class="active">MY SUBSCRIPTION</a></li>
            <li><a href="<?php echo get_site_url();?>/my-account/orders/">MY ORDERS</a></li>
        </ul>
        <div class="my-tabs mobile-show">
            <div class="current-tab">MY SUBSCRIPTION</div>
            <div class="dropdown-tabs">
                <div><a href="<?php echo get_site_url();?>/my-account/">MY PROFILE</a></div>
                <div><a href="<?php echo get_site_url();?>/my-account/subscription/" class="active">MY SUBSCRIPTION</a></div>
                <div><a href="<?php echo get_site_url();?>/my-account/orders/">MY ORDERS</a></div>
            </div>
        </div>
        <div class="my-account-content-t" style="clear:both;">
        <div id="my-profile-content" class="my-ac-tab active top-m my-subscription-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12"><h2>My Subscription</h2><hr></div>
                </div>
                <table class="tbl-dashboard-info">
                    <?php
                    $membership_types = wc_memberships_get_membership_plans();
                    if ($membership_types) {
                        foreach ($membership_types as $membership_type) {
                            if (wc_memberships_is_user_active_member(get_current_user_id(),$membership_type->slug)) {
                                echo '<tr><th>Membership type:</th><td>'.$membership_type->name.'</td></tr>';
                                $my_membership = $membership_type->id;
                            }
                        }
                    }
                    ?>
                    <tr>
                        <th>Member since:</th>
                        <td width="75%">
                            <?php
                            if ($my_membership) {
                                $args = array(
                                    'plan_id' => $my_membership
                                );
                                $user_membership = wc_memberships_get_user_membership( get_current_user_id(), $args['plan_id'] );
                                echo date("d/m/Y", strtotime($user_membership->get_start_date()));
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Membership expires:</th>
                        <td >
                            <?php
                            if($my_membership){
                                $args = array(
                                    'plan_id' => $my_membership
                                );
                                $user_membership = wc_memberships_get_user_membership( get_current_user_id(), $args['plan_id'] );
                                echo '<span class="expire-membership">'.date("d/m/Y", strtotime($user_membership->get_end_date())).'</span>';
                            }
                            ?>
                        </td>
                    </tr>
                </table>

                <!-- <div class="row smb member-type-row">
                    <div class="one-half first">
                        <?php
                        $membership_types = wc_memberships_get_membership_plans();
                        if ($membership_types) {
                            foreach ($membership_types as $membership_type) {
                                if (wc_memberships_is_user_active_member(get_current_user_id(),$membership_type->slug)) {
                                    echo '<strong>Membership type:</strong> <span>'.$membership_type->name.'</span>';
                                    $my_membership = $membership_type->id;
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="row smb">
                    <div class="one-half first">Member since: <?php
                    if ($my_membership) {
                        $args = array(
                            'plan_id' => $my_membership
                        );
                        $user_membership = wc_memberships_get_user_membership( get_current_user_id(), $args['plan_id'] );
                        echo date("d/m/Y", strtotime($user_membership->get_start_date()));
                    }
                    ?></div>
                </div>
                <div class="row smb">
                    <div class="one-half first">Membership expires: <?php
                    if($my_membership){
                        $args = array(
                            'plan_id' => $my_membership
                        );
                        $user_membership = wc_memberships_get_user_membership( get_current_user_id(), $args['plan_id'] );
                        echo '<span class="expire-membership">'.date("d/m/Y", strtotime($user_membership->get_end_date())).'</span>';
                    }
                    ?></div>
                </div>  -->
                <div>
                    <a href="#" class="green-btn-acgs">RENEW MY SUBSCRIPTION</a>
                </div>
            </div>
        </div>      
    </div>
    <?php
}
add_action( 'woocommerce_account_subscription_endpoint', 'subscription_custom_endpoint_content' );


/**
 * Add Custom User Meta Fields
 */
add_action( 'show_user_profile', 'extra_profile_fields', 6 );
add_action( 'edit_user_profile', 'extra_profile_fields', 6 );
function extra_profile_fields( $user ) { ?>
    <h3><?php _e('Extra Profile Fields', 'frontendprofile'); ?></h3>
    <table class="form-table">
        <tr>
        <th><label for="origin-id">Origin ID</label></th>
        <td>
            <input type="text" name="origin_id" id="origin-id" value="<?php echo esc_attr( get_the_author_meta( 'origin_id', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">Here is the origin imported ID.</span>
        </td>
        </tr>
        <tr>
        <th><label for="origin-mdate">Origin MDate</label></th>
        <td>
            <input type="text" name="origin_mdate" id="origin-mdate" value="<?php echo esc_attr( get_the_author_meta( 'origin_mdate', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">Here is the origin imported MDate.</span>
        </td>
        </tr>
        <tr>
        <th><label for="middle-name">Middle Name</label></th>
        <td>
            <input type="text" name="middle_name" id="middle-name" value="<?php echo esc_attr( get_the_author_meta( 'middle_name', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">Enter your Middle Name here.</span>
        </td>
        </tr>
        <tr>
        <th><label for="origin-email">Origin Email</label></th>
        <td>
            <input type="text" name="origin_email" id="origin-email" value="<?php echo esc_attr( get_the_author_meta( 'origin_email', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">Here is the origin imported email.</span>
        </td>
        </tr>
        <tr>
        <th><label for="origin-mtype">Origin Member Type</label></th>
        <td>
            <input type="text" name="origin_mtype" id="origin-mtype" value="<?php echo esc_attr( get_the_author_meta( 'origin_mtype', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">Here is the origin imported Member Type.</span>
        </td>
        </tr>
    </table>
<?php }

add_action( 'personal_options_update', 'save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_profile_fields' );

function save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

    update_usermeta( $user_id, 'middle_name', $_POST['middle_name'] );
    update_usermeta( $user_id, 'origin_email', $_POST['origin_email'] );
    update_usermeta( $user_id, 'origin_id', $_POST['origin_id'] );
    update_usermeta( $user_id, 'origin_mdate', $_POST['origin_mdate'] );
    update_usermeta( $user_id, 'origin_mtype', $_POST['origin_mtype'] );
    update_usermeta( $user_id, 'billing_email', $_POST['user_email'] );
    update_usermeta( $user_id, 'billing_first_name', $_POST['user_firstname'] );
    update_usermeta( $user_id, 'billing_last_name', $_POST['user_lastname'] );
    update_usermeta( $user_id, 'billing_email', $_POST['user_email'] );
}
/* Redirect after save billing address */
function action_woocommerce_customer_save_address( $user_id, $load_address ) {
    wp_safe_redirect(wc_get_page_permalink('myaccount')); 
    exit;
}; 
add_action( 'woocommerce_customer_save_address', 'action_woocommerce_customer_save_address', 99, 2 );


add_action('genesis_after_header', 'login_header2');
function login_header2(){
    // If NOT in My account dashboard page
    /*if ( is_singular('product') ) {
        $counter = 0;
        $terms = get_the_terms( get_the_ID(), 'product_cat' );
        foreach ($terms as $term) {
            $product_cat_id = $term->term_id;
            if ($product_cat_id === 62) {
                $counter++;
            }
        }
        if ($counter != 0) {
            if (has_post_thumbnail()) {
                
            }
            ?>
            <section class="section-hero page" style="background-image: url('<?php echo get_site_url(); ?>/wp-content/uploads/2018/06/hero-member.jpg')">
                <div class="hero-filter">
                    <div class="container">
                        <div class="row valign-wrapper">
                            <div class="txt-content">
                                <h1 style="text-align:center;" id="login-head"><?php echo get_the_title(); ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        }
        
    }*/
    if( is_account_page() && !is_user_logged_in() ){
        ?>
        <section class="section-hero page" style="background-image: url('<?php echo get_site_url(); ?>/wp-content/uploads/2018/06/hero-member.jpg')">
            <div class="hero-filter">
                <div class="container">
                    <div class="row valign-wrapper">
                        <div class="txt-content">
                            <h1 style="text-align:center;" id="login-head">Member Login</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

function bbloomer_redirect_checkout_add_cart( $url ) {
    $url = get_permalink( get_option( 'woocommerce_checkout_page_id' ) ); 
    return $url;
}
 
add_filter( 'woocommerce_add_to_cart_redirect', 'bbloomer_redirect_checkout_add_cart' );

//the_author_meta('middle_name');

/*Menu options*/
/**
 * Adds a new item into the Bulk Actions dropdown.
 */
function register_option_bulk_actions( $bulk_actions ) {
    $bulk_actions['members_action'] = __( 'Move to Members', 'domain' );
    return $bulk_actions;
}
add_filter( 'bulk_actions-users', 'register_option_bulk_actions' );
/**
 * Handles the bulk action.
 */
function option_bulk_action_handler( $redirect_to, $action, $post_ids ) {
    if ( $action !== 'members_action' ) {
        return $redirect_to;
    }

    foreach ( $post_ids as $post_id ) {
        
        $id_plan ="";

        $plan_user = esc_attr( get_the_author_meta( 'origin_mtype', $post_id ) );

        $plans = wc_memberships_get_membership_plans();

        if ( !empty( $plans ) ) {

            foreach ( $plans as $plan ) {

                $name_plan = $plan->name;

                if ($plan_user = $name_plan) {

                    $id_plan = $plan->id;

                } else {

                    $id_plan = 788;
                    
                }
            }
        }

        $args = array(
        // Enter the ID (post ID) of the plan to grant at registration
            'plan_id'   => $id_plan,
            'user_id'   => $post_id,
        );
        wc_memberships_create_user_membership( $args );
    }

    $redirect_to = add_query_arg( 'bulk_members_active', count( $post_ids ), $redirect_to );

    return $redirect_to;
}
add_filter( 'handle_bulk_actions-users', 'option_bulk_action_handler', 10, 3 );
/**
 * Shows a notice in the admin once the bulk action is completed.
 */
function option_bulk_action_admin_notice() {
    if ( ! empty( $_REQUEST['bulk_members_active'] ) ) {
        $drafts_count = intval( $_REQUEST['bulk_members_active'] );

        printf(
            '<div id="message" class="updated fade">' .
            _n( '%s user moved to members.', '%s users moved to members.', $drafts_count, 'domain' )
            . '</div>',
            $drafts_count
        );
    }
}
add_action( 'admin_notices', 'option_bulk_action_admin_notice' );

/* End options */

/**
 * Ceremony events functions
 */

add_action( 'wp_ajax_search_ceremony_events', 'acgs_search_ceremoniy_events' );
function acgs_search_ceremoniy_events() {
    global $wpdb;
    $prefix = $wpdb->prefix;

    if ( isset($_POST['action']) ) {

        $fullname = empty($_POST['fullname'])? '' : filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
        $lname = empty($_POST['lname'])? '' : filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
        $parish = $_POST['parish'];
        $city = $_POST['city'];
        $type = $_POST['type'];

        $queries = [
            'baptism' => "( SELECT fname, lname, fullname, event_parish parish, bapt_place place, bapt_date event_date, 'baptism' etype "
                ."FROM {$prefix}ag_baptism "
                ."WHERE 1=1 "
                    .($fullname? "AND fullname LIKE '%{$fullname}%' " : ' ')
                    .($lname? "AND lname LIKE '%{$lname}%' " : ' ')
                    .($parish? "AND event_parish='{$parish}'" : " ")
                    .($city? "AND bapt_place='{$city}' " : " ")
                    ." ORDER BY event_date DESC, place, parish "
                    ."limit 10 ) ",

            'burial' => "( SELECT fname, lname, fullname, recordpari parish,  recordplac place, burial_date event_date, 'burial' etype  "
                ."FROM {$prefix}ag_burial "
                ."WHERE 1=1 "
                    .($fullname? "AND fullname LIKE '%{$fullname}%' " : ' ')
                    .($lname? "AND lname LIKE '%{$lname}%' " : ' ')
                    .($parish? "AND recordpari='{$parish}' " : " ")
                    .($city? "AND recordplac='{$city}' " : " ")
                    ." ORDER BY event_date DESC, place, parish "
                    ."limit 10 ) ",

            'marriage' => "( SELECT hfname fname, hlname lname, hfullname fullname, marparish parish, marplace place, mardate event_date, 'marriage' etype  "
                ."FROM {$prefix}ag_marriage "
                ."WHERE 1=1 "
                    .($fullname? "AND (hfullname LIKE '%{$fullname}%' OR wfullname LIKE '%{$fullname}%') " : ' ')
                    .($lname? "AND (hlname LIKE '%{$lname}%') " : " ")
                    .($parish? "AND marparish='{$parish}' " : " ")
                    .($city? "AND marplace='{$city}' " : " ")
                    ." ORDER BY event_date DESC, place, parish "
                    ."limit 10 ) ",
        ];

        if( empty($type) ) {
            $sql = implode('UNION ', $queries);
        }
        else {
            $sql = $queries[$type];
        }

        error_log($sql);

        // $sql =  "( SELECT fname, lname, fullname, event_parish parish, bapt_place place, bapt_date event_date, 'baptism' etype "
        //         ."FROM wp_ag_baptism "
        //         ."WHERE 1=1 "
        //             .($fullname? "AND fullname LIKE '%{$fullname}%' " : ' ')
        //             .($lname? "AND lname LIKE '%{$lname}%' " : ' ')
        //             .($parish? "AND event_parish='{$parish}'" : " ")
        //             .($city? "AND bapt_place='{$city}' " : " ")
        //             ." ORDER BY event_date DESC, place, parish "
        //             ."limit 10 ) "
        //         ."UNION "
        //         ."( SELECT fname, lname, fullname, recordpari parish,  recordplac place, burial_date event_date, 'burial' etype  "
        //         ."FROM wp_ag_burial "
        //         ."WHERE 1=1 "
        //             .($fullname? "AND fullname LIKE '%{$fullname}%' " : ' ')
        //             .($lname? "AND lname LIKE '%{$lname}%' " : ' ')
        //             .($parish? "AND recordpari='{$parish}' " : " ")
        //             .($city? "AND recordplac='{$city}' " : " ")
        //             ." ORDER BY event_date DESC, place, parish "
        //             ."limit 10 ) "
        //         ."UNION "
        //         ."( SELECT hfname, hlname, hfullname, marparish parish, marplace place, mardate event_date, 'marriage' etype  "
        //         ."FROM wp_ag_marriage "
        //         ."WHERE 1=1 "
        //             .($fullname? "AND (hfullname LIKE '%{$fullname}%' OR wfullname LIKE '%{$fullname}%') " : ' ')
        //             .($lname? "AND (hlname LIKE '%{$lname}%' OR wlname LIKE '{$lname}%') " : " ")
        //             .($parish? "AND marparish='{$parish}' " : " ")
        //             .($city? "AND marplace='{$city}' " : " ")
        //             ." ORDER BY event_date DESC, place, parish "
        //             ."limit 10 ) ";

        // error_log($sql . " - $type");
        $results = $wpdb->get_results($sql, ARRAY_A);

        if ( $results ) {
            echo '<div class="row row-flex">';
            foreach ($results as $row) {
                ?>
                <div class="col l4 m6 s12">
                    <div class="ceremony-item">
                        <h4><?php echo $row['fullname']; ?></h4>
                        <p>
                            <strong>Type:</strong> <?php echo $row['etype']; ?><br>
                            <strong>Last name:</strong> <?php echo $row['lname']; ?><br>
                            <strong>Parish:</strong> <?php echo $row['parish']; ?><br>
                            <strong>City/Place:</strong> <?php echo $row['place'] ?><br>
                            <strong>Event date:</strong> <?php echo $row['event_date'] ?>
                        </p>
                    </div>
                </div>
                <?php
            }
            echo '</iv>';
        }
    }
    wp_die();
}
