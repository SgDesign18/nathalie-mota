<div class="photo-item">
    <?php
    // Récupérer l'URL de la première image attachée à la publication
    $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0];
    ?>
    <?php the_post_thumbnail('galerie', array('class' => 'photo-thumbnail')); ?>
    <div class="overlay">
        <span class="photo-reference">Ref: <?php echo get_field('reference_de_la_photo'); ?></span>
        <span class="photo-category">
            <?php
            $terms = get_the_terms(get_the_ID(), 'categorie'); // Récupérer les termes de la taxonomie 'categorie' pour cet article
            if ($terms && !is_wp_error($terms)) {
                $category_names = array();
                foreach ($terms as $term) {
                    $category_names[] = $term->name;
                }
                echo implode(', ', $category_names); // Afficher les noms des catégories séparés par une virgule
            }
            ?>
        </span>
        <span class="photo-details"><a href="<?php the_permalink(); ?>" class="photo-link" title="Voir les détails de la photo"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/eye.png'; ?>"></a></span>
        <span class="photo-lightbox">
            <a href="<?php echo esc_url($thumbnail_url); ?>" class="photo-full-link" title="Afficher la photo" data-reference="<?php echo esc_attr(get_field('reference_de_la_photo')); ?>" data-category="<?php echo esc_attr(implode(', ', $category_names)); ?>">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/icon-full.png'; ?>" alt="Afficher la photo">
            </a>
            <!-- Flèches de navigation -->
            <button class="close"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/croix.png" alt="fermer la photo"></button>
            <button class="prev-btn"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/prev.png" alt="image précédente"></button>
            <button class="next-btn"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/next.png" alt="image suivante"></button>
        </span>
    </div>
</div>
