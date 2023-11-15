<aside class="sidebar">
  <h3>Materials you choose:</h3>
  <div class="sidebar__attributes">
			<?php if (isset($_COOKIE["attributes"])):
				$attrArr = json_decode(stripslashes($_COOKIE["attributes"]));
				foreach ($attrArr as $attribute_key => $attribute_value):
					$pa = 'pa_' . $attribute_key;
					$taxonomy = get_taxonomy($pa);
					$term = get_term_by('slug', $attribute_value, $pa);
					?>
      <div class="sidebar__attribute">
        <div><?php echo $taxonomy->labels->singular_name; ?>:</div>
        <div><?php echo $term->name; ?></div>
      </div>
				<?php
				endforeach; ?>
			<?php endif; ?>
  </div>
</aside>


