<?php
/**
* Template Name: Library Page
* Description: Used as a page template to show page contents, followed by a loop 
* through the "Library Page"
*/

// Add our custom loop
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_after_header', 'library_loop' );
function library_loop() {
    $information_section = get_field('information_section');
    //$url_img = $information_section['library_images'];
    if($information_section): 
    ?>
    <section class="content-section library" style="background: #fff;">
        <div class="container">
            <div class="row valign-wrapper">
                <div class="col l6 s12">
                    <div class="grid-acgs">
                        <!-- masonry-->
                        <?php
                        $counter=0;
                        foreach($information_section['library_images'] as $row) {
                            $counter++;
                            ?>       
                            <?php if ($counter <= 3 || $counter > 5):?>                    
                                <div class="grid-item grid-item-4">
                            <?php elseif($counter == 4):?>
                                <div class="grid-item grid-item-8 height-l">
                            <?php elseif($counter == 5):?>
                                <div class="grid-item grid-item-4 height-l">
                            <?php endif;?>
                                    <a class="gallery-acgs"
                                        href="<?php echo $row['url']?>"
                                        title="ACGS"
                                        data-lcl-txt="ACGS library"
                                        data-lcl-thumb="<?php echo $row['url']?>">
                                        <span style="background-image: url(<?php echo $row['url']?>)"></span>
                                    </a>
                                </div>
                            <?php
                        }?>
                        <!-- end masonry-->
                    </div>
                </div>
                <div class="col l6 s12">
                    <h4><?php echo $information_section['library_title']; ?></h4>
                    <?php echo $information_section['library_content']; ?>
                    <h4><?php echo $information_section['hours_title']; ?></h4>
                    <?php echo $information_section['hours_content']; 
                    $information_section_button = $information_section['hours_button'];
                    echo do_shortcode('[button color="red" url="'.$information_section_button['url'].'" target="'.$information_section_button['target'].'"]'.$information_section_button['title'].'[/button]');?>
                </div>
            </div>
        </div>   
    </section>
    <?php
    endif;

    $library_directions = get_field('library_directions');
    $active = 'class="active"';
    $item_active=1;
    if($library_directions):
    ?>
    <section class="content-section section-member accordion_library">
        <div class="container">
            <h2 class="center-align"><?php echo $library_directions['library_title'];?></h2>
            <ul class="collapsible collapsible-acgs">
                <?php 
                    foreach($library_directions['library_accordion'] as $row) {
                        if ($item_active == 1){
                            ?>
                            <li <?php echo $active; ?>>
                            <?php
                            $item_active++;
                        }
                        else {
                            ?>
                            <li>
                        <?php
                        }
                        ?>
                            <div class="collapsible-header">
                                <h5><?php echo $row['library_accordion_title'] ?></h5>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="collapsible-body">
                                <?php echo $row['library_accordion_content'] ?>
                            </div>
                        </li>
                        <?php
                    }
                ?>
            </ul>
        </div>
    </section>
    <?php
    endif;

    $library_features = get_field('library_features');
    if($library_features):
        $common_area_2 = $library_features['about_features']['common_area_about']['value'];
        if($common_area_2 == 'default'){
            $common_features = get_field('common_features','option');
            $feature_1_title = $common_features['common_feature_1_title'];
            $feature_1_content = $common_features['common_feature_1_content'];
            $feature_1_button = $common_features['common_feature_1_button'];
            $feature_2_title = $common_features['common_feature_2_common_feature_1_title'];
            $feature_2_content = $common_features['common_feature_2_common_feature_1_content'];
            $feature_2_button = $common_features['common_feature_2_common_feature_1_button'];
        } else {
            $feature_1_title = $library_features['feature_1_title'];
            $feature_1_content = $library_features['feature_1_content'];
            $feature_1_button = $library_features['feature_1_button'];
            $feature_2_title = $library_features['feature_2_title'];
            $feature_2_content = $library_features['feature_2_content'];
            $feature_2_button = $library_features['feature_2_button'];
        }
        
    ?>
    <section class="section-features">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <div class="box-feature box-green">
                        <div class="feature-icon valign-wrapper"><i class="far fa-user"></i></div>
                        <h3><?php echo $feature_1_title;?></h3>
                        <?php echo do_shortcode( $feature_1_content );?>
                        <?php echo do_shortcode('[button color="green" url="'.$feature_1_button['url'].'" target="'.$feature_1_button['target'].'"]'.$feature_1_button['title'].'[/button]');?>
                    </div>
                </div>
                <div class="col l6 s12">
                    <div class="box-feature box-blue">
                        <div class="feature-icon valign-wrapper"><i class="fas fa-shopping-basket"></i></div>
                        <h3><?php echo $feature_2_title;?></h3>
                        <?php echo do_shortcode($feature_2_content);?>
                        <?php echo do_shortcode('[button color="blue" url="'.$feature_2_button['url'].'" target="'.$feature_2_button['target'].'"]'.$feature_2_button['title'].'[/button]');?>
                    </div>
                </div>
            </div>
        </div>    
    </section>
    <?php
    endif;

    echo '<div class="separator space"><div class="container"><hr /></div></div>';
    
    $library_news_events = get_field('library_news_events');
    if($library_news_events): 
        $common_area_events = $library_news_events['home_events']['common_area_events']['value'];
        if($common_area_events=='default') {
            $common_news_events = get_field('common_news_events','option');
            $list_events = $common_news_events['list_events'];
        } else {
            $list_events = $library_news_events['list_events'];
        }
    ?>
    <section class="section-events" style="background-image: url('<?php echo get_site_url().'/wp-content/uploads/2018/06/path-top-bg.png';?>')">
         <div class="container">
            <div class="events-slider desktop">
             <?php 
             if($list_events):
                foreach($list_events as $row) {
                    ?>
                     <div class="row valign-wrapper">
                        <div class="col l6 m7 s12">
                            <h4><?php echo __('News & Events'); ?></h4>
                            <h2><?php echo $row['list_events_title'] ?></h2>
                            <?php echo do_shortcode($row['list_events_content']);?>
                            <p><a href="<?php echo $row['list_events_link']['url'] ?>"><?php echo $row['list_events_link']['title'] ?> <i class="fas fa-angle-right"></i></a></p>
                        </div>
                        <div class="col l6 m5 s12">
                            <img class="circle-image" src="<?php echo $row['list_events_image'];?>">
                            <!-- $home_events['list_events'][0]['list_events_background']; -->
                        </div>
                    </div>
                    <?php
                }
             endif;
             ?>
            </div>
            <div class="events-slider mobile">
             <?php 
             if($list_events):
                foreach($list_events as $row) {
                    ?>
                     <div class="row valign-wrapper">
                        <div class="col s12">
                            <h4><?php echo __('News & Events'); ?></h4>
                            <h2><?php echo $row['list_events_title'] ?></h2>
                            <img class="circle-image" src="<?php echo $row['list_events_image'];?>">
                            <p></p>
                            <?php echo do_shortcode($row['list_events_content']);?>
                            <p><a href="<?php echo $row['list_events_link']['url'] ?>"><?php echo $row['list_events_link']['title'] ?> <i class="fas fa-angle-right"></i></a></p>
                        </div>
                    </div>
                    <?php
                }
             endif;
             ?>
            </div>
         </div>
    </section>  
    <?php 
    endif;
}


genesis();