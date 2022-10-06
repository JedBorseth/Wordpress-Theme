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
        if (have_posts()) {


		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );




            $table = get_field('schedule');

            ?>

            <table class="schedule">
                <caption>Weekly Course Schedule</caption>
                <thead>
                <tr>
                    <?php foreach (array_keys($table[0]) as $item) {
                        ?>
                        <th><?php

                            echo ucfirst($item);

                            ?>


                        </th>
                        <?php


                    }
                    ?>
                </tr>
                </thead>
                <tbody>

                <?php
                foreach ($table as $row) {
                    echo "<tr>";
                    foreach ($row as $item) {
                        ?> <td><?php
                        echo $item;
                        ?> </td><?php
                    }
                    echo "</tr>";
                }


                ?>

                </tbody>
            </table>

            <?php



			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
        }

        ?>



	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
