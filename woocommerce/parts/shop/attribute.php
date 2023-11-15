<?php
$category = $args['category'];
$attributesArr = $args['attributes_arr'];
$slug = $args['slug'];
$noFilter = $args['no_filter'];

$args = [
	'type' => 'variable',
	'category' => $category,
	'status' => 'publish',
	'limit' => 1,
	'order' => 'ASC',
];

if (!empty($attributesArr)) {
	$args['attributes'] = $attributesArr;
}

$products = wc_get_products($args);

if ($products):
	$product = $products[0];
	$pa_slug = "pa_" . $slug;
	$name = get_taxonomy($pa_slug)->labels->singular_name;
	$arr = [];


	if ($noFilter) {
		$attributesIds = $product->get_attributes()[$pa_slug]['options'];
		foreach ($attributesIds as $attributesId):
			$term = get_term_by('term_id', $attributesId, $pa_slug);
			$arr[] = $term->slug;
		endforeach;
	} else {
		$defaultQuery = [
			'relation' => 'AND',
			[
				'key' => 'attribute_pa_push-to-open-drawer',
				'value' => 'no',
			],
			[
				'key' => 'attribute_pa_push-to-open-door',
				'value' => 'no',
			],
			[
				'key' => 'attribute_pa_glass-shelf',
				'value' => 'no',
			],
			[
				'key' => 'attribute_pa_glass-door',
				'value' => 'no',
			],
		];
		$meta_query = [
			...$defaultQuery
		];
		foreach ($attributesArr as $key => $value):
			$meta_query[] = [
				'key' => 'attribute_pa_' . $key,
				'value' => $value,
			];
		endforeach;

		$query = new \WP_Query(array(
			'post_parent' => $product->get_ID(),
			'post_status' => 'publish',
			'post_type' => 'product_variation',
			'posts_per_page' => -1,
			'meta_query' => $meta_query,
			'orderby' => 'menu_order',

		));

		$result = array();
		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->next_post();
				$result[] = $query->post;
			}
			wp_reset_postdata();
		}
//		echo var_export($meta_query);
		foreach ($result as $variation):
			$var_ID = $variation->ID;
			$val = get_post_meta($var_ID, 'attribute_pa_' . $slug)[0];
			$arr[] = $val;
		endforeach;
	}
	?>


  <h2><?php echo $name; ?></h2>
  <div class="shop__row" id="<?php echo $slug; ?>">
			<?php foreach (array_unique($arr) as $term_slug):
				$term = get_term_by('slug', $term_slug, $pa_slug); ?>
     <div class="shop__item" id="<?php echo $term->name; ?>">
       <input type="radio" name="<?php echo $slug; ?>"
              value="<?php echo $term->slug; ?>" tabindex="-1"
              id="<?php echo $slug . '-' . $term->slug; ?>"
              class="show__row-input"
              data-type="attribute">
       <label for="<?php echo $slug . '-' . $term->slug;
							?>" class="img">
  <span><?php echo $term->name;
			?></span>
								<?php
								$thumbnail_id = get_woocommerce_term_meta($term->term_id, 'product_attribute_image', true);
								$image = wp_get_attachment_image_src($thumbnail_id, 'thumbnail');

								?>
         <img src="<?php echo $image ? $image[0] : IMAGES_PATH . 'no-img.jpeg';
									?>" alt="<?php echo $term->name; ?>"></label></div>
			<?php endforeach; ?>
  </div>
<?php
endif;


function filterTerms($attributesArr, $variation)
{

	$length = count($attributesArr);
	$i = 0;
	foreach ($attributesArr as $key => $val):
		if ($variation['attributes']['attribute_pa_' . $key] === $val || $variation['attributes']['attribute_pa_' . $key] === ''):
			$i++;
		endif;
	endforeach;
	return $length === $i;
}