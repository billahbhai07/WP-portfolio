<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class TRAD_flipbook_img extends Widget_Base {

    public function get_name() {
        return 'flipbook-img';
    }

    public function get_title() {
        return esc_html__('Flip Book', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-column trad-icon';
    }

    public function get_categories() {
        return ['turbo-addons'];
    }

    public function get_style_depends() {
        return ['trad-flip-book-img-style'];
    }

    public function get_script_depends() {
        return [ 'trad-flip-book-img-script' ];
    }

    protected function _register_controls() {

        // ==================Content Section=================================
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Add a select control to choose between PDF and images
        $this->add_control(
            'flipbook_type',
            [
                'label' => esc_html__('Flipbook Type', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'image' => esc_html__('Image', 'turbo-addons-elementor'),
                ],
                'default' => 'image',
            ]
        );

        // Add a gallery control for images (conditionally shown when 'image' is selected)
        $this->add_control(
            'flipbook_images',
            [
                'label' => esc_html__('Flipbook Images', 'turbo-addons-elementor'),
                'type' => Controls_Manager::GALLERY,
                'condition' => [
                    'flipbook_type' => 'image',
                ],
                'default' => [],
            ]
        );
        $this->end_controls_section();

        // =======================Style Section==================================
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        // Get the settings
        $settings = $this->get_settings_for_display();
        $flipbook_type = $settings['flipbook_type'];

        if ($flipbook_type === 'image') {
            // Render the image-based flipbook
            $images = $settings['flipbook_images'];

            if (empty($images)) {
                echo '<div>' . esc_html__('No images selected.', 'turbo-addons-elementor') . '</div>';
                return;
            }
        ?>
            <div class="book-section">
                <div class="trad-flip-book-imag-container">
                    <?php foreach ($images as $index => $image) : ?>
                        <div class="trad-flip-image-right">
                            <figure class="trad-flip-image_back " style="background-image: url('<?php echo esc_url($image['url']); ?>');"></figure>
                            <figure class="trad-flip-image_front" style="background-image: url('<?php echo esc_url($image['url']); ?>');"></figure>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button onclick="turnLeft()">Prev</button>
                <button onclick="turnRight()">Next</button>
            </div>
        <?php
        ?>

        <?php
        }
    }
}

// Register widget
Plugin::instance()->widgets_manager->register_widget_type(new TRAD_flipbook_img());
