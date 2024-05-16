<?php

/**
 * Single : Single photo 
 *
 * @package WordPress
 * @subpackage Nathalie-Mota
 */

get_header(); ?>

<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/min-photo.js"></script>

<div id="wrap">
    <section id="content">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <div class="container-fluid py-5">
                    <div class="container">
                        <div class="row g-5 ">

                            <div class="col-lg-6 order-lg-1 order-md-2 order-sm-2 align-self-end">
                                <!--<span class="space"></span>-->
                                <div class="section-title mb-4">
                                    <h2 class="single-title"><?php the_title(); ?></h2>
                                </div>

                                <div class="row g-3">
                                    <div class="col-sm-12 infos">
                                        <p class="mb-3">Référence : <?php echo get_field('reference_de_la_photo'); ?></p>
                                        <p class="mb-3"><?php
                                                        $categories = get_the_terms(get_the_ID(), 'categorie');
                                                        if ($categories && !is_wp_error($categories)) {
                                                            $category_names = array();
                                                            foreach ($categories as $category) {
                                                                $category_names[] = $category->name;
                                                            }
                                                            echo 'Catégorie : ' . implode(', ', $category_names);
                                                        } else {
                                                            echo 'Catégorie : Non définie';
                                                        }
                                                        ?>
                                        </p>

                                        <p class="mb-3">Format : <?php $formats = get_the_terms(get_the_ID(), 'format');
                                                                    if ($formats && !is_wp_error($formats)) {
                                                                        $format_names = array();
                                                                        foreach ($formats as $format) {
                                                                            $format_names[] = $format->name;
                                                                        }
                                                                        echo implode(', ', $format_names);
                                                                    } else {
                                                                        echo 'Non défini';
                                                                    }
                                                                    ?> </p>
                                        <p class="mb-3">Type : <?php echo get_field('type'); ?></p>
                                        <p class="mb-3">Année : <?php the_date('Y'); ?></p>
                                        <span class="hr hr-mob"></span>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 order-lg-2 order-md-1 order-sm-1" style="min-height: 700px;">
                                <div class="position-relative h-100">
                                    <img class="position-absolute w-100 h-100 single-img" src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" style="object-fit: cover;">
                                </div>
                            </div>
                        </div>

                        <div class="row g-5 single-cmd">
                            <div class="col-lg-3 typo2">
                                <p>Cette photo vous intéresse ?</p>
                            </div>

                            <div class="col-lg-3">
                                <div class="button-single">
                                    <button id="btn-cmd" class="open-modal" data-reference="<?php echo get_field('reference_de_la_photo'); ?>">Contact</button>
                                </div>
                            </div>

                            <div class="col-lg-6 col-img-min">
                                <div class="cmd-img">
                                    <div class="img-min" data-photo-id="<?php echo get_the_ID(); ?>" data-photo-url="<?php echo get_permalink(); ?>" data-photo-thumb="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'min'); ?>">

                                        <?php
                                        // Récupérer la catégorie de la photo actuelle
                                        $categories = get_the_terms(get_the_ID(), 'categorie');
                                        if ($categories && !is_wp_error($categories)) {
                                            $category_slugs = array();
                                            foreach ($categories as $category) {
                                                $category_slugs[] = $category->slug;
                                            }

                                            // Récupérer les articles de type "photo" avec WP_Query et filtrer par catégorie
                                            $args = array(
                                                'post_type' => 'photo', // Slug de CPT UI
                                                'posts_per_page' => 1, // Limiter à 1 photo
                                                'tax_query' => array(
                                                    array(
                                                        'taxonomy' => 'categorie',
                                                        'field' => 'slug',
                                                        'terms' => $category_slugs,
                                                    ),
                                                ),
                                                'post__not_in' => array(get_the_ID()), // Exclure l'article principal
                                            );

                                            $query = new WP_Query($args);

                                            if ($query->have_posts()) :
                                                while ($query->have_posts()) : $query->the_post();
                                        ?>
                                                    <a href="<?php the_permalink(); ?>" class="photo-link">
                                                        <?php the_post_thumbnail('min', array('class' => 'photo-min', 'id' => 'first-photo-thumbnail')); ?>
                                                    </a>
                                        <?php
                                                endwhile;
                                                wp_reset_postdata();
                                            else :
                                                echo 'Aucune photo trouvée.';
                                            endif;
                                        }
                                        ?>
                                    </div>
                                    <div class="fleches">
                                        <span id="arrow-left" class="arrow" data-photo-id="<?php echo get_the_ID(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/precedent.png" alt="fleche gauche"></span>
                                        <span id="arrow-right" class="arrow" data-photo-id="<?php echo get_the_ID(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/suivant.png" alt="fleche droite"></span>
                                    </div>
                                </div>
                            </div><!--Fin col6-->


                        </div>

                        <span class="hr"></span>
                        <h3 class="single-other">VOUS AIMEREZ AUSSI ...</h3>

                        <div class="row g-5">
                            <?php
                            // Récupérer l'URL de la première image attachée à la publication
                            $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0];
                            // Récupérer la catégorie de la photo actuelle
                            $categories = get_the_terms(get_the_ID(), 'categorie');
                            if ($categories && !is_wp_error($categories)) {
                                $category_slugs = array();
                                foreach ($categories as $category) {
                                    $category_slugs[] = $category->slug;
                                }

                                // Récupérer les articles de type "photo" avec WP_Query et filtrer par catégorie
                                $args = array(
                                    'post_type' => 'photo', // Slug de CPT UI
                                    'posts_per_page' => 2, // Limiter à 2 photos
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'categorie',
                                            'field' => 'slug',
                                            'terms' => $category_slugs,
                                        ),
                                    ),
                                    'post__not_in' => array(get_the_ID()), // Exclure l'article principal
                                );

                                $query = new WP_Query($args);

                                if ($query->have_posts()) :
                                    while ($query->have_posts()) : $query->the_post();
                            ?>
                                        <div class="col-lg-6">
                                            <div class="other-img">
                                                <div class="photo-other">
                                                    <?php the_post_thumbnail('galerie', array('class' => 'photo-thumbnail')); ?>
                                                    <div class="overlay">
                                                        <span class="photo-details"><a href="<?php the_permalink(); ?>" class="photo-link" title="Voir les détails de la photo"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/eye.png'; ?>"></a></span>
                                                        <span class="photo-lightbox single-lightbox">
                                                            <?php
                                                            $other_thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0];
                                                            ?>
                                                            <a href="<?php echo esc_url($other_thumbnail_url); ?>" class="photo-full-link" title="Afficher la photo" data-reference="<?php echo esc_attr(get_field('reference_de_la_photo')); ?>" data-category="<?php echo esc_attr(implode(', ', $category_names)); ?>">


                                                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/icon-full.png'; ?>" alt="Afficher la photo">
                                                            </a>
                                                            <!-- Flèches de navigation -->
                                                            <button class="close"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/croix.png" alt="fermer la photo"></button>
                                                            <button class="prev-btn"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/prev.png" alt="image précédente"></button>
                                                            <button class="next-btn"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/next.png" alt="image suivante"></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            <?php
                                    endwhile;
                                    wp_reset_postdata();
                                else :
                                    echo 'Aucune photo trouvée.';
                                endif;
                            }
                            ?>
                        </div>

                    </div><!--fin container-->
                </div><!--fin container-fluid-->

        <?php endwhile;
        endif; ?>

    </section>
</div>


<?php get_footer(); ?>


<!--------------------- Création d'un tableau pour récupérer les photos de mon CPT UI ----------------------------------->


<?php
if (is_singular('photo')) {
    // Récupérer tous les ID des photos du CPT UI avec leurs URL
    $args = array(
        'post_type' => 'photo', // slug CPT UI
        'posts_per_page' => -1, // Récupérer tous les posts
    );

    $query = new WP_Query($args);

    // Tableau JavaScript pour stocker les informations des photos
    $photos_data = array();

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $photo_data = array(
                'id' => get_the_ID(),
                'permalink' => get_permalink(),
                'thumbnail_url' => get_the_post_thumbnail_url(get_the_ID(), 'min'),
            );
            $photos_data[] = $photo_data;
        endwhile;
        wp_reset_postdata();
    endif;

    // Convertir le tableau PHP en chaîne JSON pour le transmettre à JavaScript
    $photos_data_json = wp_json_encode($photos_data);

    // Ajouter le script JavaScript dans la page pour initialiser le tableau
    ?>
    <script>
    let photosData = <?php echo json_encode($photos_data); ?>;
    </script>
    <?php
}
?>




<script>
    const ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    const imageDirectory = '<?php echo get_template_directory_uri(); ?>/assets/images/';
</script>

<script src="<?php echo get_template_directory_uri(); ?>/js/lightbox.js"></script>