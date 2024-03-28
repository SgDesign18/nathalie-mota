<footer>


<ul class="menu-footer">
    <?php
    // Afficher le menu "menu-footer" dans le footer
    wp_nav_menu(array(
        'theme_location' => 'menu-footer', // Spécifie l'emplacement du menu
        'container' => false, // Ne pas utiliser de conteneur supplémentaire
        'items_wrap' => '%3$s<li>TOUS DROITS RÉSERVÉS</li>', // Ajouter un élément statique
        // Autres paramètres facultatifs peuvent être ajoutés selon vos besoins
    ));
    ?>
</ul>


   <!-- Lance la popup contact -->
   <?php get_template_part('templates_part/contact-modal'); ?>


</footer>
    <?php wp_footer(); ?>



</body>
</html>
