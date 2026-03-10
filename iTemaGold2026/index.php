<?php
/**
 * Main template file.
 *
 * @package iTemaGold2026
 */

get_header();
?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header>
                <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
            </header>
            <div>
                <?php the_excerpt(); ?>
            </div>
        </article>
    <?php endwhile; ?>

    <?php the_posts_pagination(); ?>
<?php else : ?>
    <p><?php esc_html_e('Nessun contenuto trovato.', 'itemagold2026'); ?></p>
<?php endif; ?>

<?php
get_footer();
