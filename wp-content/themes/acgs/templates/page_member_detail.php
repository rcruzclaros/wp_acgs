<?php
/**
* Template Name: Member Detail Content
* Description: Used to show any content related to a user page, needs 'uid' pased as query parameter
*/

// Add our custom loop
remove_action('genesis_after_header', 'display_page_featured_image');
remove_action('genesis_entry_header', 'genesis_do_post_title');
add_action('genesis_after_header', 'display_hero_member_detail');

function display_hero_member_detail(){

    $user_id = filter_var($_GET['uid'], FILTER_VALIDATE_INT );
    if($user_id === false) {
        $user_id = 0;
    }

    $current_user = get_userdata( $user_id);

    if( empty( $user_id ) || !$current_user ) {
        return;
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
                                    <img src="<?php echo get_avatar_url($user_id); ?>" class="avatar avatar- wp-user-avatar wp-user-avatar- alignnone photo">
                                </div>
                                <div class="account-details">
                                    <div><?php echo get_the_title( ); ?></div>
                                    <h1><?php echo $current_user->display_name; ?></h1>
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