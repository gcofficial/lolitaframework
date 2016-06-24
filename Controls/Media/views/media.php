<!-- .lolita-media-control -->
<div class="lolita-media-control" data-control="media" data-name="<?php echo $me->getName(); ?>">
    
    <button type="button" class="button button-primary lolita-media-add <?php echo $add_button_hide; ?>">
        <?php _e('Add'); ?>
    </button>
    
    <!-- .media-preview -->
    <div class="media-preview <?php echo $preview_hide; ?>">
        <div class="left">
            <div class="media-preview-inner">
                <img class="media-thumbnail " alt="<?php echo esc_attr($title); ?>" src="<?php echo $src; ?>" data-id="<?php echo $value; ?>" data-src="<?php echo $src; ?>">
            </div>
        </div>
        <div class="right">
            <div class="media-infos">
                <div class="media-buttons">
                    <button id="lolita-media-remove"  class="button lolita-button-remove" type="button"><?php _e('Delete'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <!-- .media-preview END -->
    
    <input type="hidden" <?php echo $attributes_str; ?> >
</div>
<!-- .lolita-media-control END -->