<?php
/**
 * Header template.
 *
 * @package iTemaGold2026
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#content"><?php esc_html_e('Salta al contenuto', 'itemagold2026'); ?></a>
<header class="site-header" role="banner">
    <div class="site-container">
        <?php if (has_custom_logo()) : ?>
            <div class="site-branding"><?php the_custom_logo(); ?></div>
        <?php else : ?>
            <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></p>
        <?php endif; ?>

        <nav class="main-navigation" aria-label="<?php esc_attr_e('Menu principale', 'itemagold2026'); ?>">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'fallback_cb'    => false,
                'menu_class'     => 'primary-menu',
            ]);
            ?>
        </nav>
    </div>
</header>
<main id="content" class="site-container" role="main">
