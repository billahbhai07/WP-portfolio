<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager; 
use Elementor\Icons_Manager; 
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class TRAD_Fancy_Alert extends Widget_Base {

    public function get_name() {
        return 'trad-fancy-alert';
    }

    public function get_title() {
        return esc_html__('Fancy Alert', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-alert trad-icon';
    }

    public function get_categories() {
        return ['turbo-addons'];
    }

    public function get_style_depends() {
        return ['trad-fancy-alert-style'];
    }

    public function get_script_depends() {
        return [ 'trad-fancy-alert-script' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'alert_type',
            [
                'label' => esc_html__('Alert Type', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'icon' => esc_html__('Icon', 'turbo-addons-elementor'),
                    'image' => esc_html__('Image', 'turbo-addons-elementor'),
                ],
                'default' => 'icon',
            ]
        );

        $this->add_control(
            'alert_icon',
            [
                'label' => esc_html__('Choose Icon', 'turbo-addons-elementor'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-info-circle',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'alert_type' => 'icon',
                ],
            ]
        );

        $this->add_control(
            'alert_image',
            [
                'label' => esc_html__('Upload Image', 'turbo-addons-elementor'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'alert_type' => 'image',
                ],
            ]
        );

        $this->add_control(
            'alert_text',
            [
                'label' => esc_html__('Alert Title', 'turbo-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('This is an alert!', 'turbo-addons-elementor'),
            ]
        );

        $this->add_control(
            'alert_text_description',
            [
                'label' => esc_html__('Alert Description', 'turbo-addons-elementor'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Alert description goes to here.', 'turbo-addons-elementor'),
                'placeholder' => esc_html__('Enter alert description', 'turbo-addons-elementor'),
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'alert_style_section',
            [
                'label' => esc_html__('Background Style', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Width Control
        $this->add_control(
            'container_width',
            [
                'label' => __( 'Width', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw' ],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 1200,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    'vw' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-fancy-alert-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Height Control
        $this->add_control(
            'container_height',
            [
                'label' => __( 'Height', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh' ],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 85,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-fancy-alert-container' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#2e3192',
                'selectors' => [
                    '{{WRAPPER}} .trad-fancy-alert-container' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],  
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-fancy-alert-container' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'icor_image_style_section',
            [
                'label' => esc_html__('Icon or Image Style', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_width',
            [
                'label' => esc_html__('Image Width', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 30,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'condition' => [
                    'alert_type' => 'image',
                ],
            ]
        );

        $this->add_control(
            'image_height',
            [
                'label' => esc_html__('Image Height', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 30,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'condition' => [
                    'alert_type' => 'image',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon i' => 'color: {{VALUE}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .elementor-icon svg' => 'fill: {{VALUE}};', // SVG icons
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon i' => 'font-size: {{SIZE}}{{UNIT}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .elementor-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', // SVG icons
                ],
                'condition' => [
                    'alert_type' => 'icon',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'alert_title_style_section',
            [
                'label' => esc_html__('Alert Title Style', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'alert_text_alignment',
            [
                'label' => __( 'Title Alignment', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __( 'Justify', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .trad-fancy-alert-text' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'alert_title_font_size',
            [
                'label' => esc_html__('Alert Title Font Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-fancy-alert-text' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'alert_title_font_color',
            [
                'label' => esc_html__('Alert Title Font Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff', // Default black color
                'selectors' => [
                    '{{WRAPPER}} .trad-fancy-alert-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'alert_description_style_section',
            [
                'label' => esc_html__('Alert Description Style', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'description_alignment',
            [
                'label' => __( 'Description Alignment', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __( 'Justify', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .trad-fancy-alert-description' => 'text-align: {{VALUE}};',
                ],
            ]
        );      
      
        $this->add_control(
            'alert_description_font_size',
            [
                'label' => esc_html__('Alert Description Font Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-fancy-alert-description' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'alert_description_font_color',
            [
                'label' => esc_html__('Alert Description Font Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff', // Default black color
                'selectors' => [
                    '{{WRAPPER}} .trad-fancy-alert-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'alert_close_button_style_section',
            [
                'label' => esc_html__('Alert Button Style', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // Background Color Control
        $this->add_control(
            'close_button_bg_color',
            [
                'label' => __( 'Background Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#5a48ff73',
                'selectors' => [
                    '{{WRAPPER}} .trad-fancy-alert-close-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Text Color Control
        $this->add_control(
            'close_button_text_color',
            [
                'label' => __( 'Text Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .trad-fancy-alert-close-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Font Size Control
        $this->add_control(
            'close_button_font_size',
            [
                'label' => __( 'Font Size', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 3,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 14,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-fancy-alert-close-button' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Top Position Control
        $this->add_control(
            'close_button_top_position',
            [
                'label' => __( 'Top Position', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-fancy-alert-close-button' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Left Position Control
        $this->add_control(
            'close_button_left_position',
            [
                'label' => __( 'Left Position', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 41,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-fancy-alert-close-button' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Button Border Control
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'close_button_border',
                'label' => esc_html__('Button Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-fancy-alert-close-button',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid', // Default border style
                    ],
                    'width' => [
                        'default' => [
                            'top' => '1',
                            'right' => '1',
                            'bottom' => '1',
                            'left' => '1',
                            'unit' => 'px'
                        ]
                    ],
                    'color' => [
                        'default' => '#a1a0a06e' // Default border color
                    ]
                ]
            ]
        );

        $this->add_control(
            'close_button_border_radius',
            [
                'label' => esc_html__('Button Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-fancy-alert-close-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Button Box Shadow Control
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'close_button_box_shadow',
                'label' => esc_html__('Button Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-fancy-alert-close-button',
            ]
        );

        $this->end_controls_section();
    }
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="trad-fancy-alert-container">
            <?php if ($settings['alert_type'] === 'image') : ?>
                <img src="<?php echo esc_url($settings['alert_image']['url']); ?>" 
                    style="width: <?php echo esc_attr($settings['image_width']['size'] . $settings['image_width']['unit']); ?>; 
                            height: <?php echo esc_attr($settings['image_height']['size'] . $settings['image_height']['unit']); ?>;">
            <?php else : ?>
                <?php if ( ! empty( $settings['alert_icon']['value'] ) ) : ?>
                    <div class="elementor-icon">
                        <?php
                            // Render the icon with proper sanitization
                            Icons_Manager::render_icon( $settings['alert_icon'], [ 'aria-hidden' => 'true' ] );
                        ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <div class="trad-fancy-alert-content" style="width: 100%; display: flex; flex-direction: column;">
                <span class="trad-fancy-alert-text" style="width: 100%;">
                    <?php echo esc_html($settings['alert_text']); ?>
                </span>
                <p class="trad-fancy-alert-description">
                    <?php echo esc_html($settings['alert_text_description']); ?>
                </p>
            </div>
            <button class="trad-fancy-alert-close-button" style="position: relative;" id="trad-CloseButtonDataStore">
                &times;
            </button>
        </div>
        <?php
    }   
}

// Register widget
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Fancy_Alert() );
