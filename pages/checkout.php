<?php

// Template Name: Checkout

get_template_part('parts/header/head'); ?>

<main class="checkout-page">
    <?php echo do_shortcode('[woocommerce_checkout]')?>
</main>


<?php get_template_part('parts/footer/footer'); ?>

