<?php
//Template Name: Cabinets

defined('ABSPATH') || exit;


if (!isset($_COOKIE["product_cat"])) {
	wp_redirect('/order-form/');
	exit;
}


get_template_part('parts/header/head');
?>
  <div class="shop-custom">
    <main>
      <div class="container">
							<?php get_template_part('parts/header/header-menu'); ?>
      </div>
      <form id="shop-custom-form">
        <div class="container">
          <form>
            <h1>Shop</h1>

            <div class="shop-custom__slider img">
              <img id="category-img" src="<?php echo IMAGES_PATH . 'default-cabinets.png';?>" alt="Default Cabinets">
            </div>
											<?php
											$category = json_decode(stripslashes($_COOKIE["product_cat"]));

											//											$products = wc_get_products($args);

											$parent = get_term_by('name', $category, 'product_cat');
											$filterArgs = [
												'taxonomy' => 'product_cat',
												'child_of' => $parent->term_id
											];
											$categories = get_categories($filterArgs);
											if (count($categories)): ?>
             <div class="product__categories">
														<?php foreach ($categories as $category): ?>
                <div class="product__category">
                  <input type="radio" name="filter" value="<?php echo $category->name; ?>"
                         id="<?php echo $category->slug; ?>"
                         class="filter-cabinets"
                  >
                  <label for="<?php echo $category->slug; ?>" class="img category-hover">
                    <span><?php echo $category->name ?></span>
																			<?php $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
																			$term_img = wp_get_attachment_url($thumbnail_id); ?>
                    <img src="<?php echo $term_img ? $term_img : IMAGES_PATH . 'no-img.jpeg' ?>"
                         alt="<?php echo $category->name; ?>">
                  </label>
                </div>
														<?php endforeach; ?>
             </div>
											<?php endif; ?>
            <div class="product__list"></div>
          </form>
        </div>
      </form>
    </main>
			<?php get_template_part('parts/sidebar/sidebar'); ?>
  </div>

<?php get_template_part('parts/footer/footer'); ?>