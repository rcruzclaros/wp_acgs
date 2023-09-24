<?php
/**
* Template Name: Search Ceremony events
* Description: Used as a page template to show a searchable form to find ceremonies stuff
*/

// Add our custom loop
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_after_header', 'search_stuff_content' );
function search_stuff_content() {
    global $wpdb;

    $prefix = $wpdb->prefix;

    // prishes fetch
    $parishes = get_option( 'acgs_parishes', array() );
    if ( $parishes ) {
        $parishes = unserialize($parishes);
    }
    else {
        $sql = "SELECT DISTINCT(tparish.parish) parish "
                ."FROM "
                ."( SELECT DISTINCT(event_parish) parish FROM {$prefix}ag_baptism "
                ."UNION "
                ."SELECT DISTINCT(recordpari) parish FROM {$prefix}ag_burial "
                ."UNION "
                ."SELECT DISTINCT(marparish) parish FROM {$prefix}ag_marriage ) as tparish";

        $results = $wpdb->get_results($sql, ARRAY_A);
        $parishes = array_column($results, 'parish');
        $parishes = array_filter($parishes); // remove empty values
        update_option( 'acgs_parishes', serialize($parishes) );
    }

    // places fetch
    $places = get_option( 'acgs_ceremony_places', array() );
    if ( $places ) {
        $places = unserialize($places);
    }
    else {
        $sql = "SELECT DISTINCT(place) "
                ."FROM "
                ."(SELECT DISTINCT (bapt_place) place FROM {$prefix}ag_baptism WHERE bapt_place REGEXP '[_0-9\-]+' = 0 "
                ."AND char_length(bapt_place) > 6 "
                ."UNION "
                ."SELECT DISTINCT (recordplac) place FROM {$prefix}ag_burial WHERE recordplac REGEXP '[_0-9\-]+' = 0 "
                ."AND char_length(recordplac) > 6 "
                ."UNION "
                ."SELECT DISTINCT (marplace) place FROM {$prefix}ag_marriage WHERE marplace REGEXP '[_0-9\-]+' = 0 "
                ."AND char_length(marplace) > 6) as tp "
                ."ORDER BY tp.place ";

        $results = $wpdb->get_results($sql, ARRAY_A);
        $places = array_column($results, 'place');
        $places = array_filter($places); // remove empty values
        update_option( 'acgs_ceremony_places', serialize($places) );
    }
    ?>
    <div class="ceremony-events-contents">
        <section class="section-list-filter">
            <div class="container">
                <form id="events_search_form" >
                    <ul>

            <li class="sf-field-taxonomy-state" data-sf-field-name="_sft_state" data-sf-field-type="taxonomy" data-sf-field-input-type="select">
                        <h4>Full Name</h4>        
                        <label>
                            <input type="text" name="fullname" class="sf-input-text">
                        </label>        
            </li>
            <li class="sf-field-taxonomy-town" data-sf-field-name="_sft_town" data-sf-field-type="taxonomy" data-sf-field-input-type="select">
                    <h4>Last Name</h4>        
                    <label>
                        <input type="text" name="lname" class="sf-input-text">
                    </label>        
            </li>
            <li class="sf-field-taxonomy-parish" >
                    <h4>Parishes</h4>        
                    <label>
                    <select name="parish" class="sf-input-select">
                            <option class="sf-level-0 sf-item-0 sf-option-active" selected="selected" data-sf-count="0" data-sf-depth="0" value="">All Parishes</option>
                        
                        <?php foreach( $parishes as $parish ): ?>
                            <option class="sf-level-0 sf-item-0 sf-option-active" data-sf-count="0" data-sf-depth="0" value="<?php echo $parish; ?>"><?php echo $parish; ?></option>
                        <?php endforeach; ?>
                    </select>
                    </label>        
            </li>
            <li class="sf-field-taxonomy-event-product" >
                    <h4>Place</h4>   
                    <label>
                    <select name="city" class="sf-input-select" title="">
                
                            <option class="sf-level-0 sf-item-0 sf-option-active" selected="selected" data-sf-count="0" data-sf-depth="0" value="">All Places</option>

                            <?php foreach( $places as $place ): ?>
                            <option class="sf-level-0 sf-item-154" data-sf-count="74" data-sf-depth="0" value="<?php echo $place; ?>"><?php echo $place; ?></option>
                            <?php endforeach; ?>
                    </select>
                    </label>
            </li>
            <li class="ceremony-event-field-type" >
                    <h4>Type</h4>   
                    <label>
                    <select name="type" class="sf-input-select" title="">
                
                            <option class="sf-level-0 sf-item-0 sf-option-active" selected="selected" data-sf-count="0" data-sf-depth="0" value="">All</option>
                            <option class="sf-level-0 sf-item-154" data-sf-count="74" data-sf-depth="0" value="baptism">Baptism</option>
                            <option class="sf-level-0 sf-item-154" data-sf-count="74" data-sf-depth="0" value="burial">Burial</option>
                            <option class="sf-level-0 sf-item-154" data-sf-count="74" data-sf-depth="0" value="marriage">Marriage</option>
                    </select>
                    </label>
            </li>
            <li class="sf-field-submit" data-sf-field-name="submit" data-sf-field-type="submit" data-sf-field-input-type=""><input type="submit" name="events_search_submit" value="Search">
            </li>

                    </ul>
                </form>        
            </div>   
        </section>

        <div class="container">
            <div class="search-filter-results" id="search_events_results">
            </div>
        </div>
    </div>
    <?php
}

genesis();