<footer>
    <ul class="menu-footer">
        <?php
        
        wp_nav_menu(array(
            'theme_location' => 'footer', 
            'container' => false, 
            'items_wrap' => '%3$s<li>TOUS DROITS RÉSERVÉS</li>', 
           
        ));
        ?>
    </ul>

    <!-- Lance la popup contact -->
    <?php get_template_part('templates_part/contact-modal'); ?>


</footer>
<?php wp_footer(); ?>


</body>
</html>