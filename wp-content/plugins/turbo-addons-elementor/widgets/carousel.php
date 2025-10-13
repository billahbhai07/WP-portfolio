<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Turbo_Carousel_Widget extends Widget_Base {

    public function get_name() {
        return 'turbo-carousel';
    }

    public function get_title() {
        return esc_html__('Image Carousel', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-media-carousel trad-icon';
    }

    public function get_categories() {
        return ['turbo-addons'];
    }

    public function get_style_depends() {
        return [ 'trad-owl-carousel-style', 'owl-carousel-theme' ];
    }
    
    public function get_script_depends() {
        return [ 'trad-owl-carousel-script' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'carousel_responsive_settings',
            [
                'label' => esc_html__('Responsive Settings', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'responsive_items',
            [
                'label' => esc_html__('Responsive Items', 'turbo-addons-elementor'),
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'breakpoint' => '0',
                        'items' => 1,
                    ],
                    [
                        'breakpoint' => '600',
                        'items' => 1,
                    ],
                    [
                        'breakpoint' => '1024',
                        'items' => 2,
                    ],
                    [
                        'breakpoint' => '1366',
                        'items' => 2,
                    ],
                ],
                'fields' => [
                    [
                        'name' => 'breakpoint',
                        'label' => esc_html__('Breakpoint', 'turbo-addons-elementor'),
                        'type' => Controls_Manager::TEXT,
                        'default' => '0',
                    ],
                    [
                        'name' => 'items',
                        'label' => esc_html__('Items', 'turbo-addons-elementor'),
                        'type' => Controls_Manager::NUMBER,
                        'default' => 1,
                        'min' => 1,
                        'max' => 10,
                    ],
                ],
                'title_field' => '{{ breakpoint }}',
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section(
            'carousel_content',
            [
                'label' => esc_html__('Carousel Item', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'carousel_image', 
            [
                'label' => esc_html__('Upload Image', 'turbo-addons-elementor'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => trad_get_placeholder_image(),
                ],
            ]
        );

        $this->add_control(
            'carousel_items',
            [
                'label' => esc_html__('Carousel Items', 'turbo-addons-elementor'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'carousel_image' => trad_get_placeholder_image(),
                    ],
                    [
                        'carousel_image' => trad_get_placeholder_image(),
                    ],
                    [
                        'carousel_image' => trad_get_placeholder_image(),
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'carousel_box_section',
            [
                'label' => esc_html__('Box', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'carousel_box_bg',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .trad-container-wrapper',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'carousel_box_border',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-container-wrapper',
            ]
        );

        $this->add_responsive_control(
            'carousel_box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-container-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'carousel_box_shadow',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-container-wrapper',
            ]
        );

        $this->add_responsive_control(
            'carousel_box_margin',
            [
                'label' => esc_html__('Margin', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-container-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'carousel_box_padding',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-container-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 

        // Width Control
        $this->add_responsive_control(
            'trad_carousel_width',
            [
                'label' => esc_html__('Width', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'vw'],
                'range' => [
                    'px' => ['min' => 10, 'max' => 2000, 'step' => 1],
                    '%' => ['min' => 10, 'max' => 100, 'step' => 1],
                    'em' => ['min' => 1, 'max' => 50, 'step' => 0.1],
                    'vw' => ['min' => 10, 'max' => 100, 'step' => 1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-container-wrapper' => 'width: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        // Height Control
        $this->add_responsive_control(
            'trad_carousel_height',
            [
                'label' => esc_html__('Height', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'vh', '%'],
                'range' => [
                    'px' => ['min' => 10, 'max' => 2000, 'step' => 1],
                    'em' => ['min' => 1, 'max' => 50, 'step' => 0.1],
                    'vh' => ['min' => 10, 'max' => 100, 'step' => 1],
                    '%' => ['min' => 10, 'max' => 100, 'step' => 1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-container-wrapper' => 'height: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'carousel_image_section',
            [
                'label' => esc_html__('Image', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // Image Width Control
        $this->add_responsive_control(
            'trad_carousel_image_width',
            [
                'label' => esc_html__('Width', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'vw'],
                'range' => [
                    'px' => ['min' => 10, 'max' => 2000, 'step' => 1],
                    '%' => ['min' => 10, 'max' => 100, 'step' => 1],
                    'em' => ['min' => 1, 'max' => 50, 'step' => 0.1],
                    'vw' => ['min' => 10, 'max' => 100, 'step' => 1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-container-wrapper img' => 'width: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        // Image Height Control
        $this->add_responsive_control(
            'trad_carousel_image_height',
            [
                'label' => esc_html__('Height', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'vh', '%'],
                'range' => [
                    'px' => ['min' => 10, 'max' => 2000, 'step' => 1],
                    'em' => ['min' => 1, 'max' => 50, 'step' => 0.1],
                    'vh' => ['min' => 10, 'max' => 100, 'step' => 1],
                    '%' => ['min' => 10, 'max' => 100, 'step' => 1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-container-wrapper img' => 'height: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        // Group Border Control
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'trad_carousel_image_border',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-container-wrapper img',
            ]
        );

        // Border Radius Control
        $this->add_responsive_control(
            'trad_carousel_image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-container-wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Group Box Shadow Control
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'trad_carousel_image_box_shadow',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-container-wrapper img',
            ]
        );

        $this->end_controls_section();


        // Add Arrow
        $this->start_controls_section(
            'nav_arrow_section',
            [
                'label' => esc_html__('Arrow', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'nav_bg',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .trad-container-wrapper .owl-nav button',
            ]
        );

        $this->add_control(
            'nav_icon_color',
            [
                'label' => esc_html__('Nav Icon Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-nav button svg' => 'fill: {{VALUE}};', // Apply the color to the SVG icons
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'nav_button_border',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-container-wrapper .owl-nav button',
            ]
        );

        $this->add_responsive_control(
            'nav_button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-container-wrapper .owl-nav button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'nav_button_box_shadow',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-container-wrapper .owl-nav button',
            ]
        );
        

        $this->add_responsive_control(
            'nav_icon_size',
            [
                'label' => esc_html__('Nav Icon Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0.5,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => 0.5,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-container-wrapper .owl-nav button svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_icon_top',
            [
                'label' => esc_html__('Icon Position', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'unit' => 'px',
                    'size' => 0, // Default value
                ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => -10,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-container-wrapper .owl-nav button svg' => 'top: {{SIZE}}{{UNIT}}; position: relative;',
                ],
            ]
        );

        
        $this->add_responsive_control(
            'nav_top_position',
            [
                'label' => esc_html__('Arrow Position', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-container-wrapper .owl-nav button' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        ); 

        $this->add_control(
            'trad_nav_display',
            [
                'label' => esc_html__('Show Navigation', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'turbo-addons-elementor'),
                'label_off' => esc_html__('No', 'turbo-addons-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->end_controls_section();
        // Add Arrow
        $this->start_controls_section(
            'nav_dot_section',
            [
                'label' => esc_html__('Dots', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'dots_top',
            [
                'label' => esc_html__('Dots Top', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'unit' => '%',
                    'size' => 100, // Default value
                ],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => -10,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .owl-dots' => 'position: absolute; top: {{SIZE}}{{UNIT}};', // Apply the to owl-dots
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_left',
            [
                'label' => esc_html__('Dots Left', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'unit' => '%',
                    'size' => 48, // Default value
                ],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => -10,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .owl-dots' => 'position: absolute; left: {{SIZE}}{{UNIT}};', // Apply the to owl-dots
                ],
            ]
        );

        $this->add_control(
            'dots_background_color',
            [
                'label' => esc_html__('Dots Background Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-dots button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'active_dots_background_color',
            [
                'label' => esc_html__('Active Dots Background Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-dots button.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'trad_dots_display',
            [
                'label' => esc_html__('Show Dots', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'turbo-addons-elementor'),
                'label_off' => esc_html__('No', 'turbo-addons-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        // Prepare the responsive settings
        $responsive = [];
        if (!empty($settings['responsive_items'])) {
            foreach ($settings['responsive_items'] as $item) {
                $responsive[$item['breakpoint']] = $item['items'];
            }
        }
        ?>
        <div class="trad-container-wrapper">
            <div class="owl-slider">
                <div id="carousel" class="owl-carousel">
                    <?php
                        if ($settings['carousel_items']) {
                            foreach ($settings['carousel_items'] as $item) {
                                $image_url = $item['carousel_image']['url'];
                                ?>
                                    <div class="item">
                                        <img src="<?php echo esc_url($image_url); ?>" alt="carousel image">
                                    </div>
                                <?php
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <style>
            .trad-container-wrapper img {
            height: auto !important;
            width: 100% !important;
            }
            .trad-container-wrapper .owl-nav button {
            position: absolute;
            top: 50%;
            background-color: #000;
            color: #fff;
            margin: 0;
            transition: all 0.3s ease-in-out;
            }
            .trad-container-wrapper .owl-nav button.owl-prev {
            left: 0;
            }
            .trad-container-wrapper .owl-nav button.owl-next {
            right: 0;
            }

            .trad-container-wrapper .owl-dots {
            text-align: center;
            padding-top: 15px;
            }
            .trad-container-wrapper .owl-dots button.owl-dot {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            display: inline-block;
            background: #ccc;
            margin: 0 3px;
            }
            .trad-container-wrapper .owl-dots button.owl-dot.active {
            background-color: #000;
            }
            .trad-container-wrapper .owl-dots button.owl-dot:focus {
            outline: none;
            }
            .trad-container-wrapper .owl-nav button {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                background: rgba(255, 255, 255, 0.38);
            }
            .trad-container-wrapper span {
                font-size: 70px;    
                position: relative;
                top: -5px;
            }
            .trad-container-wrapper .owl-nav button:focus {
                outline: none;
            }
            .trad-container-wrapper .owl-item {
            height: 300px !important; /* Adjust this value as needed */
            display: flex;
            }
            .trad-container-wrapper .item {
                width: 100%;
            }
        </style>
        <script>
            jQuery(document).ready(function($) {
                var isEditMode = <?php echo Plugin::instance()->editor->is_edit_mode() ? 'true' : 'false'; ?>;
                if (isEditMode || !isEditMode) {
                    jQuery("#carousel").owlCarousel({
                            autoplay: true,
                            rewind: false, /* use rewind if you don't want loop */
                            margin: 20,
                            loop: true,
                            /*
                            animateOut: 'fadeOut',
                            animateIn: 'fadeIn',
                            */
                            responsiveClass: true,
                            autoHeight: true,
                            autoplayTimeout: 7000,
                            smartSpeed: 800,
                            nav: <?php echo ($settings['trad_nav_display'] === 'yes') ? 'true' : 'false'; ?>,
                            dots: <?php echo ($settings['trad_dots_display'] === 'yes') ? 'true' : 'false'; ?>,
                            navText: [
                                '<svg width="50" height="50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/></svg>',
                                '<svg width="50" height="50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>'],
                            responsive: {
                                <?php
                                    foreach ($responsive as $breakpoint => $items) {
                                        // ✅ Sanitize the breakpoint key
                                        $clean_breakpoint = preg_replace('/[^a-zA-Z0-9_-]/', '', $breakpoint);
                                        $clean_items = intval($items);

                                        if ($clean_breakpoint !== '') {
                                            echo "'" . esc_js($clean_breakpoint) . "': { items: " . esc_js($clean_items) . " },";
                                        }
                                    }
                                ?>
                            }

                            });
                }
            });
        </script>
        <?php
    }
    
    
}

Plugin::instance()->widgets_manager->register_widget_type(new Turbo_Carousel_Widget());
