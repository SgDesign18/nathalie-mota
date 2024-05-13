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
    wp_enqueue_script('min-scripts', get_template_directory_uri() . '/js/min-photo.js', array('jquery'), '1.0', true);

    // Passer l'URL AJAX pour le script JavaScript
    wp_localize_script('scripts-lightbox', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    wp_localize_script('scripts-more-photos', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    wp_localize_script('scripts-filtres', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    wp_localize_script('min-scripts', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

// Ajout font_awesome
function add_font_awesome_stylesheet() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', array(), '6.5.2');
}
add_action('wp_enqueue_scripts', 'add_font_awesome_stylesheet');


    
    





// Bouton - Charger plus -------------------------------------------------------------------------------

function load_more_photos()
{
    $paged = $_POST['page']; // Récupérer le numéro de page suivant
    $category = isset($_POST['category']) ? $_POST['category'] : ''; // Récupérer la catégorie filtrée
    $format = isset($_POST['format']) ? $_POST['format'] : ''; // Récupérer le format filtré
    $date_order = isset($_POST['date']) ? $_POST['date'] : 'DESC'; // Récupérer l'ordre de tri par date

    // Initialiser la variable loaded_photos si elle n'est pas définie
    $loaded_photos = isset($_POST['loaded_photos']) ? $_POST['loaded_photos'] : array();

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC',
        'post__not_in' => $loaded_photos, // Exclure les photos déjà chargées
    );

    // Ajouter les arguments de filtre seulement s'ils sont définis
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
            $photo_id = get_the_ID();
            // Vérifier si la photo a déjà été chargée
            if (!in_array($photo_id, $loaded_photos, true)) {
                get_template_part('templates_part/grille_photos'); // Afficher le contenu des photos
                // Ajouter l'identifiant de la photo à la liste des photos chargées
                $loaded_photos[] = $photo_id;
            }
        }
    }

    wp_reset_postdata();

    // Terminer la réponse AJAX
    die();
}

add_action('wp_ajax_load_more_photos', 'load_more_photos'); // Pour les utilisateurs connectés
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos'); // Pour les utilisateurs non connectés



// Fonction pour charger les photos en fonction des filtres ---------------------------------------------------
function filter_photos()
{

    $paged = $_POST['page']; // Récupérer le numéro de page suivant
    $category = isset($_POST['category']) ? $_POST['category'] : ''; // Récupérer la catégorie filtrée
    $format = isset($_POST['format']) ? $_POST['format'] : ''; // Récupérer le format filtré
    $date_order = isset($_POST['date']) ? $_POST['date'] : 'DESC'; // Récupérer l'ordre de tri par date

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
        'orderby' => 'date', // Tri par date de publication
        'order' => $date_order, // Utiliser l'ordre spécifié plus haut
    );

    // Ajouter les arguments de filtre seulement s'ils sont définis
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
            get_template_part('templates_part/grille_photos'); // Afficher le contenu des photos
        }
    }

    // Si aucune photo restante, masquer le bouton "Charger plus"
    if ($query->max_num_pages <= $paged) {
        echo ''; // Retourner une réponse vide pour indiquer qu'il n'y a plus de photos
    }

    wp_reset_postdata();

    // Terminer la réponse AJAX
    die();
}

add_action('wp_ajax_filter_photos', 'filter_photos'); // Pour les utilisateurs connectés
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos'); // Pour les utilisateurs non connectés



// Fonction pour charger tous les liens vers les images - Lightbox ---------------------------------------------
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


// a vérifier ce code ! ------------------------------------------------------------------------------------
function update_photo_links()
{
    $args = array(
        'post_type' => 'photo', // Slug de CPT UI
        'posts_per_page' => -1, // Récupérer toutes les photos
        
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $photoFullLinksArray = array();
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
?>
        <script type="text/javascript">
            var photoFullLinksArray = <?php echo json_encode($photoFullLinksArray); ?>;
        </script>
<?php
    }
}
add_action('wp_head', 'update_photo_links');


// Miniature dans page single ---------------------------------------------------------------------------------



