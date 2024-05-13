<?php get_header(); ?>

<div id="wrap">
    <section id="content">
        <div class="row" id="page-blog">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium', ['class' => 'card-img-top', 'alt' => get_the_title()]); ?>
                                </a>
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php the_title(); ?></h5>
                                <h6 class=" mb-2 text-cat"><?php the_category(', '); ?></h6>
                                <p class="card-text"><?php the_excerpt(); ?></p>
                                <span class="btn-blog"><a href="<?php the_permalink(); ?>" class="btn btn-danger">En savoir plus</a></span>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="col">
                    <p>Aucun article trouvé.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php get_footer(); ?>
