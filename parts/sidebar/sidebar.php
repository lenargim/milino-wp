<aside class="sidebar">
  <div class="sidebar__container">
    <h3>Materials you choose:</h3>
    <div class="sidebar__attributes">
					<?php if (isset($_COOKIE["product_cat"])):
						$category = json_decode(stripslashes($_COOKIE["product_cat"])); ?>
       <div class="sidebar__attribute">
         <div>Room:</div>
         <div><?php echo $category; ?></div>
       </div>
					<?php endif; ?>

					<?php if (isset($_COOKIE["door"])):
						$doorArr = json_decode(stripslashes($_COOKIE["door"]));
						foreach ($doorArr as $index => $cat):
							if ($index === 0) {
								$label = 'Door type';
							} else if ($index === 1) {
								$label = 'Door Finish material';
							} else if ($index === 2) {
								$label = 'Door finish color';
							}
							?>

        <div class="sidebar__attribute">
          <div><?php echo $label ?>:</div>
          <div><?php echo $cat; ?></div>
        </div>
						<?php endforeach; ?>
					<?php endif; ?>

					<?php if (isset($_COOKIE["box_material"])):
						$box = json_decode(stripslashes($_COOKIE["box_material"])); ?>

       <div class="sidebar__attribute">
         <div>Box Material:</div>
         <div><?php echo $box; ?></div>
       </div>
					<?php endif; ?>

					<?php if (isset($_COOKIE["drawer"])):
						$drawerArr = json_decode(stripslashes($_COOKIE["drawer"]));
						foreach ($drawerArr as $index => $cat):
							if ($index === 0) {
								$label = 'Drawer Brand';
							} else if ($index === 1) {
								$label = 'Drawer Type';
							} else if ($index === 2) {
								$label = 'Drawer color';
							}
							?>

        <div class="sidebar__attribute">
          <div><?php echo $label ?>:</div>
          <div><?php echo $cat; ?></div>
        </div>
						<?php endforeach; ?>
					<?php endif; ?>
    </div>
  </div>
  <?php if (!is_page(6)): ?>
    <a href="<?php echo get_page_link(6);?>" class="sidebar__back button">&#x2190; Back to Order Form</a>
  <?php endif; ?>
</aside>


