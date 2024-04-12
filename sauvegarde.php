function load_photos_by_date() {
    $date = $_POST['date']; // Date sélectionnée dans le filtre

    // Construire les arguments de la requête pour récupérer les photos filtrées par date
    $args = array(
        'post_type' => 'photo', // Type de publication pour vos photos
        'posts_per_page' => 8, // Nombre de photos à afficher
        'orderby' => 'date', // Trier par date
        'order' => ($date === 'newest') ? 'DESC' : 'ASC', // Ordonner par ordre décroissant ou croissant
    );

    // Effectuer la requête WP_Query avec les arguments construits
    $query = new WP_Query($args);

    // Charger le contenu des photos filtrées
    ob_start(); // Commencer la mise en mémoire tampon de sortie
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            // Afficher le contenu des photos
            ?>
            <div class="photo-item">
                <?php the_post_thumbnail('galerie', array('class' => 'photo-thumbnail')); ?>
                <div class="overlay">
                    <span class="photo-reference">Ref: <?php echo get_field('reference_de_la_photo'); ?></span>
                    <span class="photo-category"><?php echo get_the_term_list(get_the_ID(), 'categorie', '', ', '); ?></span>
                    <span class="photo-details"><a href="<?php the_permalink(); ?>" class="photo-link" title="Voir les détails de la photo"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/eye.png'; ?>"></a></span>
                    <span class="photo-lightbox"><a href="#" class="photo-full" title="Afficher la photo"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/icon-full.png'; ?>"></a></span>
                </div>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo 'Aucune photo trouvée.';
    endif;
    $output = ob_get_clean(); // Récupérer le contenu mis en mémoire tampon et nettoyer la mémoire tampon

    echo $output; // Renvoyer le contenu des photos sous forme de HTML

    wp_die(); // Fin de la requête AJAX
}
