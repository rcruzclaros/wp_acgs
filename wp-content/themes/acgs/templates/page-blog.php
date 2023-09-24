<?php
/**
* Template Name: Blog Page
* Description: Used as a page template to show page contents, followed by a loop 
* through the "Blog Page"
*/
remove_action( 'genesis_after_header', 'display_page_featured_image' );
add_action( 'genesis_after_header', 'display_featured_image' );
function display_featured_image() {
    if( $hero_block			= get_field('hero')):
        ?>
        <section class="section-hero page-blog" style="background-image: url('<?php echo $hero_block['hero_image']?>')">
            <div class="hero-filter-blue">
                <div class="container">
                    <div class="row valign-wrapper">
                        <div class="txt-content">
                            <?php echo do_shortcode($hero_block['hero_content']); ?>
                            <?php echo do_shortcode('[button color="red" url="'.$hero_block['hero_button']['url'].'" target="'.$hero_block['hero_button']['target'].'"]'.$hero_block['hero_button']['title'].'[/button]');?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    endif;
}



// Add our custom loop
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_after_header', 'blog_loop' );
function blog_loop() {
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $settings = array(
        'posts_per_page' => 6, 
        'post_type' => 'post', 
        'orderby' => 'date', 
        'order' => 'DESC', 
        'paged' => $paged
    );

    $list = '<div class="blog-list">';
        $list .= '<div class="row">';
        $loop = new WP_Query( $settings );
        if($loop->have_posts()):
            while ( $loop->have_posts() ) : $loop->the_post();
                $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()),'blog-list');
                $img_thumb = '';
                if (has_post_thumbnail()) {
                    $img_thumb = $thumb_url[0];
                }else{
                    $img_thumb = get_stylesheet_directory_uri()."/images/default-img.jpg";
                }
                $list .= '
                <div class="col l6 m6 s12">
                    <div class="blog-item">
                        <a href="'.get_the_permalink().'"><img src="'.$img_thumb.'" class="thumbnail-post"></a>
                        <a href="'.get_the_permalink().'"><h2>'.get_the_title().'</h2></a>
                        <p>'.get_the_excerpt().'</p>
                        <a href="'.get_the_permalink().'">Read More <i class="fas fa-angle-right"></i></a>
                    </div>
                </div>';
            endwhile;        
            // do_action( 'genesis_after_endwhile' );
        endif;
        // wp_reset_query();
        $list.= '</div>';
    $list.= '</div>';

    echo '<section class="blog-section">';
        echo '<div class="container">';
            echo $list;

            echo '<nav class="blog-pagination">';
                pagination_bar( $loop );
            echo '</nav>';

            // previous_posts_link( 'Newer posts &raquo;' ); 
            // next_posts_link('Older &raquo;') ;
    
        echo '</div>';
    echo '</section>';
}
genesis();