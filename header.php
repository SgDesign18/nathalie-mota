<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header id="header">
        <section class="header">
            <div class="logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.png" alt="Logo de Nathalie Mota">
                </a>
            </div>


            <nav id="menu-header">
				<?php
					wp_nav_menu(array(
					 'theme_location' => 'primary',
					 'menu_class' => 'menu-header', 
				));
				?>
				
				<button id="modal-burger" class="btn-modal" aria-label="Menu burger">
                    <span class="line l1"></span>
                    <span class="line l2"></span>
                    <span class="line l3"></span>
                </button>
				
                <div id="modal-content" class="modal-content">           
					<?php 				
					wp_nav_menu(array('theme_location' => 'primary')); 
					?>
                </div>

    		 </nav>

        </section>
    </header>
