<?php
/**
 * WooCommerce wrapper template.
 *
 * @package iTemaGold2026
 */

get_header();
?>
<section aria-label="<?php esc_attr_e('Catalogo prodotti', 'itemagold2026'); ?>">
    <?php woocommerce_content(); ?>
</section>
<?php
get_footer();
