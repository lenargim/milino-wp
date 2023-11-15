<?php
$arguments = $args['args'];
$slug = $args['slug'];
$name = $args['name'];
$categories = get_categories($arguments);

if ($categories): ?>

  <div class="shop__row" id="<?php echo $slug; ?>">
			<?php foreach ($categories as $category): ?>
     <div class="shop__item" id="<?php echo $category->name; ?>">
       <input type="radio"
              name="<?php echo $slug; ?>"
              value="<?php echo $category->name; ?>"
              data-id="<?php echo $category->term_id; ?>"
              tabindex="-1"
              id="<?php echo $slug . '-' . $category->slug; ?>"
              class="show__row-input"
              data-type="category">
       <label for="<?php echo $slug . '-' . $category->slug; ?>" class="img">
         <span><?php echo $category->name; ?></span>
								<?php $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
								$term_img = wp_get_attachment_url($thumbnail_id); ?>
         <img src="<?php echo $term_img ? $term_img : IMAGES_PATH . 'no-img.jpeg' ?>"
              alt="<?php echo $category->name; ?>">
       </label>
     </div>
			<?php endforeach; ?>
  </div>
<?php endif; ?>