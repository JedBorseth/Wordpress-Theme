<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package jed
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		if ( have_posts() ) :
            ?>
            <h1><?php single_post_title(); ?></h1>
            <?php
			while ( have_posts() ) {
                the_post();
                the_content();
            }

			the_posts_navigation();
		endif;

        $terms = ['administrative', 'faculty01'];

        foreach ($terms as $term) {
            $args = array('post_type' => 'jed-staff', 'posts_per_page' => -1,
                'tax_query' => array(array('taxonomy' => 'staff', 'field' => 'slug', 'terms' => $term)));
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                ?><h2><?php if($term === 'faculty01') {
                    echo esc_html(ucfirst("faculty"));} else {echo esc_html(ucfirst($term));} ?></h2> <div class="staff-wrapper"><?php

                while ($query->have_posts()) {
                    $query->the_post();

                    ?>
                    <div class="staff-item">

                        <h3><?php the_title()?> </h3>
                        <p><?php the_field('biography');?></p>
                        <p><?php echo _("Course: "); the_field("course") ?></p>
                        <a href="<?php the_field("website");?>"><?php echo _("Instructor Website")?></a>

                    </div>




                    <?php
                }
                ?></div><?php
                wp_reset_postdata();
            }
        }





        ?>



	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
