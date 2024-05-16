<?php 

/**
 * single-post : Page d'un article
 *
 * @package WordPress
 * @subpackage nathalie-mota
 */


get_header(); ?>

<div id="container">
	<section id="single-post">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="single-banner"><img src="<?php the_post_thumbnail_url(); ?>" alt=""></div>
				<div class="content-single-post">
					<h1><?php the_title(); ?></h1>

					<?php the_content(); ?>
				</div>
		<?php endwhile;
		endif; ?>

        <div class="etiquettes"><?php the_tags('Cet article parle de : ', ' / ', ''); ?></div>
	</section>
	
	<hr>
	<article class="pagination-blog">
		<h3>A voir aussi ...</h3>
		<div class="site-navigation flexrow">
			<div class="site-navigation-prev">
				<?php previous_post_link('Article Précédent<br>%link'); ?>
			</div>
			<div class="site-navigation-next">
				<?php next_post_link('Article Suivant<br>%link'); ?>
			</div>
		</div>
	</article>
</div>

<?php get_footer(); ?>