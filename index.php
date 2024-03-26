<?php get_header(); ?>

<div id="content">
    <?php
    // Boucle WordPress pour récupérer le contenu de la page 
    while ( have_posts() ) : the_post();
        // Afficher le contenu de la page
        the_content();
    endwhile;
    ?>

</div>
<?php get_footer(); ?>
