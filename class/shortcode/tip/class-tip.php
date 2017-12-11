<?php

/**
 * @file Class file for HTML tooltips shortcode
 *
 * @author Gerkin
 * @copyright 2016 GerkinDevelopment
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @package ithoughts-tooltip-glossary
 *
 * @version 2.7.0
 */


/**
 * @copyright 2015-2016 iThoughts Informatique
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPLv3
 */

namespace ithoughts\tooltip_glossary\shortcode\tip;

if ( ! defined( 'ABSPATH' ) ) {
	status_header( 403 );
	wp_die( 'Forbidden' );// Exit if accessed directly
}


if ( ! class_exists( __NAMESPACE__ . '\\Tooltip' ) ) {
	abstract class Tip extends \ithoughts\v1_0\Singleton {
		public function __construct() {
		}

		public function shortcode_to_tinymce_dom($str){
			return preg_replace( '/<a\s+?data-tooltip-content=\\\\"(.+?)\\\\".*>(.*?)<\/a>/', '[itg-tooltip content="$1"]$2[/itg-tooltip]', $str );
		}

		public function tinymce_dom_to_shortcode($str){
			return preg_replace( '/\[itg-tooltip(.*?)(?: content="(.+?)")(.*?)\](.+?)\[\/itg-tooltip\]/', '<a data-tooltip-content="$2" $1 $3>$4</a>', $str );
		}

		public function parse_pseudo_links_to_shortcode( $data ) {
			$data['post_content'] = $this->shortcode_to_tinymce_dom( $data['post_content'] );
			return $data;
		}

		public function convert_shortcodes( $post_id, $post = NULL ) {
			if(NULL === $post){
				$post = get_post( $post_id );
			}
			$post->post_content = $this->tinymce_dom_to_shortcode( $post->post_content );
			return $post;
		}

		/** */
		public function tooltip_shortcode( $atts, $text = '' ) {
			$datas = apply_filters( 'ithoughts_tt_gl-split-args', $atts );

			$content = (isset( $datas['handled']['tooltip-content'] ) && $datas['handled']['tooltip-content']) ? $datas['handled']['tooltip-content'] : '';

			return apply_filters( 'ithoughts_tt_gl_tooltip', $text, $content, $datas );
		}

		/**
		 * Create a tooltip HTML markup with given text content $text, tooltip content $tip & provided options $options
		 *
		 * @author Gerkin
		 * @param  string  $text    Text content of the highlighted word
		 * @param  string  $tip     Text content into the tooltip
		 * @param  [array] $options Attributes & other options modifying the behaviour of the HTML generation. Usually provided by filter `ithoughts_tt_gl-split-args`
		 * @return string The formatted HTML markup
		 */
		public function generate_tooltip( $text, $tip, $options = array(
			'linkAttrs' => array(),
			'attributes' => array(),
		) ) {
			// Set text to default to content. This allows syntax like: [glossary]Cheddar[/glossary]
			if ( empty( $tip ) ) {
				$tip = $text;
			}
			$tip = esc_attr($tip);

			$backbone = \ithoughts\tooltip_glossary\Backbone::get_instance();
			$backbone->add_script( 'qtip' );

			// qtip jquery data
			if ( ! (isset( $options['linkAttrs']['href'] ) && $options['linkAttrs']['href']) ) {
				$options['linkAttrs']['href'] = 'javascript:void(0);';
			}
			if ( ! (isset( $datas['linkAttrs']['title'] ) && $options['linkAttrs']['title']) ) {
				$options['linkAttrs']['title'] = esc_attr( $text );
			}

			$linkArgs = \ithoughts\v6_0\Toolbox::concat_attrs( $options['linkAttrs'] );
			$link   = '<a ' . $linkArgs . '>' . $text . '</a>';

			// Span that qtip finds
			$options['attributes']['class'] = 'itg-tooltip' . ((isset( $options['attributes']['class'] ) && $options['attributes']['class']) ? ' ' . $options['attributes']['class'] : '');
			$options['attributes']['data-tooltip-content'] = do_shortcode( $tip );

			$args = \ithoughts\v6_0\Toolbox::concat_attrs( $options['attributes'] );
			$span = '<span ' . $args . '>' . $link . '</span>';

			return $span;
		}
	}
}// End if().
