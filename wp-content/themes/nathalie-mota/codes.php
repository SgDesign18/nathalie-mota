// a vérifier ce code dans functions.php ------------------------------------------------------------------------------------
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

// dans page single après get header
<script>
    window.photosData = <?php echo json_encode($photosData); ?>;
</script>