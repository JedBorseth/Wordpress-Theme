<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package jed
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();


        ?> <article class="student"><h1><?php



            the_title();
            ?> </h1><?php
            echo "<div class='entry-content'>";
            the_content();
            the_post_thumbnail('student');
            echo "</div>"
            ?></article><?php

            $student_type = wp_list_pluck(get_the_terms(get_the_ID(), 'student'), 'slug')[0];
            $this_id = get_the_ID();


            $args = array('post_type' => 'jed-student', 'posts_per_page' => -1,
                'tax_query' => array(array('taxonomy' => 'student', 'field' => 'slug', 'terms' => $student_type)));
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                ?> <h3><?php _e("Meet other " . $student_type . " students:");?></h3><?php
                while ($query->have_posts()) {
                    $query->the_post();
                    if (get_the_ID() !== $this_id) {
                        ?> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php
                    }



                }
            }


		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
