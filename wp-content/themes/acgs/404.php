<?php
/**
* Description: error 404 page
*/


remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'acgs_404');


function acgs_404() {
	ob_start();
	?>
	<article class="entry">
		<h1 class="entry-title" itemprop="headline">
			<?php echo apply_filters('genesis_404_entry_title', __('Not found, error 40', 'genesis')); ?>
		</h1>
		<div class="entry-content">
			<p><?php 
			echo sprintf(__('The page you are looking for no longer exists. Perhaps you can return back to the site\'s <a href="'.get_site_url().'">homepage</a> and see if you can find what you are looking for. Or, you can try finding it by using the search form below.', 'genesis') , trailingslashit(home_url()));
			?></p>
		</div>
	</article>
	<?php
	$html = ob_get_contents();
	ob_end_clean();
	echo $html;
}

genesis();