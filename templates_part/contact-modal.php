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
				
				echo do_shortcode('[contact-form-7 id="b2f26a9" title="Formulaire de contact"]');
			?>
		</div>	
	</div>
</div>
