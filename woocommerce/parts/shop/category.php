<?php
$taxonomy = $args['type'];
$slug = $args['slug'];
$name = $args['name'];
$isMain = +$args['is_main'];
$parentId = $args['parent_id'];

$arguments = [
	'taxonomy' => $taxonomy,
	'hide_empty' => false,
	'parent' => $isMain === 1 ? 0 : +$parentId,
	'orderby' => 'id'
];

//if ($taxonomy === 'product_cat' && $isMain === 0 && !count(get_terms($arguments)) ) {
//	$taxonomy = 'door';
//	$slug = 'door-type';
//	$name = 'Door type';
//	$arguments['taxonomy'] = $taxonomy;
//	$arguments['parent'] = 0;
//}
$categories = get_terms($arguments);

if ($categories): ?>
  <div class="shop__block" id="<?php echo $slug; ?>">
    <h2><?php echo $name; ?></h2>
    <div class="shop__row">
					<?php foreach ($categories as $category): ?>
       <div class="shop__item" id="<?php echo $category->name; ?>">
         <input type="radio"
                name="<?php echo $slug; ?>"
                value="<?php echo $category->name; ?>"
                data-id="<?php echo $category->term_id; ?>"
                data-taxonomy="<?php echo $category->taxonomy; ?>"
                data-label="<?php echo $name; ?>"
                tabindex="-1"
                id="<?php echo $slug . '-' . $category->slug; ?>"
                class="show__row-input">
         <label for="<?php echo $slug . '-' . $category->slug; ?>" class="img">
<?php
$taxonomy_img = get_taxonomy_image( $category->term_id , false );
//echo var_export($taxonomy_img);

?>
           <span><?php echo $category->name; ?></span>
										<?php $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
										$term_img = wp_get_attachment_url($thumbnail_id);
//                    echo var_export($term_img);
                    if ($term_img === false) {
                      $term_img = $taxonomy_img;
                    }

                    ?>
           <img src="<?php echo $term_img ? $term_img : IMAGES_PATH . 'no-img.jpeg' ?>"
                alt="<?php echo $category->name; ?>">
         </label>
       </div>
					<?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>