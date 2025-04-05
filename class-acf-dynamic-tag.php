<?php

use Elementor\Core\DynamicTags\Tag;
use Elementor\Controls_Manager;

class ACF_Dynamic_Tag extends Tag {

    public function get_name() {
        return 'acf_dynamic_tag';
    }

    public function get_title() {
        return 'ACF Field';
    }

    public function get_group() {
        return 'site';
    }

    public function get_categories() {
        return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
    }

    protected function register_controls() {
        $this->add_control(
            'field_name',
            [
                'label' => 'ACF Field Name',
                'type' => Controls_Manager::TEXT,
                'placeholder' => 'e.g. my_custom_field',
            ]
        );
    }

    public function render() {
        $field_name = $this->get_settings('field_name');

        if (function_exists('get_field')) {
            $value = get_field($field_name);

            if (is_array($value)) {
                echo implode(', ', $value);
            } else {
                echo $value;
            }
        } else {
            echo '[ACF not active]';
        }
    }
}
