<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header>
        <section class="header">
            <div class="logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.png" alt="Logo de Nathalie Mota">
                </a>
            </div>
   			<nav>
				<?php
					wp_nav_menu(array(
					 'theme_location' => 'primary',
					 'menu_class' => 'menu-header', 
				));
				?>
    		 </nav>

        </section>














    </header>
