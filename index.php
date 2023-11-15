<?php
/**
 * The base (and only) template
 *
 * @package WordPress
 * @subpackage intentionally-blank
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>><?php wp_body_open(); ?>
<div id="page">

    <div class="site-title">
        <div class="site-title-bg">
            <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php
			$blank_description = get_bloginfo( 'description', 'display' );
			if ( $blank_description || is_customize_preview() ) :
				?>
                <p class="site-description"><?php echo esc_html( $blank_description ); ?></p>
			<?php endif; ?>
        </div>
    </div>
	<?php the_custom_logo(); ?>
    <footer id="colophon" class="site-footer">
		<?php if ( get_theme_mod( 'blank_show_copyright', true ) ) : ?>
            <div class="site-info">
				<?php echo wp_kses_post( get_theme_mod( 'blank_copyright', __( 'Intentionally Blank - Proudly powered by WordPress', 'intentionally-blank' ) ) ); ?>
            </div>
		<?php endif; ?>
    </footer>
</div><!-- #page -->
<?php wp_footer(); ?></body>
</html>
