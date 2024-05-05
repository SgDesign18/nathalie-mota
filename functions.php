<?php
add_theme_support('title-tag'); // Ajouter la prise en charge des titres
add_theme_support('post-thumbnails'); // Ajouter la prise en charge des images mises en avant

add_image_size('galerie', 564, 495, true);
add_image_size('min', 81, 71, true);
add_image_size('hero', 1450, 960, true);

// Ajouter la prise en charge des menus
function custom_theme_setup()
{
    // Enregistrement des emplacements des menus
    register_nav_menus(array(
        'primary' => __('Menu Principal'),
        'footer' => __('Menu Pied de page')
    ));
}
add_action('after_setup_theme', 'custom_theme_setup');

// Ajouter le lien personnalisé au menu principal
function add_custom_menu_item($items, $args)
{
    if ($args->theme_location == 'primary') {
        $items .= '<li class="menu-item"><a href="#contact-modal" class="open-modal">Contact</a></li>';
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'add_custom_menu_item', 10, 2);

function theme_enqueue_scripts()
{
    // Enqueue stylesheet - Ajout de mon style.css
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/css/bootstrap.css');
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_style('contact-modal-style', get_stylesheet_directory_uri() . '/css/contact-modal.css');
    wp_enqueue_style('responsive-css', get_stylesheet_directory_uri() . '/css/responsive.css');

    // Enqueue scripts - Ajout Jquery et js

    wp_enqueue_script('jquery');
    
    wp_enqueue_script('scripts-miniature', get_template_directory_uri() . '/js/min-photo.js', array('jquery'), '1.0', true);
    wp_enqueue_script('scripts-lightbox', get_template_directory_uri() . '/js/lightbox.js', array('jquery'), '1.0', true);
    wp_enqueue_script('scripts-menu', get_template_directory_uri() . '/js/menu.js', array('jquery'), '1.0', true);
    wp_enqueue_script('theme-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0', true);

    // Passer l'URL AJAX pour le script JavaScript
    wp_localize_script('scripts-miniature', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

// Enqueue scripts - Ajout font_awesome

function add_font_awesome_stylesheet() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', array(), '6.5.2');
}
add_action('wp_enqueue_scripts', 'add_font_awesome_stylesheet');



// Fonction pour charger tous les liens vers les images
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







// Pour miniature dans single.php

function get_adjacent_photo_thumbnail($photo_id, $direction)
{
    // Récupérer l'ID de la photo suivante ou précédente
    $adjacent_photo = get_adjacent_post(false, '', ($direction === 'next'), 'photo');
    $adjacent_photo_id = $adjacent_photo ? $adjacent_photo->ID : null;

    // Vérifier si la photo suivante ou précédente existe
    if ($adjacent_photo_id) {
        // Récupérer la miniature de la photo suivante ou précédente
        $thumbnail = get_the_post_thumbnail($adjacent_photo_id, 'min');
        echo $thumbnail;
    } else {
        echo 'Aucune photo ' . ($direction === 'next' ? 'suivante' : 'précédente') . '.';
    }
    wp_die();
}

add_action('wp_ajax_get_adjacent_photo_thumbnail', 'get_adjacent_photo_thumbnail');
add_action('wp_ajax_nopriv_get_adjacent_photo_thumbnail', 'get_adjacent_photo_thumbnail');




// Fonction pour charger les photos filtrées par les filtres
function load_photos_by_filters()
{
    // Récupérer les valeurs des filtres envoyées par la requête AJAX
    $category = $_POST['category'];
    $format = $_POST['format'];
    $date = $_POST['date'];

    // Construire les arguments de la requête WP_Query en fonction des filtres sélectionnés
    $args = array(
        'post_type' => 'photo', // Type de publication pour vos photos
        'posts_per_page' => 8, // Nombre de photos à afficher
        'orderby' => 'date', // Trier par date
        'order' => ($date === 'newest') ? 'DESC' : 'ASC', // Ordonner par ordre décroissant ou croissant
    );

    // Ajouter des arguments supplémentaires en fonction des filtres sélectionnés
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

    // Effectuer la requête WP_Query avec les arguments construits
    $query = new WP_Query($args);

    // Charger le contenu des photos filtrées
    ob_start(); // Commencer la mise en mémoire tampon de sortie
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            // Afficher le contenu des photos
            // Appel au modèle grille_photos.php pour afficher chaque photo
            get_template_part('templates_part/grille_photos');
        endwhile;
        wp_reset_postdata();
    else :
        echo 'Aucune photo trouvée.';
    endif;
    $output = ob_get_clean(); // Récupérer le contenu mis en mémoire tampon et nettoyer la mémoire tampon

    echo $output; // Renvoyer le contenu des photos sous forme de HTML

    wp_die(); // Fin de la requête AJAX
}

// Ajouter l'action pour gérer la requête AJAX des photos filtrées
add_action('wp_ajax_load_photos_by_filters', 'load_photos_by_filters');
add_action('wp_ajax_nopriv_load_photos_by_filters', 'load_photos_by_filters');



// Fonction pour récupérer l'ordre des articles du type "photo" dans CPT UI 
// Récupère l'ordre des IDs dans la page frontale
function get_photo_order()
{
    $args = array(
        'post_type' => 'photo', // Slug de CPT UI
        'posts_per_page' => -1, // Récupérer tous les articles
        'orderby' => 'date', // Trier par l'ordre de menu
        'order' => 'ASC', // Par ordre croissant
    );

    $query = new WP_Query($args);
    $order = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $order[] = get_the_ID();
        }
    }

    wp_reset_postdata();

    echo json_encode($order); // Renvoyer l'ordre des IDs des photos sous forme de JSON
    wp_die(); // Terminer la requête AJAX
}

add_action('wp_ajax_get_photo_order', 'get_photo_order');
add_action('wp_ajax_nopriv_get_photo_order', 'get_photo_order');

?>