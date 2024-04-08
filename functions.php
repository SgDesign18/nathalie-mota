<?php
add_theme_support('title-tag'); // Ajouter la prise en charge des titres
add_theme_support( 'post-thumbnails' ); // Ajouter la prise en charge des images mises en avant

add_image_size('galerie', 564, 495, true);

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
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/css/bootstrap.css');
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_style('contact-modal-style', get_stylesheet_directory_uri() . '/css/contact-modal.css');
    wp_enqueue_style('responsive-css', get_template_directory_uri() . '/css/responsive.css');

    // Enqueue scripts - Ajout Jquery et js
    
    wp_enqueue_script('jquery');
    wp_enqueue_script('theme-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');




// Fonction pour charger plus de photos en utilisant AJAX
function load_more_photos() {
    $page = $_POST['page'];
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $page
    );
    $query = new WP_Query($args);
    
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            ?>
             <div class="photo-item">
                    <?php the_post_thumbnail('galerie', array('class' => 'photo-thumbnail')); ?>
                    <div class="overlay">
                        <!-- Ajoutez ici les détails et les liens de chaque photo -->
                        <span class="photo-reference">Ref: <?php echo get_field('reference_de_la_photo'); ?></span>
                        <span class="photo-category"><?php echo get_the_term_list(get_the_ID(), 'categorie', '', ', '); ?></span>
                        <span class="photo-details"><a href="<?php the_permalink(); ?>" class="photo-link" title="Voir les détails de la photo"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/eye.png'; ?>" ></a></span>
                        <span class="photo-lightbox"><a href="#" class="photo-full" title="Afficher la photo"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/icon-full.png'; ?>" ></a></span>
                    </div>
                </div>
            <?php
        endwhile;
    endif;
    
    wp_die();
}
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');




// Pour miniature dans single.php

// Enregistrement du script JavaScript et passage de l'URL AJAX
function enqueue_min_photo_script() {
    wp_enqueue_script('min-photo', get_template_directory_uri() . '/js/min-photo.js', array('jquery'), '1.0', true);
    wp_localize_script('min-photo', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_min_photo_script');

function get_next_photo_thumbnail() {
    $current_photo_id = $_POST['photo_id'];

    // Récupérer l'ID de la prochaine photo
    $next_photo = get_adjacent_post(false, '', true, 'photo');
    $next_photo_id = $next_photo ? $next_photo->ID : null;

    // Vérifier si la photo suivante existe
    if ($next_photo_id) {
        // Récupérer la miniature de la photo suivante
        $thumbnail = get_the_post_thumbnail($next_photo_id, 'thumbnail');
        echo $thumbnail;
    } else {
        echo 'Aucune photo suivante.';
    }
    wp_die();
}

add_action('wp_ajax_get_next_photo_thumbnail', 'get_next_photo_thumbnail');
add_action('wp_ajax_nopriv_get_next_photo_thumbnail', 'get_next_photo_thumbnail');



