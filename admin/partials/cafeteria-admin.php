<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://jerl92.tk
 * @since      1.0.0
 *
 * @package    Cafeteria
 * @subpackage Cafeteria/includes
 */

function day_meta_box_markup($object)
{
wp_nonce_field(basename(__FILE__), "meta-box-nonce");
?>
    <div>
        <ul style="display: flex; text-align: center;">

            <li style="padding-right: 10px;">
                
                <?php
                wp_nonce_field('cafeteria_week-dropdown', 'dropdown-cafeteria_week-nonce');
                $terms = get_terms( 'cafeteria_week', 'hide_empty=0');
                if ( is_a( $terms, 'WP_Error' ) ) {
                    $terms = array();
                }
                $object_terms = wp_get_object_terms( $post->ID, 'cafeteria_week' );
                if ( is_a( $object_terms, 'WP_Error' ) ) {
                    $object_terms = array();
                }
                echo "cafeteria_week:";
                echo '</br>';
                echo "<select id='cafeteria_weekoptions' name='customcafeteria_week[]'>";
                $getslugid = wp_get_post_terms( $object->ID, 'cafeteria_week', $args );
                foreach( $getslugid as $thisslug ) {
                    echo "<option value='$thisslug->term_id'>";
                    echo $thisslug->name . ' '; // Added a space between the slugs with . ' '
                    echo "</option>";
                }
                foreach ( $terms as $term ) {
                    if ( $term->parent == 0) {
                        if ( in_array($term->term_id, $object_terms) ) {
                            $parent_id = $term->term_id;
                            echo "<option value='{$term->term_id}' selected='selected'>{$term->name}</option>";
                        } else {
                            echo "<option value='{$term->term_id}'>{$term->name}</option>";
                        }
                    }
                }
                echo "</select><br />"; ?>
            </li>

            <li style="padding-right: 10px;">
                
                <?php
                wp_nonce_field('cafeteria_day-dropdown', 'dropdown-cafeteria_day-nonce');
                $terms = get_terms( 'cafeteria_day', 'hide_empty=0');
                if ( is_a( $terms, 'WP_Error' ) ) {
                    $terms = array();
                }
                $object_terms = wp_get_object_terms( $post->ID, 'cafeteria_day' );
                if ( is_a( $object_terms, 'WP_Error' ) ) {
                    $object_terms = array();
                }
                echo "cafeteria_day:";
                echo '</br>';
                echo "<select id='cafeteria_dayoptions' name='customcafeteria_day[]'>";
                $getslugid = wp_get_post_terms( $object->ID, 'cafeteria_day', $args );
                foreach( $getslugid as $thisslug ) {
                    echo "<option value='$thisslug->term_id'>";
                    echo $thisslug->name . ' '; // Added a space between the slugs with . ' '
                    echo "</option>";
                }
                foreach ( $terms as $term ) {
                    if ( $term->parent == 0) {
                        if ( in_array($term->term_id, $object_terms) ) {
                            $parent_id = $term->term_id;
                            echo "<option value='{$term->term_id}' selected='selected'>{$term->name}</option>";
                        } else {
                            echo "<option value='{$term->term_id}'>{$term->name}</option>";
                        }
                    }
                }
                echo "</select><br />"; ?>
            </li>

        </ul>

    </div>

<?php  
}

function save_custom_meta_box($post_id, $post, $update) {
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
    return $post_id;
    if(!current_user_can("edit_post", $post_id))
        return $post_id;
    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;
    $slug = "cafeteria";
    if($slug != $post->post_type)
        return $post_id;

    if ( !wp_verify_nonce($_POST['dropdown-cafeteria_day-nonce'], 'cafeteria_day-dropdown'))
        return;
    $cafeteria_day = array_map('intval', $_POST['customcafeteria_day']);
    wp_set_object_terms($post_id, $cafeteria_day, 'cafeteria_day');

    if ( !wp_verify_nonce($_POST['dropdown-cafeteria_week-nonce'], 'cafeteria_week-dropdown'))
    return;
    $cafeteria_week = array_map('intval', $_POST['customcafeteria_week']);
    wp_set_object_terms($post_id, $cafeteria_week, 'cafeteria_week');
}
add_action("save_post", "save_custom_meta_box", 10, 3);

function add_custom_meta_box()
{
    add_meta_box("demo-meta-box", "Menu day Information", "day_meta_box_markup", "cafeteria", "normal", "high", null);
}

add_action("add_meta_boxes", "add_custom_meta_box");

 ?>