<?php
//Template Name: Order Form


if (isset($_COOKIE['product_cat'])) {
	setcookie('product_cat', '', time() + (86400 * 15), "/");
  unset($_COOKIE['product_cat']);
}

if (isset($_COOKIE['door'])) {
	setcookie('door', '', time() + (86400 * 15), "/");
	unset($_COOKIE['door']);
}
if (isset($_COOKIE['box_material'])) {
	setcookie('box_material', '', time() + (86400 * 15), "/");
	unset($_COOKIE['box_material']);
}
if (isset($_COOKIE['drawer'])) {
	setcookie('drawer', '', time() + (86400 * 15), "/");
	unset($_COOKIE['drawer']);
}

get_template_part('parts/header/head');

defined('ABSPATH') || exit;



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
												'type' => 'product_cat',
												'slug' => 'room',
												'name' => 'Room',
												'is_main' => 1,
												'parent_id' => 0
											]
											?>
<!--            <a href="/cabinets" class="submit button"></a>-->
											<?php get_template_part('woocommerce/parts/shop/category', null, $params); ?>
          </form>
        </div>
      </form>
    </main>
			<?php get_template_part('parts/sidebar/sidebar'); ?>
  </div>

<?php get_template_part('parts/footer/footer'); ?>