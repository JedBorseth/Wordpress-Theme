<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package jed
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">',  _(" Students") . '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );

				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
            ?>
            <article id="<?php the_ID();?>" class="student-post student-item">



            <h2><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2><?php

                the_post_thumbnail('student');
                ?> <div><?php
                the_content();
?> </div><?php


            ?>
            </article>

                <?php

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
