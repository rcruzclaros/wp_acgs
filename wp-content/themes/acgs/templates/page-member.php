<?php
/**
* Template Name: Member Page
* Description: Used as a page template to show page contents, followed by a loop 
* through the "Member Page"
*/
// Add our custom loop
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_after_header', 'about_loop' );
function about_loop() {
    $about_member = get_field('become_a_member');
    $individual = '<i class="fas fa-male left-icon"></i>';
    $family = '<i class="fas fa-users left-icon"></i>';
    $student = '<i class="fas fa-graduation-cap left-icon"></i>';
    $lifetime = '<i class="fas fa-heart left-icon"></i>';
    $life = '<div class="double-icon"><i class="fas fa-heart left-icon "></i><i class="fas fa-female left-icon"></i></div>';
    $overseas = '<i class="fas fa-globe left-icon"></i>';
    $institution = '<i class="fas fa-university left-icon"></i>';
    $active = 'class="active"';
    $band=1;
    if($about_member): 
    ?>
    <section class="section-member">
        <div class="container">
            <h2><?php echo $about_member['member_title'];?></h2>
            <ul class="collapsible collapsible-acgs zzz">
            <?php foreach($about_member['member_accordion'] as $pitem):?>
            <?php if($band==1){
                $active = 'class="active"';
                }
                else{$active = 'class=""';}
            ?>
                <li <?php echo $active;?> >
                        <div class="collapsible-header">
                            <?php
                                if($pitem['icon']=="individual"){
                                    echo $individual;
                                }elseif($pitem['icon']=="family"){
                                    echo $family;
                                }elseif($pitem['icon']=="student"){
                                    echo $student;
                                }
                                elseif($pitem['icon']=="lifetime"){
                                    echo $lifetime;
                                }
                                elseif($pitem['icon']=="life-associate"){
                                    echo $life;
                                }
                                elseif($pitem['icon']=="overseas"){
                                    echo $overseas;
                                }
                                elseif($pitem['icon']=="institutions"){
                                    echo $institution;
                                }
                            ?>
                            <h5><?php echo $pitem['title'];?></h5>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="collapsible-body">
                            <?php echo $pitem['member_content'];?>
                            <a href="<?php echo $pitem['link']; ?>" class="base-button color-red">
                                <span>Sign up Today</span> 
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </div>
                </li>
                
            <?php $band++; endforeach;?>
            </ul>
        </div>   
    </section>
    
   
    <?php
    endif;

    $about_include = get_field('include');
    if($about_include): 
    ?>
    <section class="section-include">
        <div class="container">
            <h2><?php echo $about_include['incloude_title'];?></h2>
            <p><?php echo $about_include['include_content'];?></p>
            
        </div>   
    </section>
    
    <?php
    endif;

    $about_events = get_field('member_events');
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