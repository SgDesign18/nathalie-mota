<?php
/**
 * Modal contact
 *
 * @package WordPress
 * @subpackage nathalie-mota theme
 */
?>


<div class="popup-overlay hidden" id="contact-modal">
	<div class="popup-contact">
		<div class="popup-title__container">
			<div class="popup-title img-h"></div>
			<div class="popup-title img-b"></div>
		</div>
		<div class="popup-informations">	
        <?php
				$refPhoto = "";
				if (get_field('reference_de_la_photo')) {
					$refPhoto = get_field('reference_de_la_photo');
				}; 
				// Inclure le formulaire de contact en ajoutant la valeur pré-remplie pour la référence de la photo
				echo do_shortcode('[contact-form-7 id="1c28407" title="Formulaire de contact"]');
			?>
		</div>	
	</div>
</div>



