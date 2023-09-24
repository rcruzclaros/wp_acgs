<?php
/**
* Template Name: My Account Page
* Description: Used as a page template to show page contents, followed by a loop 
* through the "My Account Page"
*/
// Add our custom loop
remove_action('genesis_after_header', 'display_page_featured_image');
remove_action('genesis_entry_header', 'genesis_do_post_title');
add_action('genesis_after_header', 'display_hero_my_account');

function display_hero_my_account(){
    if (is_user_logged_in()) {
        //$current_user = wp_get_current_user();
        $current_user = get_userdata( get_current_user_id() );
        
    }
    
    $hero = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
    if($hero && $current_user) {
        ?>
        <section class="section-hero page" style="background-image: url('<?php echo $hero[0] ?>')">
            <div class="hero-filter">
                <div class="container">
                    <div class="row valign-wrapper">
                        <div class="txt-content">
                            <div class="content-account-info">
                                <div class="account-img">
                                    <img src="<?php echo get_avatar_url(get_current_user_id()); ?>" class="avatar avatar- wp-user-avatar wp-user-avatar- alignnone photo">
                                </div>
                                <div class="account-details">
                                    <div>Welcome</div>
                                    <h1><?php echo $current_user->display_name; ?></h1>
                                    <a href="<?php echo wp_logout_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>" class="green-btn-acgs btn-sm" ><strong>LOGOUT</strong></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

genesis(); 