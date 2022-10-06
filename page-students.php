<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package jed
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;




		endwhile; // End of the loop.

        ?>

        <section class="students">
<?php
$args = array('post_type' => 'jed-student', 'posts_per_page' => -1, );
$query = new WP_Query($args);
if ($query->have_posts()) {
    while ($query->have_posts()) {
    $query->the_post();
    ?> <article class="student-item"><?php



        ?> <h2><a href="<?php  the_permalink();?>"> <?php the_title(); ?></a></h2><?php
        the_post_thumbnail();
        ?> <p><?php the_excerpt();?> <a href="<?php the_permalink(); ?>"><?php _e("Read More about the student...");?></a></p><?php
        ?> <p><?php _e("Specialty: "); $search = get_the_terms( get_the_ID(), 'student' ); echo join(', ', wp_list_pluck( $search , 'name') )?></p><?php



?></article><?php
    }
    wp_reset_postdata();

}

?>




        </section>


        <?php








		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
