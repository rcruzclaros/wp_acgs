<?php
/**
* Template Name: Catalog Page
* Description: Used as a page template to show page contents, followed by a loop 
* through the "Catalog Page"
*/
// Add our custom loop
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_after_header', 'catalog_loop' );
function catalog_loop() {
    $catalog = get_field('catalog');
    if($catalog): 
    ?>
    <section class="section-list-filter">
        <div class="container">
            <?php echo do_shortcode($catalog['filter_shortcode']);?>
        </div>   
    </section>
    <section class="section-catalog">
        <div class="selected-catalog-filters">
            <div class="container">
                <div class="cc">
                <span class="state"></span>
                <span class="town"></span>
                <span class="parish"></span>
                <span class="event"></span>
                </div>
            </div>
        </div>
        <div class="container">
            <?php echo do_shortcode($catalog['list_shortcode']);?>
            <!--<div class="pagination"><a>Pagination</a></div>-->
        </div>   
    </section>
    <div class="container separator"><hr /></div>
    <section class="section-slider">
        <div class="container">
            <h2><?php echo $catalog['title_on_slider'];?></h2>
            <p></p>
            <?php echo do_shortcode($catalog['slider_shortcode']);?>
        </div>   
    </section>
    <?php
    endif;

    $become_member = get_field('become_member');
    if($become_member): 
    ?>
    <section class="section-filter" style="background-image: url(<?php echo $become_member['background_image']?>)">
        <div class="filter-green">
            <div class="container">
                <h3><?php echo $become_member['title'];?></h3>
                <?php 
                echo $become_member['content'];
                $section_link = $become_member['button'];
                echo '<a href="'.$section_link['url'].'" class="base-button color-transparent"><span>'.$section_link['title'].'</span> <i class="fas fa-angle-right"></i></a>';
                ?>
                
            </div>
        </div>   
    </section>
    <?php
    endif;
}


genesis(); 