<?php

  // Check if we should show standard page or not.
  $settings = _ptb_get_settings();
  $show_standard_page = true;
  if (isset($settings[$post_type]) && isset($settings[$post_type]['show_standard_page'])) {
    $show_standard_page = $settings[$post_type]['show_standard_page'];
  }

?>

<div class="wrap">

  <h2>
    <?php echo __('Add new page type', 'ptb'); ?>

    <label class="screen-reader-text" for="add-new-page-search">
      <?php _e('Search page types', 'ptb'); ?>
    </label>

    <input placeholder="Search page types..." type="search" name="add-new-page-search" id="add-new-page-search" class="ptb-search">
  </h2>

  <ul class="ptb-box-list">
    <?php
      $page_types = _ptb_get_all_page_types();

      foreach ($page_types as $key => $value) {
        echo _ptb_apply_template('includes/admin/views/partials/add-new-item.php', array(
              'title'       => $value->name,
              'description' => $value->description,
              'image'       => $value->get_thumbnail(),
              'url'         => _ptb_get_page_new_url ($value->file_name, $post_type)
        ));
      }

      if ($show_standard_page) {
        echo _ptb_apply_template('includes/admin/views/partials/add-new-item.php', array(
              'title'       => __('Standard page', 'ptb'),
              'description' => __('Just the normal WordPress page', 'ptb'),
              'image'       => _ptb_page_type_default_thumbnail(),
              'url'         => 'post-new.php?post_type=page'
        ));
      }
    ?>
  </ul>
</div>

