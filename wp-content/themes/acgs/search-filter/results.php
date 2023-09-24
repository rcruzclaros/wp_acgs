<?php
/**
 * Search & Filter Pro 
 *
 * Sample Results Template
 * 
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      http://www.designsandcode.com/
 * @copyright 2014 Designs & Code
 * 
 * Note: these templates are not full page templates, rather 
 * just an encaspulation of the your results loop which should
 * be inserted in to other pages by using a shortcode - think 
 * of it as a template part
 * 
 * This template is an absolute base example showing you what
 * you can do, for more customisation see the WordPress docs 
 * and using template tags - 
 * 
 * http://codex.wordpress.org/Template_Tags
 *
 */

if ( $query->have_posts() )
{	
	echo '<div class="row product-list">';
	$res_f = '';$res = '';
	while ($query->have_posts())
	{
		$query->the_post();
			
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' );
			echo '<div class="col l4 m6 s12 product-item">';
				echo '<div class="product-contenetor">';
					echo '<div class="product-content">';
						echo '<div style="text-align:center;"><img src="'.$image[0].'" style="margin-bottom:10px;" /></div>';
						echo '<a href="'.get_permalink().'"><h4>'.get_the_title().'</h4></a>';
						echo '<p>'.get_the_excerpt().'</p>';
					echo '</div>';
					echo '<a class="link-product" href="'.get_permalink().'" >Buy Now</a>';
				echo '</div>';
			echo '</div>';
			
	}
	echo '</div>';
	echo $res_f;echo $res;
	// echo '<div class="pagination"><a href="#" class="myprefix-button color-blue large transparent" style="display:none;"><span>Load More</span></a></div>';
}
else
{
	echo "No Results Found";
}
?>