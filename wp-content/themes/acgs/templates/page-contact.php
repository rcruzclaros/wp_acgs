<?php
/**
* Template Name: Contact Page
* Description: Used as a page template to show page contents, followed by a loop 
* through the "Contact Page"
*/
// Add our custom loop
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_after_header', 'about_loop' );
function about_loop() {
    $contact_form = get_field('contact_information');
    if($contact_form): 
    ?>
    <section class="section-contact-info">
        <div class="container">
            <div class="row">
					<div class="col l8 s12">
                    <h3><?php echo $contact_form['question_title'];?></h3>
                    <?php echo do_shortcode($contact_form['question_form']);?>
					</div>
					<div class="col l4 s12">
                        <div class="box-address" >
                            <h4><?php echo $contact_form['physical_title'];?></h4>
                            <p><?php echo $contact_form['physical_content'];?></p>
                            <hr>
                            <h4><?php echo $contact_form['mailing_title'];?></h4>
                            <p><?php echo $contact_form['mailing_content'];?></p>
                        </div>
					</div>
                </div>
        </div>   
    </section>
    <?php
    endif;
    $contact_bottom = get_field('section_bottom');
    if($contact_bottom): 
    ?>
    
    <section class="section-contact-info">
        <div class="container">
        <hr class="separator-xl">
            <div class="row">
					<div class="col l8 s12">
                    <h3><?php echo $contact_bottom['botom_title'];?></h3>
                    <?php echo $contact_bottom['bottom_content'];?>
					</div>
                </div>
        </div>   
    </section>
    <?php
    endif;
}

genesis();