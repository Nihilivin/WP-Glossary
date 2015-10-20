<?php
class wpg2_Shortcode_ATOZ Extends wpg2{
    public static $options;

    public function __construct() {
        self::$options = get_option( 'wp_glossary_2' );
        self::$options["termtype"] = is_string(self::$options["termtype"]) ? self::$options["termtype"] : "glossary";
        add_shortcode( 'glossary_atoz', array($this, 'glossary_atoz') );
    }

    public function glossary_atoz( $atts, $content='' ){
        global $post, $tcb_wpg2_scripts;
        extract( shortcode_atts(array('group'=>false,'desc'=>false), $atts) );

        $glossary_options = get_option( 'wp_glossary_2', array() );
        // Let shortcode attributes override general settings
        foreach( $glossary_options as $k => $v ){
            if( isset($atts[$k]) ){
                $jsdata[] = 'data-' . $k . '="' . trim( esc_attr($atts[$k]) ) . '"';
                $glossary_options[$k] = trim( $atts[$k] );
            }
        }
        $tooltip_option   = isset($glossary_options['tooltips'])    ? $glossary_options['tooltips']    : 'excerpt';
        $qtipstyle        = isset($glossary_options['qtipstyle'])   ? $glossary_options['qtipstyle']   : 'cream';
        $linkopt          = isset($glossary_options['termlinkopt']) ? $glossary_options['termlinkopt'] : 'standard';
        $termusage        = isset($glossary_options['termusage'] )  ? $glossary_options['termusage']   : 'on';


        // Global variable that tells WP to print related js files.
        $tcb_wpg2_scripts = true;

        $statii = array( 'publish' );
        if( current_user_can('read_private_posts') ){
            $statii[] = 'private';
        }

        $args = array(
            'post_type'           => "glossary",
            'posts_per_page'      => '-1',
            'orderby'             => 'title',
            'order'               => 'ASC',
            'ignore_sticky_posts' => 1,
            'post_status'         => $statii,
        );

        // Restrict list to specific glossary group or groups
        if( $group ){
            $tax_query = array(
                'taxonomy' => 'wpg2lossarygroup',
                'field'    => 'slug',
                'terms'    => $group,
            );
            $args['tax_query'] = array( $tax_query );
        }

        $list       = '<p>' . __('There are no glossary items.', 'wp-glossary-2') . '</p>';
        $glossaries = get_posts( $args );
        if( !count($glossaries) ) return $list;

        $atoz = array();
        $tofind = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ";
        $replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
        foreach( $glossaries as $post ) {
            setup_postdata( $post );
            $title = get_the_title();
            $alpha = strtoupper( wpg2_unaccent(mb_substr($title,0,1, "UTF-8"), $tofind, $replac, "UTF-8") );

            $link  = '<span class="atoz-term-title">' . $title . '</span>'; // Default to text only
            if( $linkopt != 'none' ){
                $href   = apply_filters( 'wpg2_term_link', get_post_permalink($post->ID) );
                $target = ($linkopt == 'blank') ? 'target="_blank"'  : '';
                $link   = '<a href="' . $href . '" title="' . esc_attr($title) . '" ' . $target . '>' . $title . '</a>';
            }
            if( $desc ){
                $content = ($desc=='excerpt') ? get_the_excerpt() : apply_filters('the_content', get_the_content());
                $content = '<span class="glossary-item-desc">' . $content . '</span>';
            }
            $item  = '<li class="glossary-item atoz-li atoz-li-' . $alpha . '">';
            $item .= $link . '<br>' . $content;
            $item .= '</li>';

            $atoz[$alpha][] = $item;
        }

        // Menu
        $menu  = '<ul class="glossary-menu-atoz">';
        $range = apply_filters( 'wpg2_atoz_range', array_keys($atoz) );
        foreach( $range as $alpha ) {
            $count = count( $atoz[$alpha] );
            $menu .= '<li class="glossary-menu-item atoz-menu-' . $alpha . ' atoz-clickable atozmenu-off" title="' . esc_attr__('Terms','wp-glossary-2') . ': ' . $count . '"  data-alpha="' . $alpha . '">';
            $menu .= '<a href="#' . $alpha . '">' . strtoupper($alpha) . '</a></li>';
        }
        $menu .= '</ul>';

        // Items
        $list = '<div class="glossary-atoz-wrapper">';
        foreach( $atoz as $alpha => $items ) {
            $list .= '<ul class="glossary-atoz glossary-atoz-' . $alpha . ' atozitems-off">';
            $list .= implode( '', $items );
            $list .= '</ul>';
        }
        $list .= '</div>';

        $clear    = '<div style="clear: both;"></div>';
        $plsclick = apply_filters( 'wpg2_please_select', '<div class="wpg2-please-select"><p>' . __('Please select from the menu above', 'wp-glossary-2') . '</p></div>' );
        return '<div class="glossary-atoz-wrapper">' . $menu . $clear . $plsclick . $clear . $list . '</div>';
    } // glossary_atoz
} // wpg2_Shortcode_ATOZ
