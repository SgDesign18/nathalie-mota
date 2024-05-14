<footer>


    <ul class="menu-footer">
        <?php
        
        wp_nav_menu(array(
            'theme_location' => 'menu-footer', 
            'container' => false, 
            'items_wrap' => '%3$s<li>TOUS DROITS RÉSERVÉS</li>', 
           
        ));
        ?>
    </ul>


    <!-- Lance la popup contact -->
    <?php get_template_part('templates_part/contact-modal'); ?>


</footer>
<?php wp_footer(); ?>



<!-- Inclure jQuery pour la lightbox -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Inclure le script qui initialise la lightbox -->
<script src="<?php echo get_template_directory_uri(); ?>/js/lightbox.js"></script>

</body>

</html>


