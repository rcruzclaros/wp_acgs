<?php
	//Get a single fields values using labels
	//replace `1526` with the ID of your search form
	global $searchandfilter;
	$sf_current_query = $searchandfilter->get(188)->current_query();
	echo $sf_current_query->get_field_string("_sft_category");
	
?>