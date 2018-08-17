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

 /*
* Creating a function to create our CPT
*/
 
function cafeteria_post_type() {
 
    // Set UI labels for cafeteria Post Type
        $labels = array(
            'name'                => _x( 'Cafeteria Menu', 'Post Type General Name', 'twentythirteen' ),
            'singular_name'       => _x( 'Cafeteria Menus', 'Post Type Singular Name', 'twentythirteen' ),
            'menu_name'           => __( 'Cafeteria Menu', 'twentythirteen' ),
            'parent_item_colon'   => __( 'Parent Cafeteria', 'twentythirteen' ),
            'all_items'           => __( 'All Menu', 'twentythirteen' ),
            'view_item'           => __( 'View Cafeteria', 'twentythirteen' ),
            'add_new_item'        => __( 'Add New Menu', 'twentythirteen' ),
            'add_new'             => __( 'Add New', 'twentythirteen' ),
            'edit_item'           => __( 'Edit menu', 'twentythirteen' ),
            'update_item'         => __( 'Update menu', 'twentythirteen' ),
            'search_items'        => __( 'Search menu', 'twentythirteen' ),
            'not_found'           => __( 'Not Found', 'twentythirteen' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
        );
         
    // Set other options for cafeteria Post Type
         
        $args = array(
            'label'               => __( 'Cafeteria Menu', 'twentythirteen' ),
            'description'         => __( 'Cafeteria news and reviews', 'twentythirteen' ),
            'labels'              => $labels,
            // Features this CPT supports in Post Editor
            'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions' ),
            // You can associate this CPT with a taxonomy or custom taxonomy.
            'taxonomies'          => array( 'cafeteria_day', 'cafeteria_week' ),
            /* A hierarchical CPT is like Pages and can have
            * Parent and child items. A non-hierarchical CPT
            * is like Posts.
            */ 
            'hierarchical'        => false,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
        );
         
        // Registering your cafeteria Post Type
        register_post_type( 'cafeteria', $args );
     
    }
     
    /* Hook into the 'init' action so that the function
    * Containing our post type registration is not 
    * unnecessarily executed. 
    */
     
    add_action( 'init', 'cafeteria_post_type', 0 );

    function themes_taxonomy() {  
        register_taxonomy(  
            'cafeteria_day',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces). 
            'cafeteria',        //post type name
            array(  
                'hierarchical' => true,  
                'label' => 'Cafeteria Day',  //Display name
                'query_var' => true,
                'show_admin_column' => true,
                'show_ui' => true,
                'show_in_quick_edit' => false,
                'meta_box_cb' => false,
                'hierarchical' => true,
                'rewrite' => array(
                    'slug' => 'cafeteriaday', // This controls the base slug that will display before each term
                    'with_front' => false // Don't display the category base before 
                )
            )  
        );  
        register_taxonomy(  
            'cafeteria_week',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces). 
            'cafeteria',        //post type name
            array(  
                'hierarchical' => true,  
                'label' => 'Cafeteria Week',  //Display name
                'query_var' => true,
                'show_admin_column' => true,
                'show_ui' => true,
                'show_in_quick_edit' => false,
                'meta_box_cb' => false,
                'hierarchical' => true,
                'rewrite' => array(
                    'slug' => 'cafeteriaweek', // This controls the base slug that will display before each term
                    'with_front' => false // Don't display the category base before 
                )
            )  
        ); 
    }  
    add_action( 'init', 'themes_taxonomy');

    add_action('admin_menu' , 'add_to_cafeteria_menu'); 

    function add_to_cafeteria_menu() {
        add_submenu_page('edit.php?post_type=cafeteria', 'Cafeteria Admin', 'Cafeteria Settings', 'edit_posts', basename(__FILE__), 'cpt_menu_function');
    }   

?>