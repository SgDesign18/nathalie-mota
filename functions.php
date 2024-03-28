<?php


add_theme_support('title-tag');

// Ajouter la prise en charge des menus
function custom_theme_setup() {
    // Enregistrement des emplacements des menus
    register_nav_menus(array(
        'primary' => __('Menu Principal'),
        'footer' => __('Menu Pied de page')
    ));
}
add_action('after_setup_theme', 'custom_theme_setup');

// Ajouter le lien personnalisé au menu principal
function add_custom_menu_item($items, $args) {
    if ($args->theme_location == 'primary') {
        $items .= '<li class="menu-item"><a href="#contact-modal" class="open-modal">Contact</a></li>';
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'add_custom_menu_item', 10, 2);


function theme_enqueue_scripts() {
    // Enqueue stylesheet - Ajout de mon style.css
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_style('contact-modal-style', get_stylesheet_directory_uri() . '/css/contact-modal.css');

    // Enqueue scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('theme-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

