<?php

// Short code to display cafeteria menu table
function cafeteria_get_loop( $atts ) {
    // Gets every "category" (term) in this taxonomy to get the respective posts

    global $post;
    $current_id = $post->ID;

    /* grab the url for the full size featured image */
    $featured_img_url = get_the_post_thumbnail_url($current_id,'full'); 

    $terms_week = get_terms( 'cafeteria_week', array(
        'orderby'    => 'ID'
    ) );

    $terms_day = get_terms( 'cafeteria_day', array(
        'orderby'    => 'ID'
    ) );

    the_post_thumbnail('full');

    echo '<table>';

    echo '<tr>';
        echo '<td style="font-weight: 600; text-align: center;">';
            echo '#';
        echo '</td>';
    foreach($terms_day as $term_day) {
        echo '<td style="font-weight: 600; text-align: center;">';
            echo $term_day->name;
        echo '</td>';
    }
    echo '</tr>';
    
    foreach($terms_week as $term_week) {

        echo '<tr>';
        
        echo '<td style="font-weight: 600; text-align: center;">';
            echo  $term_week->name;
        echo '</td>';

        foreach($terms_day as $term_day) {

            echo '<td>';

            $get_cafeteria_menu_args = array(
                'post_type' => 'cafeteria',
                'posts_per_page' => -1,
                'orderby' => 'ID',
                'order' => 'ASC',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'cafeteria_week',
                        'field' => 'term_id',
                        'terms' => $term_week->term_id,
                        'orderby' => 'name',
                        'order' => 'ASC',
                    ),
                    array(
                        'taxonomy' => 'cafeteria_day',
                        'field' => 'term_id',
                        'terms' => $term_day->term_id,
                        'orderby' => 'name',
                        'order' => 'ASC',
                    )
                )
            ); 
            $get_cafeteria_menus = get_posts( $get_cafeteria_menu_args );

            $count = 0;

            foreach ($get_cafeteria_menus as $get_cafeteria_menu) {
                $count = $count + 1;
                echo '#' . $count . ' ';         
                ?><a href="<?php print_r($get_cafeteria_menu->guid); ?>" style="padding: 0;"><?php print_r($get_cafeteria_menu->post_title); ?></a><?php
                print_r(apply_filters('the_content', $get_cafeteria_menu->post_excerpt));
            }

            echo '</td>';

        }

        echo '</tr>';
        
    }  
    echo '</table>';      
}
add_shortcode('cafeteria_get_shortcode', 'cafeteria_get_loop');

?>