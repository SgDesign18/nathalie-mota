<?php get_header(); ?>

  <div id="container">
      <section id="content">
		    <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
			
        <div class="single-banner"><img src="<?php the_post_thumbnail_url(); ?>" alt=""></div>
			  <h1><?php the_title(); ?></h1>

			  <?php the_content(); ?>

		    <?php endwhile; endif; ?>
        
      </section>
  </div>

<?php get_footer(); ?>