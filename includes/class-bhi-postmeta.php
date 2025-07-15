<?php
namespace PRC\Platform\Node_System;

class Post_Meta {

    public function add_meta_boxes() {
        add_meta_box(
            'bhi_postmeta',
            __('Post Metadata', 'bhi'),
            [$this, 'render_meta_box'],
            ['post'], // or more CPTs
            'normal',
            'default'
        );
    }

    public function render_meta_box($post) {
        $fields = [
            'date_from', 'date_to', 'date_string', 'date_label',
            'geo_lat', 'geo_long', 'geo_label', 'geo_coordinates',
            'narrative_country', 'narrative_content'
        ];

        foreach ($fields as $field) {
            $value = get_post_meta($post->ID, $field, true);
            echo '<p><label for="'.$field.'">'.$field.':</label><br />';
            echo '<input type="text" name="'.$field.'" value="'.esc_attr($value).'" class="widefat" /></p>';
        }
    }

    public function save_meta($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

        $fields = [
            'date_from', 'date_to', 'date_string', 'date_label',
            'geo_lat', 'geo_long', 'geo_label', 'geo_coordinates',
            'narrative_country', 'narrative_content'
        ];

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
}
