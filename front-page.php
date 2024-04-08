<?php get_header(); ?>

<div id="content">
    <!-- Chargement de la bannière -->
    <?php get_template_part('template-parts/banner'); ?>

    <?php
    // Boucle WordPress pour récupérer le contenu de la page 
    while (have_posts()) : the_post();
        // Afficher le contenu de la page
        the_content();
    endwhile;
    ?>

    <div class="photo-grid">
        <?php
        // Récupérer les articles de type "photo" avec WP_Query
        $args = array(
            'post_type' => 'photo', // Slug de CPT UI
            'posts_per_page' => 8, // Limiter à 8 photos
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
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
        ?>
    </div>

    <div class="button-plus">
        <button id="load-more-btn">Charger plus</button>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        const ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>'; 

        let page = 1;
        let canLoadMore = true;

        $('#load-more-btn').on('click', function() {
            if (canLoadMore) {
                page++;
                let data = {
                    'action': 'load_more_photos',
                    'page': page
                };
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        $('.photo-grid').append(response);
                        if (response.trim() == '') {
                            canLoadMore = false;
                            $('#load-more-btn').hide();
                        }
                    }
                });
            }
        });
    });
</script>

<?php get_footer(); ?>