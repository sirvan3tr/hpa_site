<?php
/**
 * The default Custom post type for Projects
 *
 * @package WordPress
 * @subpackage Charitas
 * @since Charitas 1.1.1
 */
?>
<?php 
if (!function_exists('wpl_projects_cpt')) {
	function wpl_projects_cpt(){
		
		$url_rewrite = ot_get_option('wpl_projects_url_rewrite');
		if( !$url_rewrite ) { $url_rewrite = 'project'; }

		$url_rewrite_name = ot_get_option('wpl_projects_url_rewrite_name');
		if( !$url_rewrite_name ) { $url_rewrite_name = 'Project'; }

		register_post_type('post_projects',
			array(
				'labels' => array(
					'name' => 'Projects',
					'singular_name' => $url_rewrite_name,
					'add_new' => 'Add New Project',
					'add_new_item' => 'Add New Project',
					'edit' => 'Edit',
					'edit_item' => 'Edit Project',
					'new_item' => 'New Project',
					'view' => 'View',
					'view_item' => 'View Projects',
					'search_items' => 'Search Projects',
					'not_found' => 'No Projects found',
					'not_found_in_trash' => 'No Projects found in Trash',
					'parent' => 'Parent Project'
				),
				'description' => 'Easily lets you create some beautiful Projects.',
				'public' => true,
				'show_ui' => true, 
				'_builtin' => false,
				'capability_type' => 'page',
				'hierarchical' => false,
				'rewrite' => array('slug' => $url_rewrite),
				'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
			)
		); 
		flush_rewrite_rules();
	}
	add_action('init', 'wpl_projects_cpt');
}

/*-----------------------------------------------------------------------------------*/
/*	Adding category for projects
/*-----------------------------------------------------------------------------------*/

if (!function_exists('wpl_projects_category')) {
	function wpl_projects_category() {

		$url_rewrite = ot_get_option('wpl_projects_category_url_rewrite');
		if( !$url_rewrite ) { $url_rewrite = 'projects-category'; }

		register_taxonomy('wpl_projects_category', 'post_projects', 
			array( 
				'hierarchical' => true, 
				'labels' => array(
					  'name' => 'Projects Categories',
					  'singular_name' => 'Categories',
					  'search_items' =>  'Search in Category',
					  'popular_items' => 'Popular Categories',
					  'all_items' => 'All Categories',
					  'parent_item' => 'Parent Category',
					  'parent_item_colon' => 'Parent Category:',
					  'edit_item' => 'Edit Category',
					  'update_item' => 'Update Category',
					  'add_new_item' => 'Add New Category',
					  'new_item_name' => 'New Category Name'
				),
				'show_ui' => true,
				'query_var' => true, 
				'rewrite' => array('slug' => $url_rewrite)
			) 
		); 
		flush_rewrite_rules();
	}
	add_action('init', 'wpl_projects_category');
}