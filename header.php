<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<header id="header" class="header">
		<nav id="menu-header" class="topnav">
		
			<div class="logo">
				<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.png" alt="Logo de Nathalie Mota">
				</a>
			</div>

				<?php
				wp_nav_menu(array(
					'theme_location' => 'primary',
					'menu_class' => 'menu',
				));
				?>

			<div class="icon-burger"><i class="fa-solid fa-bars"></i></div>

		</nav>



		<div class="burger-menu">
			

				<?php
				wp_nav_menu(array(
					'theme_location' => 'primary',
					'menu_class' => 'menu-mobile',
				));
				?>

			

		</div>
	
	</header>


	<script>

const burgerMenuButton = document.querySelector('.icon-burger')
const burgerMenuButtonIcon = document.querySelector('.icon-burger i')
const burgerMenu = document.querySelector('.burger-menu')

burgerMenuButton.onclick = function(){
	burgerMenu.classList.toggle('open')
	const isOpen = burgerMenu.classList.contains('open')
	burgerMenuButtonIcon.classList = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'
}

	</script>			








	