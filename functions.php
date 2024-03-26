<?php
// Enqueue stylesheet - Ajout de mon style.css
function theme_enqueue_styles() {
    wp_enqueue_style( 'theme-style', get_stylesheet_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );



add_theme_support('title-tag');

// pour afficher les menus header et footer
function register_menus() {
    register_nav_menus(
        array(
            'primary' => __( 'Menu Principal' ),
            'menu-footer' => __( 'Menu Footer' )
        )
    );
}
add_action( 'init', 'register_menus' );

