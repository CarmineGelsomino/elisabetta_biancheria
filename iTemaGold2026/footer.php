<?php
/**
 * Footer template.
 *
 * @package iTemaGold2026
 */
?>
</main>
<footer class="site-footer" role="contentinfo">
    <div class="site-container">
        <p>
            <?php
            echo esc_html(
                sprintf(
                    /* translators: %s: current year. */
                    __('© %s OC Corporation. Tutti i diritti riservati.', 'itemagold2026'),
                    gmdate('Y')
                )
            );
            ?>
        </p>
        <?php
        wp_nav_menu([
            'theme_location' => 'footer',
            'container'      => false,
            'fallback_cb'    => false,
            'menu_class'     => 'footer-menu',
        ]);
        ?>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
