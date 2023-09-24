<?php
/**
* Template Name: Home Page
* Description: Used as a page template to show page contents, followed by a loop 
* through the "Home Page"
*/

remove_action( 'genesis_after_header', 'display_page_featured_image' );
add_action( 'genesis_after_header', 'display_featured_image' );
function display_featured_image() {
    if( $hero_block			= get_field('hero')):
        ?>
        <section class="section-hero" style="background-image: url('<?php echo $hero_block['hero_image']?>')">
            <div class="container">
                <div class="row valign-wrapper">
                    <div class="txt-content">
                        <?php echo do_shortcode($hero_block['hero_content']); ?>
                        <?php echo do_shortcode('[button color="red" url="'.$hero_block['hero_button']['url'].'" target="'.$hero_block['hero_button']['target'].'"]'.$hero_block['hero_button']['title'].'[/button]');?>
                    </div>
                </div>
            </div>
        </section>
        <?php
    endif;
}



// Add our custom loop
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_after_header', 'cd_goh_loop' );
function cd_goh_loop() {
    $home_features = get_field('home_features');
    if($home_features):
        $common_area_features = $home_features['common_area_features'];
        if($common_area_features['value']=='default') {
            $common_features = get_field('common_features','option');
            $feature_1_title = $common_features['common_feature_1_title'];
            $feature_1_content = $common_features['common_feature_1_content'];
            $feature_1_button = $common_features['common_feature_1_button'];
            $feature_2_title = $common_features['common_feature_2_common_feature_1_title'];
            $feature_2_content = $common_features['common_feature_2_common_feature_1_content'];
            $feature_2_button = $common_features['common_feature_2_common_feature_1_button'];
        } else {
            $feature_1_title = $home_features['feature_1_title'];
            $feature_1_content = $home_features['feature_1_content'];
            $feature_1_button = $home_features['feature_1_button'];
            $feature_2_title = $home_features['feature_2_feature_1_title'];
            $feature_2_content = $home_features['feature_2_feature_1_content'];
            $feature_2_button = $home_features['feature_2_feature_1_button'];
        }
    ?>
    <section class="section-features">
        <div class="container">
            <div class="row animatedParent">
                <div class="col l6 s12 animated bounceInUp box">
                    <div class="box-feature box-green">
                        <div class="feature-icon valign-wrapper"><i class="far fa-user"></i></div>
                        <h3><?php echo $feature_1_title;?></h3>
                        <?php echo do_shortcode( $feature_1_content );?>
                        <?php echo do_shortcode('[button color="green" url="'.$feature_1_button['url'].'" target="'.$feature_1_button['target'].'"]'.$feature_1_button['title'].'[/button]');?>
                    </div>
                </div>
                <div class="col l6 s12 animated bounceInUp box">
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
    $home_library = get_field('home_library');
    if($home_library): 
    ?>
    <section class="section-library">
        <div class="container">
            <div class="row valign-wrapper">
                <div class="col l6 s12">
                    <h2><?php echo  $home_library['library_title']; ?></h2>
                    <?php echo do_shortcode($home_library['library_content']);?>
                    <p><a href="<?php echo $home_library['library_link']['url'] ?>"><?php echo $home_library['library_link']['title'] ?> <i class="fas  fa-angle-right"></i></a></p>
                </div>
                <div class="col l6 s12">
                    <div class="grid-acgs">
                        <!-- masonry-->
                        <?php
                        $counter=0;
                        foreach($home_library['library_images'] as $row) {
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
            </div>
        </div>   
    </section>
    <?php
    endif;
    $amazon_donate = get_field('amazon_donate');
    if($amazon_donate): 
    ?>
    <section class="section-amazon-donate">
        <div class="row valign-wrapper animatedParent">
            <div class="col l6 m6 s12 no-padding amazon-bg animated bounceInLeft box" style="background-image: url('<?php echo $amazon_donate['amazon_donate_background_column1'];?>')">
                <div class="filter-green">
                    <h3><?php echo $amazon_donate['amazon_donate_title']; ?></h3>
                    <?php echo do_shortcode($amazon_donate['amazon_donate_content']);?>
                    <?php echo do_shortcode('[button color="transparent" url="'.$amazon_donate['amazon_donate_button']['url'].'" target="'.$amazon_donate['amazon_donate_button']['target'].'"]'.$amazon_donate['amazon_donate_button']['title'].'[/button]');?>
                </div>
            </div>
            <div class="col l6 m6 s12 no-padding amazon-bg animated bounceInRight box" style="background-image: url('<?php echo $amazon_donate['amazon_donate_fields_amazon_donate_background_column1'];?>')">
                <div class="filter-blue">
                    <h3><?php echo $amazon_donate['amazon_donate_fields_amazon_donate_title']; ?></h3>
                    <?php echo do_shortcode($amazon_donate['amazon_donate_fields_amazon_donate_content']);?>
                    <?php echo do_shortcode('[button color="transparent" url="'.$amazon_donate['amazon_donate_fields_amazon_donate_button']['url'].'" target="'.$amazon_donate['amazon_donate_fields_amazon_donate_button']['target'].'"]'.$amazon_donate['amazon_donate_fields_amazon_donate_button']['title'].'[/button]');?>
                </div>
            </div>
        </div>
    </section>
    <?php
    endif;
    $home_events = get_field('home_events');
    if($home_events): 
        $common_area_events = $home_events['common_area_events'];
        if($common_area_events['value']=='default') {
            $common_news_events = get_field('common_news_events','option');
            $list_events = $common_news_events['list_events'];
        } else {
            $list_events = $home_events['list_events'];
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
                     <div class="row">
                        <div class="cols12">
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
    $publication = get_field('publication');
    if($publication):
        ?>
    <section class="section-publication" style="background-image: url('<?php echo get_site_url().'/wp-content/uploads/2018/06/path-bottom-bg.png';?>')">
         <div class="container">
                <div class="row  valign-wrapper desktop">
                    <div class="col l6 m5 s12">
                        <img class="circle-image" src="<?php echo $publication['publication_image'];?>">
                    </div>
                    <div class="col l6 m7 s12">
                    <h4><?php echo __('Featured Publication'); ?></h4>
                        <h2><?php echo $publication['publication_title'] ?></h2>
                        <?php echo do_shortcode($publication['publication_content']);?>
                        <p><a href="<?php echo $publication['publication_link']['url'] ?>"><?php echo $publication['publication_link']['title'] ?> <i class="fas  fa-angle-right"></i></a></p>
                    </div>
                </div>

                <div class="row  valign-wrapper mobile">
                    <div class="col s12">
                    <h4><?php echo __('Featured Publication'); ?></h4>
                        <h2><?php echo $publication['publication_title'] ?></h2>
                        <img class="circle-image" src="<?php echo $publication['publication_image'];?>">
                        <p></p>
                        <?php echo do_shortcode($publication['publication_content']);?>
                        <p><a href="<?php echo $publication['publication_link']['url'] ?>"><?php echo $publication['publication_link']['title'] ?> <i class="fas  fa-angle-right"></i></a></p>
                    </div>
                </div>
        </div>
    </section>  
        <?php
    endif;
}

genesis();