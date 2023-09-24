<?php
/**
* Template Name: Member Institutions
* Description: Used as a page template to show page contents, followed by a loop 
* through the "Member Individual"
*/
// Add our custom loop
add_action( 'genesis_after_header', 'individual_options' );
function individual_options() {
    echo '<p>&nbsp;</p><div class="site-inner"><ul class="collapsible-acgs custom-login-details">
                <li>
                    <div class="collapsible-header">
                        <i class="fas fa-male left-icon"></i>
                        <h5>Institutions</h5>
                    </div>
                </li></ul></div>';
    echo '<div class="wrap"><div class="membership-options">';
        echo '<ul>';
            echo '<li variation="6852" class=""><strong>$50.00(US)</strong> per year, American residents.</li>';
            echo '<li variation="6853" class=""><strong>$50.00(US)</strong> per year, Canadian residents.</li>';
        echo '</ul>';
        echo '<div class="unique_url" url="'.get_site_url().'?add-to-cart=793"></div>';
    echo '</div></div>';
}

add_action( 'genesis_after_entry', 'individual_submit' );
function individual_submit(){
    echo '<a href="'.get_site_url().'?add-to-cart=793" class="get-memberships disabled base-button color-red">BECOME A MEMBER</a>';
}


genesis(); 