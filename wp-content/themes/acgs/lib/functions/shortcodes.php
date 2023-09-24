<?php
/*
Button
---------------------------------------------------------------------------------------------------- */
// Example usage 1
// [button href="YOUR LINK" target="self"]Button Text[/button]
// Example usage 2
// [button href="YOUR LINK" target="self" text="Button Text"]

function myprefix_button_shortcode( $atts, $content = null ) {
	
	// Extract shortcode attributes
	extract( shortcode_atts( array(
		'url'    => '',
		'title'  => '',
		'target' => '',
        'text'   => '',
        'align'  => 'left',
		'color'  => 'green',
	), $atts ) );

	// Use text value for items without content
	$content = $text ? $text : $content;

	// Return button with link
	if ( $url ) {

		$link_attr = array(
			'href'   => esc_url( $url ),
			'title'  => esc_attr( $title ),
			'target' => ( 'blank' == $target ) ? '_blank' : '',
			'class'  => 'base-button color-'.esc_attr( $color ),
		);

		$link_attrs_str = '';

		foreach ( $link_attr as $key => $val ) {

			if ( $val ) {

				$link_attrs_str .= ' '. $key .'="'. $val .'"';

			}

		}


		return '<p style="text-align: '.$atts['align'].'"><a'. $link_attrs_str .'><span>'. do_shortcode( $content ) .'</span> <i class="fas fa-angle-right"></i></a></p>';

	}

	// No link defined so return button as a span
	else {

		return '<p style="text-align: '.$atts['align'].'"><span class="myprefix-button"><span>'. do_shortcode( $content ) .'</span></span></p>';

	}

}
add_shortcode( 'button', 'myprefix_button_shortcode' );

function transparent_button_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'url'    => '',
		'title'  => '',
		'target' => '',
        'text'   => '',
		'color'  => 'white',
	), $atts ) );

	return '<a href="'.$url.'" class="btn-transparent '.$color.'" target="'.$target.'" title="'.$title.'">'.$content.'</a>';

}
add_shortcode( 'button_link', 'transparent_button_shortcode' );

/**********************
*   Product List Shortcode
**********************/
add_shortcode('product-list', 'product_list_shortcode');
function product_list_shortcode($atts, $content) {    
	global $post;
	// Extract shortcode attributes
	extract( shortcode_atts( array(
		'limit'    => '-1',
	), $atts ) );
    
    $settings = array(
        'posts_per_page' => $limit, 
        'post_type' => 'product', 
        'orderby' => 'date', 
        'order' => 'DESC', 
    );

    global $wp_query;
    
    $wp_query = new WP_Query( $settings );
        
    $list = '<div class="row product-list">';
    $wp_query = new WP_Query( $settings );
    if(have_posts()):
        while ( have_posts() ) : the_post();
            $list .= '
            <div class="col s4 product-item">
				<div class="product-contenetor">
					<div class="product-content">
						<a href="'.get_field('link').'"><h4>'.get_the_title().'</h4></a>
						<p>'.get_the_excerpt().'</p>
					</div>
					<a class="link-product" href="'.get_field('link').'" >Buy Now</a>
                </div>
            </div>';
        endwhile;        
        // do_action( 'genesis_after_endwhile' );
    endif;
    wp_reset_query();
    $list.= '</div>';

    return $list;
}

/**********************
*   Product Slider Shortcode
**********************/
add_shortcode('product-slider', 'product_slider_shortcode');
function product_slider_shortcode($atts, $content) {    
	global $post;
	// Extract shortcode attributes
	extract( shortcode_atts( array(
		'limit'    => '-1',
	), $atts ) );
    
    $settings = array(
        'posts_per_page' => $limit, 
        'post_type' => 'product', 
        'orderby' => 'date', 
        'order' => 'DESC', 
    );

    global $wp_query;
    
    $wp_query = new WP_Query( $settings );
        
    $list = '<div class="product-slider">';
    $wp_query = new WP_Query( $settings );
    if(have_posts()):
		while ( have_posts() ) : the_post();
            $list .= '
            <div class="product-item">
				<div class="product-content">
					<div class="product-contenetor">
						<div class="product-content">
							<a href="'.get_permalink().'"><h4>'.get_the_title().'</h4></a>
							<p>'.get_the_excerpt().'</p>
						</div>
					</div>
                </div>
            </div>';
        endwhile;        
        // do_action( 'genesis_after_endwhile' );
    endif;
    wp_reset_query();
    $list.= '</div>';

    return $list;
}

/*  Binnacle shortcode
******************************/
function binnacle_member_shortcode() {
    global $wpdb;

    $access = true;

    if( is_user_logged_in() ) {
        $user = wp_get_current_user();
        $roles = (array)$user->roles;
        if( false === in_array('administrator', $roles) ) { 
            $access = false;
        }
    }

    if( $access == true ) {

        $page = filter_var($_GET['cpage'], FILTER_VALIDATE_INT );
        $page = $page === false? 1 : $page;

        $table = $wpdb->prefix . 'binnacle_member';
        $tblUsr = $wpdb->prefix . 'users';
        $total  = $wpdb->get_var("SELECT count(*) FROM $table GROUP BY user_id");
        $per_page = 20;
        $rows  = $wpdb->get_results("SELECT b.*, u.display_name FROM $table b JOIN $tblUsr u ON b.user_id = u.ID"
                    ." GROUP BY b.user_id ORDER BY b.edited_at DESC limit ".(($page - 1) * $per_page).", {$per_page}", ARRAY_A
        );
        $pages = ceil($total / $per_page);

        ob_start();
        ?>
        <div class="binnacle-content">
            <h2>Edits by user</h2>
            <!-- Binnacle list -->
            <table class="tbl-binnacle">
                <tr>
                    <th class="th-user">User</th>
                    <th>Last Edition</th>
                    <th></th>
                </tr>
            <?php if($rows):?>

                <?php foreach ($rows as $row): 
                    $metadata = unserialize($row['metadata']);
                ?>
                <tr>
                    <td><?php echo $row['display_name']; ?> </td>
                    <td width="70%"><span class="bi-date">
                        <?php echo date( 'm/d/Y h:i',strtotime($row['edited_at'])); ?>
                    </span></td>
                    <td align="right">
                        <div class="text-right">
                            <a  href="<?php echo add_query_arg( array('uid'=>$row['user_id']), site_url( '/member-logs-detail' ) ); ?>" title="Detail" class="base-button sm color-red">
                                detail
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </table>
            <!-- End Binnacle list -->

        <!-- pagination -->
        <?php 
        echo '<div class="blog-pagination">';
        echo paginate_links( array(
            'base' => add_query_arg( 'cpage', '%#%' ),
            'format' => '',
            'prev_text' => __('&laquo;'),
            'next_text' => __('&raquo;'),
            'total' => $pages,
            'current' => $page
        ));
        echo '</div>';
        ?>
        <!-- End pagination -->

        </div> <!-- End binnacle-content -->
        <?php
    }
    else {
        ob_start();
        ?>
        <article >
            <h1 class="entry-title" itemprop="headline"> <?php echo apply_filters('genesis_404_entry_title', __('Not found, error 404', 'genesis')); ?></h1>
            <div>
                <p><?php 
                echo sprintf(__('The page you are looking for no longer exists. Perhaps you can return back to the site\'s <a href="'.get_site_url().'">homepage</a> and see if you can find what you are looking for. Or, you can try finding it by using the search form below.', 'genesis') , trailingslashit(home_url()));
                ?></p>
            </div>
        </article>
        <?php
    }
    
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
}
add_shortcode( 'binnacle_members', 'binnacle_member_shortcode' );

function binnacle_member_detail_shortcode() {
    global $wpdb;

    $access = true;

    if( is_user_logged_in() ) {
        $user = wp_get_current_user();
        $roles = (array)$user->roles;
        if( false === in_array('administrator', $roles) ) { 
            $access = false;
        }
    }

    if($access === true) {

        $page = filter_var($_GET['cpage'], FILTER_VALIDATE_INT );
        $user_id = filter_var($_GET['uid'], FILTER_VALIDATE_INT );

        $user_id = $user_id === false? 0 : $user_id;
        $page = $page === false? 1 : $page;

        $table = $wpdb->prefix . 'binnacle_member';
        $tblUsr = $wpdb->prefix . 'users';
        $per_page = 12;

        $total = $wpdb->get_var("SELECT count(*) FROM $table b WHERE b.user_id = {$user_id}");
        $rows  = $wpdb->get_results("SELECT b.*, u.display_name FROM $table b JOIN $tblUsr u ON b.user_id = u.ID"
                    ." WHERE b.user_id = {$user_id}"
                    ." ORDER BY b.edited_at DESC limit ".(($page - 1) * $per_page).", {$per_page}", ARRAY_A
        );
        $pages = ceil($total / $per_page);

        $cur_date = date('m/d/Y');

        ob_start();

        $field_titles = [
                'first_name'  => 'First Name',
                'middle_name' => 'Middle Init',
                'last_name'   => 'Last Name',
                'user_email'  => 'E-mail Address',
                'country_region'  => 'Country/Region',
                'address'         => 'Address',
                'address2'        => 'Address Line2',
                'city'            => 'City',
                'state_province'  => 'State/Province',
                'zipcode'         => 'Zip/Postal Code',
                'phone'           => 'Home Phone',
                'billing_company' => 'Company',
            ];
        ?>
        <!-- Binnacle list -->
        <div class="tbl-binnacle-wrap">
            
            <table class="tbl-binnacle-detail">
                <tr>
                    <th>Date</th>
                    <th>Changes</th>
                    <th></th>
                </tr>
            <?php if($rows): ?>

                <?php foreach ($rows as $row): 
                    $metadata = unserialize($row['metadata']);
                    $diff_data = unserialize($row['diff_data']);
                    $bi_date   = date( 'm/d/Y',strtotime($row['edited_at']));

                    // Separate showing fields (3 by default) and put all other field to extra fields array
                    $show_fields = [];
                    $extra_fields = [];
                    $field_count = 0;

                    foreach ($diff_data as $key => $value) {
                        if( isset($field_titles[$key]) && isset($metadata[$key]) ) {
                            if( $field_count < 3 ) {
                                $show_fields[$key] = $metadata[$key];
                            }
                            else {
                                $extra_fields[$key] = $metadata[$key];
                            }
                            $field_count++;
                        }
                    }

                    $collapse_id = 'collapse_'.$row['ID'];
                ?>
                <tr class="<?php echo strcmp($cur_date, $bi_date) == 0? 'today-row' : ''; ?>">
                    <td class="relative">
                        <span class="binnacle-date">
                            <?php echo $bi_date; ?> <br>
                            <?php echo date( 'h:i',strtotime($row['edited_at'])); ?>
                        </span>
                    </td>
                    <td>
                        <div class="binnacle-field binnacle-field-heading">
                            <p class="binacle-field-title">&nbsp;</p>
                            <div class="old-value">Old</div>
                            <p class="binnacle-field-change">New</p>
                        </div>
                        <?php foreach ($show_fields as $key => $value):
                            ?>
                            <div class="binnacle-field">
                                <p class="binacle-field-title"><?php echo $field_titles[$key]; ?></p>
                                <div class="old-value"><span><?php echo $value? $value: '&nbsp;'; ?></span></div>
                                <p class="binnacle-field-change"><?php echo $diff_data[$key]? $diff_data[$key]: '&nbsp;'; ?></p>
                            </div>
                        <?php endforeach; ?>

                        <?php if( !empty( $extra_fields ) ): ?>
                        <div class="binnacle-collapse" id="<?php echo $collapse_id; ?>">
                            <div class="collapse-inner">
                            <?php foreach ($extra_fields as $key => $value):
                                ?>
                                <div class="binnacle-field">
                                    <p class="binacle-field-title"><?php echo $field_titles[$key]; ?></p>
                                    <div class="old-value"><span><?php echo $value? $value: '&nbsp;'; ?></span></div>
                                    <p class="binnacle-field-change"><?php echo $diff_data[$key]? $diff_data[$key]: '&nbsp;'; ?></p>
                                </div>
                            <?php endforeach; ?>
                            </div>
                        </div>
                        <a href="#<?php echo $collapse_id; ?>" class="binnacle-collapse-link" trigger-collapse>
                            <span class="show-more">show more...</span>
                            <span class="show-less">show less</span>
                        </a>
                        <?php endif; ?>
                    </td>
                    <td align="right">
                        <a href="#modal_delete_binnacle" class="modal-trigger base-button btn-round color-red" title="Delete" data-binnacle-confirm-remove="<?php echo date( 'm/d/Y h:i',strtotime($row['edited_at'])); ?>" id="<?php echo $row['ID']; ?>"><i class="fas fa-times"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </table>
        </div>
        
        <!-- delete confirmation modal -->
        <div id="modal_delete_binnacle" class="modal modal-message">
            <div class="modal-content">
                <button class="close"><i class="far fa-times-circle modal-close"></i></button>
              <h2 class="center ">Confirm Deletion</h2>
              <p id="confirm_delete_message" class="center">&nbsp;</p>
              <div class="center modal-buttons">
                  <a href="#!" class="modal-close base-button color-red" data-binnacle-remove="">Delete</a>
                  <button class="modal-close base-button color-blue">Cancel</button>
              </div>
            </div>
        </div>
        <!-- End delete confirmation modal -->

        <!-- pagination -->
        <?php 
        echo '<div class="blog-pagination">';
        echo paginate_links( array(
            'base' => add_query_arg( 'cpage', '%#%' ),
            'format' => '',
            'prev_text' => __('&laquo;'),
            'next_text' => __('&raquo;'),
            'total' => $pages,
            'current' => $page
        ));
        echo '</div>';
        ?>
        <!-- End pagination -->

        <p><a href="<?php echo site_url( '/member-logs'); ?>" id="binnacle_back_link" >
            <i class="fas fa-angle-left"></i>&nbsp;Back
            </a>
        </p>
        <?php
        if( $page > $pages ) {
            $page = $page > 1? $page - 1 : 1;
            $url = wp_make_link_relative( 'member-logs-detail/' );
            $url = get_site_url() . '/' . $url . '?uid='.$user_id.'&cpage='.$page;
            echo "<script>document.location.href='".$url."'</script>";
        }
        ?>
        <!-- End Binnacle list -->
        <?php
    }
    else {
        ob_start();
        ?>
        <article >
            <h1 class="entry-title" itemprop="headline"><?php echo apply_filters('genesis_404_entry_title', __('Not found, error 404', 'genesis')); ?></h1>
            <div>
                <p><?php 
                echo sprintf(__('The page you are looking for no longer exists. Perhaps you can return back to the site\'s <a href="'.get_site_url().'">homepage</a> and see if you can find what you are looking for. Or, you can try finding it by using the search form below.', 'genesis') , trailingslashit(home_url()));
                ?></p>
            </div>
        </article>
        <?php
    }

    $html = ob_get_contents();
    ob_end_clean();

    return $html;
}
add_shortcode( 'binnacle_member_detail', 'binnacle_member_detail_shortcode' );