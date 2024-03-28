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
			<div class="popup-title p1"></div>
			<div class="popup-title p2"></div>
		</div>
		<div class="popup-informations">	
        <?php
				
				echo do_shortcode('[contact-form-7 id="b2f26a9" title="Formulaire de contact"]');
			?>
		</div>	
	</div>
</div>
