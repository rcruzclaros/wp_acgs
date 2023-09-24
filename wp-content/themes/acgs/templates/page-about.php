<?php
/**
* Template Name: About Page
* Description: Used as a page template to show page contents, followed by a loop 
* through the "About Page"
*/

// Add our custom loop
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_after_header', 'about_loop' );
function about_loop() {
    $about_library = get_field('about_library');
    if($about_library): 
    ?>
    <section class="section-about-library">
        <div class="container">
            <div class="row valign-wrapper">
                <div class="col l6 m12 s12 box-left">
                    <?php echo do_shortcode($about_library['about_content']);?>
                </div>
                <div class="col l6 m12 s12">
                    <img src="<?php echo $about_library['about_image']?>" />
                </div>
            </div>
        </div>   
    </section>
    <?php
    endif;

    $about_purpose = get_field('about_purpose');
    if($about_purpose): 
    ?>
    <section class="section-about-purpose">
        <div class="container">
            <h2><?php echo $about_purpose['about_title'];?></h2>
            <ul>
            <?php foreach($about_purpose['about_list'] as $pitem):?>
                <li><i class="fa fa-check"></i> <?php echo $pitem['item_list']?></li>
            <?php endforeach;?>
            </ul>
        </div>   
    </section>
    <?php
    endif;

    $about_features = get_field('about_features');
    if($about_features):
        $common_area = $about_features['common_area_about']['value'];
        if($common_area == 'default'){
            $common_features = get_field('common_features','option');
            $feature_1_title = $common_features['common_feature_1_title'];
            $feature_1_content = $common_features['common_feature_1_content'];
            $feature_1_button = $common_features['common_feature_1_button'];
            $feature_2_title = $common_features['common_feature_2_common_feature_1_title'];
            $feature_2_content = $common_features['common_feature_2_common_feature_1_content'];
            $feature_2_button = $common_features['common_feature_2_common_feature_1_button'];
        } else {
            $feature_1_title = $about_features['feature_1_title'];
            $feature_1_content = $about_features['feature_1_content'];
            $feature_1_button = $about_features['feature_1_button'];
            $feature_2_title = $about_features['feature_2_feature_1_title'];
            $feature_2_content = $about_features['feature_2_feature_1_content'];
            $feature_2_button = $about_features['feature_2_feature_1_button'];
        }
        
    ?>
    <section class="section-features">
        <div class="container">
            <div class="row">
                <div class="col l6 m12 s12">
                    <div class="box-feature box-green">
                        <div class="feature-icon valign-wrapper"><i class="far fa-user"></i></div>
                        <h3><?php echo $feature_1_title;?></h3>
                        <?php echo do_shortcode( $feature_1_content );?>
                        <?php echo do_shortcode('[button color="green" url="'.$feature_1_button['url'].'" target="'.$feature_1_button['target'].'"]'.$feature_1_button['title'].'[/button]');?>
                    </div>
                </div>
                <div class="col l6 m12 s12">
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

    $about_events = get_field('about_events');
    if($about_events): 
        $common_area_events = $about_events['home_events']['common_area_events']['value'];
        if($common_area_events=='default') {
            $common_news_events = get_field('common_news_events','option');
            $list_events = $common_news_events['list_events'];
        } else {
            $list_events = $about_events['list_events'];
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