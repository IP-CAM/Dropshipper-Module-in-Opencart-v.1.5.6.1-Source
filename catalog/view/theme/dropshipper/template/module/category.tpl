<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
    <div class="box-category">
      <ul class="level-0">
        <?php foreach ($categories as $category) { ?>
        <li <?php if ($category['children']) : ?> class="parent" <?php endif; ?>>
          <?php if ($category['category_id'] == $category_id) { ?>
          	<a href="<?php echo $category['href']; ?>" class="active"><?php echo $category['name']; ?>
          	<?php if ($category['children']) : ?> <span></span> <?php endif; ?></a>
          <?php } else { ?>
          	<a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?><?php if ($category['children']) : ?> <span></span> <?php endif; ?></a>
          	
          <?php } ?>
           <?php if ($category['children']) { ?>
          <ul class="children">
            <?php foreach ($category['children'] as $child) { ?>
            <li>
              <?php if ($child['category_id'] == $child_id) { ?>
              <a href="<?php echo $child['href']; ?>" class="active"><?php echo $child['name']; ?></a>
              <?php } else { ?>
              <a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
              <?php } ?>
            </li>
            <?php } ?>
          </ul>
          <?php } ?>
         </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</div>
