<?php
/*
 Plugin Name: categories sidebar
Plugin URI: http://pankajanupam.com/wordpress-plugins/categories-sidebar/
Description: Create a diffrent sidebar to diffrent categories
Version: 2.0
Author: BigBrother
Author URI: http://pankajanupam.com

* LICENSE
Copyright 2011 PANKAJ ANUPAM  (email : mymail.anupam@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// create sidebar for all the categories
add_action('widgets_init', '_categories_sidebar');

function _categories_sidebar(){

	$categories = get_categories();
	foreach($categories as $cat){
		register_sidebar( array(
		'name' => $cat->name,
		'id' => 'sidebar_'.$cat->term_id,
		'description' => 'Appears in related categoires pages.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
		) );
	}
}

// filter sidbars_widgets and replicate all index with same id
add_filter('sidebars_widgets', '_custom_sidebar',1,99);

function _custom_sidebar($sidebars_widgets){

	if( is_category() && ! is_admin() ){

		$cat_id = get_query_var('cat');

		$_sidebar_widget = $sidebars_widgets['sidebar_'.$cat_id];

		foreach ($sidebars_widgets as $key=>$val){
			$sidebars_widgets[$key] = $_sidebar_widget;
		}
	}
	return $sidebars_widgets;
}

?>