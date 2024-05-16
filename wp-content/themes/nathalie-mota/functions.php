<?php
add_theme_support('title-tag'); // Ajouter la prise en charge des titres
add_theme_support('post-thumbnails'); // Ajouter la prise en charge des images mises en avant

// Tailles d'image personnalisées
add_image_size('galerie', 564, 495, true);
add_image_size('min', 81, 71, true);
add_image_size('hero', 1450, 960, true);


// Prise en charge des menus dans l'administration WP
function custom_theme_setup()
{
    // Enregistrement des emplacements des menus
    register_nav_menus(array(
        'primary' => __('Menu Principal'),
        'footer' => __('Menu Pied de page')
    ));
}
add_action('after_setup_theme', 'custom_theme_setup');


// Lien personnalisé au menu principal => Contact
function add_custom_menu_item($items, $args)
{
    if ($args->theme_location == 'primary') {
        $items .= '<li class="menu-item"><a href="#contact-modal" class="open-modal">Contact</a></li>';
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'add_custom_menu_item', 10, 2);

// Chargement des scripts et styles
function theme_enqueue_scripts()
{
    // Styles
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/css/bootstrap.css');
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_style('contact-modal-style', get_stylesheet_directory_uri() . '/css/contact-modal.css');
    wp_enqueue_style('responsive-css', get_stylesheet_directory_uri() . '/css/responsive.css');

    // Scripts 
    wp_enqueue_script('jquery');
    wp_enqueue_script('scripts-lightbox', get_template_directory_uri() . '/js/lightbox.js', array('jquery'), '1.0', true);
    wp_enqueue_script('scripts-more-photos', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0', true);
    wp_enqueue_script('scripts-filtres', get_template_directory_uri() . '/js/filtres.js', array('jquery'), '1.0', true);
    wp_enqueue_script('contact-scripts', get_template_directory_uri() . '/js/contact.js', array('jquery'), '1.0', true);

    // Charger min-photo.js uniquement sur la page single.php pour les types de post photo
    if (is_singular('photo')) {
        wp_enqueue_script('min-scripts', get_template_directory_uri() . '/js/min-photo.js', array('jquery'), '1.0', true);
    }

    // Tableau contenant les handles des scripts à localiser avec l'URL AJAX
    $scripts = array('scripts-lightbox', 'scripts-more-photos', 'scripts-filtres');

    // Boucler sur chaque handle pour localiser le script avec l'URL AJAX
    foreach ($scripts as $script) {
        wp_localize_script($script, 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    }
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');


// Ajout font_awesome
function add_font_awesome_stylesheet()
{
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', array(), '6.5.2');
}
add_action('wp_enqueue_scripts', 'add_font_awesome_stylesheet');



// Bouton - Charger plus 

function load_more_photos()
{
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1; // Récupérer le numéro de page suivant
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : ''; // Récupérer la catégorie filtrée
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : ''; // Récupérer le format filtré
    $date_order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'DESC'; // Récupérer l'ordre de tri par date

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => $date_order, // Utiliser l'ordre spécifié
    );

    if (!empty($category)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $category,
        );
    }

    if (!empty($format)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('templates_part/grille_photos');
        }
    }

    wp_reset_postdata();
    die();
}
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');



// Fonction pour charger les photos en fonction des filtres 
function filter_photos()
{
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $date_order = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : 'DESC';

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => $date_order,
    );

    if (!empty($category)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $category,
        );
    }

    if (!empty($format)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('templates_part/grille_photos');
        }
    }

    // Ajouter un champ caché pour indiquer s'il reste des photos à charger
    if ($query->max_num_pages <= $paged) {
        echo '<div id="no-more-photos" style="display: none;"></div>';
    }

    wp_reset_postdata();
    die();
}
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');



// Fonction pour charger toutes les images - Lightbox 

function load_all_photo_links()
{
    $args = array(
        'post_type' => 'photo', // Slug de CPT UI
        'posts_per_page' => -1, // Récupérer toutes les photos

    );

    $query = new WP_Query($args);

    $photoFullLinksArray = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0];
            $photoFullLinksArray[] = array(
                'href' => esc_url($thumbnail_url),
                'reference' => get_field('reference_de_la_photo'),
                'category' => get_the_terms(get_the_ID(), 'categorie'),
            );
        }
        wp_reset_postdata();
    }

    // Renvoyer les liens sous forme de JSON
    wp_send_json($photoFullLinksArray);
}

// Ajouter l'action AJAX pour charger tous les liens vers les images
add_action('wp_ajax_load_all_photo_links', 'load_all_photo_links');
add_action('wp_ajax_nopriv_load_all_photo_links', 'load_all_photo_links');


//  éviter que la taxonomie "format" entre en conflit avec l'une des propriétés existantes dans l'API REST de WordPress

function custom_taxonomies()
{
    // Enregistrement de la taxonomie "format"
    register_taxonomy('format', 'photo', array(
        'labels' => array(
            'name' => 'Formats',
            'singular_name' => 'Format',

        ),
        'public' => true,
        'rewrite' => array('slug' => 'format'), // Détermine l'URL slug pour la taxonomie
        'show_in_rest' => true, // Active la prise en charge de l'API REST pour cette taxonomie
        'rest_base' => 'photo_format', // Définit la base personnalisée pour l'API REST afin d'éviter le conflit avec les propriétés existantes de l'API REST
    ));
}

add_action('init', 'custom_taxonomies');
