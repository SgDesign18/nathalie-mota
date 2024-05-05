<?php get_header(); ?>

<script>
    const ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    const imageDirectory = '<?php echo get_template_directory_uri(); ?>/assets/images/';
</script>

<script src="<?php echo get_template_directory_uri(); ?>/js/lightbox.js"></script>



<div id="content">
    <!-- Chargement de la bannière -->
    <?php get_template_part('templates_part/banner'); ?>

    <?php
    // Boucle WordPress pour récupérer le contenu de la page 
    while (have_posts()) : the_post();
        // Afficher le contenu de la page
        the_content();
    endwhile;
    ?>
<div class="container-index">
    <div class="filtres">
        <div class="row g-5">
            <div class="col-lg-6 filter-left custom">

                <select id="category-filter" class="select-filter" name="test">
                    <option value="">Catégories</option>
                    <?php
                    // Récupérer les termes de la taxonomie "categorie"
                    $categories = get_terms(array(
                        'taxonomy' => 'categorie',
                        'hide_empty' => false,
                    ));
                    foreach ($categories as $category) :
                    ?>
                        <option value="<?php echo $category->slug; ?>"><?php echo $category->name; ?></option>
                    <?php endforeach; ?>
                </select>

                <select id="format-filter" class="select-filter">
                    <option value="">Formats</option>
                    <?php
                    // Récupérer les termes de la taxonomie "format"
                    $formats = get_terms(array(
                        'taxonomy' => 'format',
                        'hide_empty' => false,
                    ));

                    foreach ($formats as $format) :
                    ?>
                        <option value="<?php echo $format->slug; ?>"><?php echo $format->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-6 filter-right custom">
                <select id="date-filter" class="select-filter">
                    <option value="">Trier par </option>
                    <option value="newest">Plus récente</option>
                    <option value="oldest">Plus ancienne</option>
                </select>
            </div>
        </div>
    </div>


    <div class="photo-grid">

        <?php
        // Récupérer les articles de type "photo" avec WP_Query
        $args = array(
            'post_type' => 'photo', // Slug de CPT UI
            'posts_per_page' => 8, // Récupérer seulement 8 photos initialement
            'orderby' => 'date', // Trier par date
            'paged' => 1, // Utilisé pour la pagination AJAX
        );
        
        $query = new WP_Query($args);
        

if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
        // Afficher le contenu des photos
        get_template_part('templates_part/grille_photos');
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

    </div><!--Fin container-->
</div><!--Fin content-->




<?php get_footer(); ?>

