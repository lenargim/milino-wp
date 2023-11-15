<?php
//Template Name: Order Form

defined('ABSPATH') || exit;

if (isset($_COOKIE['attributes'])) {
	setcookie("attributes", "", time() - 3600, "/");
	unset($_COOKIE['attributes']);
}

get_template_part('parts/header/head');
?>
  <div class="order-form">
    <main>
     <div class="container">
      <?php get_template_part('parts/header/header-menu'); ?>
     </div>
      <form id="order-form">
        <div class="container">
          <form>
            <h1>Order form</h1>
											<?php
											$params = [
												'args' => [
													'taxonomy' => 'product_cat',
													'orderby' => 'id',
													'parent' => 0,
													'hide_empty' => false,
												],
												'slug' => 'room',
												'name' => 'Room',
											]
											?>
            <h2>Cabinets</h2>
            <a href="/shop-custom" class="submit button">Next</a>
											<?php get_template_part('woocommerce/parts/shop/category', null, $params); ?>
          </form>
        </div>
      </form>
    </main>
			<?php get_template_part('parts/sidebar/sidebar'); ?>
  </div>

<?php get_template_part('parts/footer/footer'); ?>