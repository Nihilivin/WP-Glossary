<?php
/**
  * @copyright 2015-2016 iThoughts Informatique
  * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.fr.html GPLv2
  */

namespace ithoughts\tooltip_glossary;

if ( ! defined( 'ABSPATH' ) ) { 
	exit; // Exit if accessed directly
}

if(!class_exists(__NAMESPACE__."\\Taxonomies")){
	class Taxonomies extends \ithoughts\v1_0\Singleton{
		public function __construct() {
			add_action( 'init', array(&$this, 'register_taxonomies'), 0 );
		}

		public function register_taxonomies(){
			$labels = array(
				'name'              => __( 'Glossary Groups', 'ithoughts-tooltip-glossary' ),
				'singular_name'     => __( 'Glossary Group', 'ithoughts-tooltip-glossary' ),
				'search_items'      => __( 'Search Glossary Groups', 'ithoughts-tooltip-glossary' ),
				'all_items'         => __( 'All Glossary Groups', 'ithoughts-tooltip-glossary' ),
				'parent_item'       => __( 'Parent Glossary Group', 'ithoughts-tooltip-glossary' ),
				'edit_item'         => __( 'Edit Glossary Group', 'ithoughts-tooltip-glossary' ),
				'update_item'       => __( 'Update Glossary Group', 'ithoughts-tooltip-glossary' ),
				'add_new_item'      => __( 'Add New Glossary Group', 'ithoughts-tooltip-glossary' ),
				'new_item_name'     => __( 'New Glossary Group Name', 'ithoughts-tooltip-glossary' ),
				'menu_name' => __('Glossary Groups', 'ithoughts-tooltip-glossary' )
			);

			$backbone = \ithoughts\tooltip_glossary\Backbone::get_instance();
			$options = $backbone->get_options();
			register_taxonomy( 'glossary_group', "glossary", array(
				'hierarchical'      => false,
				'labels'            => $labels,
				'show_ui'           => true,
				'query_var'         => true,
				'show_admin_column' => true,
				'rewrite'           => array( 'slug' => $options["termtype"].'/'.$options["grouptype"]),
			) );
		} // register_taxonomies
	} // Taxonomies
}