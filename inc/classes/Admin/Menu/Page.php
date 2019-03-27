<?php

namespace ithoughts\TooltipGlossary\Admin\Menu;

if ( ! defined( 'ABSPATH' ) ) {
    status_header( 403 );wp_die( 'Forbidden' );// Exit if accessed directly.
}

use ithoughts\TooltipGlossary\DependencyManager;

if(!class_exists( __NAMESPACE__ . '\\Page' )){
    /**
     * An abstract generic Page, used to list & organize menu entries in the Wordpress admin section.
     */
    abstract class Page {
        /**
         * @var string The localized page name.
         */
        protected $page_title;
        /**
         * @var string The localized menu item's label.
         */
        protected $menu_title;
        /**
         * @var string A unique identifier for the target page.
         */
        protected $slug;
        /**
         * @var ?string The required user capabilities to access this page.
         */
        protected $capability;
        /**
         * @var bool Flag indicating if the page has already been registered in Wordpress.
         */
        protected $has_been_registered = false;
        
        /**
         * Create a new page.
         * 
         * @param string $page_title The localizable title of the target page.
         * @param string $menu_title The localizable label of the menu item.
         * @param string $slug A unique identifier for the page.
         * @param ?string $capability The required user capability to access this page.
         */
        public function __construct(
            string $page_title,
            string $menu_title,
            string $slug,
            ?string $capability
        ){
            // Localize readable data
            $text_domain = DependencyManager::get('text-domain');
            $this->page_title = __($page_title, $text_domain);
            $this->menu_title = __($menu_title, $text_domain);
            // Set the others
            $this->slug = $slug;
            $this->capability = $capability;
        }

        /**
         * Register this page in Wordpress.
         */
        public abstract function register(): void;
    }
}
