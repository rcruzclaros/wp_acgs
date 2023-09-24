<?php
/**
* Description: Used as a page template to show page contents, followed by a loop 
* through the "Single Blog"
*/

add_action( 'genesis_after_header', 'single_display_featured_image' );
function single_display_featured_image() {
    $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()),'full');
    $img_thumb = '';
    if (has_post_thumbnail()) {
        $img_thumb = $thumb_url[0];
    }else{
        $img_thumb = get_stylesheet_directory_uri()."/images/default-img.jpg";
    }
    ?>
    <section class="section-hero single-hero-blog" style="background-image: url('<?php echo $img_thumb?>')">
        <div class="container">
        </div>
    </section>
    <?php
}



// Add our custom loop
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_after_header', 'single_blog_loop' );
function single_blog_loop() {
        while ( have_posts() ) : the_post();
            echo '<section class="single-blog">';
                echo '<div class="container">';
                    echo '<h1>'.get_the_title().'</h1>';
                    echo '<div class="single-details">';
                        echo '<span><i class="fa fa-user"></i> '.get_the_author_meta( 'display_name' ).'</span>';
                        echo '<span><i class="fa fa-calendar"></i> '.get_the_date( 'F j, Y', get_the_ID() ).'</span>';
                    echo '</div>';
                    the_content();
                    echo '<div class="separator"><hr /></div>';
                    echo '<div class="related-blog">';
                        echo '<h2>Related Blog Post</h2>';
                        $settings = array(
                            'posts_per_page' => 2, 
                            'post_type' => 'post', 
                            'orderby' => 'date', 
                            'order' => 'DESC', 
                        );
                    
                        $list = '<div class="blog-related">';
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
                                            <a href="'.get_the_permalink().'"><h3>'.get_the_title().'</h3></a>
                                        </div>
                                    </div>';
                                endwhile;
                            endif;
                            wp_reset_query();
                            $list.= '</div>';
                        $list.= '</div>';
                        echo $list;
                    echo '</div>';
                echo '</div>';
            echo '</section>';
        endwhile;
    // endif;
}
genesis();