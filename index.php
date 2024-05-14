<<<<<<< HEAD
<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define( 'WP_USE_THEMES', true );

/** Loads the WordPress Environment and Template */
require __DIR__ . '/wp-blog-header.php';
=======
<?php get_header(); ?>

<div id="content">
    <?php
    // Boucle WordPress pour récupérer le contenu de la page 
    while (have_posts()) : the_post();
        // Afficher le contenu de la page
        the_content();
    endwhile;
    ?>


</div>
<?php get_footer(); ?>
>>>>>>> e1e4c599ebdc21c9e75be11c517f4533114e5afd
