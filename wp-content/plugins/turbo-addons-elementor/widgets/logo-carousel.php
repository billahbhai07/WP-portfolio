<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Trad_Logo_Carousel extends Widget_Base {
    public function get_name() {
        return 'trad-logo-carousel';
    }

    public function get_title() {
        return esc_html__('Logo Carousel', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-logo trad-icon'; // Choose an appropriate icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
    }


    protected function get_upsale_data() {
		return [
			'condition' => ! Utils::has_pro(),
			'image' => esc_url( ELEMENTOR_ASSETS_URL . 'images/go-pro.svg' ),
			'image_alt' => esc_attr__( 'Upgrade', 'turbo-addons-elementor' ),
			'title' => esc_html__( "Hey Grab your visitors' attention", 'turbo-addons-elementor' ),
			'description' => esc_html__( 'Get the widget and grow website with Turbo Addons Pro.', 'turbo-addons-elementor' ),
			'upgrade_url' => esc_url( 'https://turbo-addons.com/pricing/' ),
			'upgrade_text' => esc_html__( 'Upgrade Now', 'turbo-addons-elementor' ),
		];
	}

    public function get_style_depends() {
        return [ 'trad-logo-carousel-style', 'trad-owl-carousel-style' ];
    }
    
    public function get_script_depends() {
        return [ 'trad-logo-carousel-script', 'trad-owl-carousel-script' ];
    }
    
    protected function register_controls() {
        $this->start_controls_section(
            'section_logo_carousel',
            [
                'label' => esc_html__( 'Content', 'turbo-addons-elementor' ),
            ]
        );
    
        $repeater = new Repeater();
    
        $repeater->add_control(
            'logo_image',
            [
                'label' => esc_html__( 'Logo Image', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => trad_get_placeholder_image(),
                ],
            ]
        );
    
        $repeater->add_control(
            'logo_link',
            [
                'label' => esc_html__( 'Logo Link', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-logo-link.com',
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );
    
        $this->add_control(
            'logos',
            [
                'label' => esc_html__( 'Logo Items', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'logo_image' => [ 'url' => trad_get_placeholder_image() ],
                        'logo_link' => [ 'url' => '#' ],
                    ],
                    [
                        'logo_image' => [ 'url' => trad_get_placeholder_image() ],
                        'logo_link' => [ 'url' => '#' ],
                    ],
                    [
                        'logo_image' => [ 'url' => trad_get_placeholder_image() ],
                        'logo_link' => [ 'url' => '#' ],
                    ],
                    [
                        'logo_image' => [ 'url' => trad_get_placeholder_image() ],
                        'logo_link' => [ 'url' => '#' ],
                    ],
                    [
                        'logo_image' => [ 'url' => trad_get_placeholder_image() ],
                        'logo_link' => [ 'url' => '#' ],
                    ],
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_logo_carousel_settings',
            [
                'label' => esc_html__( 'Carousel Settings', 'turbo-addons-elementor' ),
            ]
        );

        $this->add_responsive_control(
            'carousel_items',
            [
                'label' => esc_html__( 'Columns', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'default' => 4,
                'tablet_default' => 3,
                'mobile_default' => 2,
                'selectors' => [],
            ]
        );
        
        $this->add_responsive_control(
            'carousel_slide_by',
            [
                'label' => esc_html__( 'Scroll Per Slide', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'default' => 1,
                'tablet_default' => 1,
                'mobile_default' => 1,
            ]
        );

        $this->add_responsive_control(
            'carousel_nav_style',
            [
                'label' => esc_html__( 'Navigation', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'both'  => esc_html__( 'Arrows & Dots', 'turbo-addons-elementor' ),
                    'arrows' => esc_html__( 'Arrows Only', 'turbo-addons-elementor' ),
                    'dots' => esc_html__( 'Dots Only', 'turbo-addons-elementor' ),
                    'none' => esc_html__( 'None', 'turbo-addons-elementor' ),
                ],
                'default' => 'both',
                'tablet_default' => 'both',
                'mobile_default' => 'dots',
            ]
        );  
        
        $this->add_control(
            'carousel_autoplay',
            [
                'label' => esc_html__( 'Autoplay', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'turbo-addons-elementor' ),
                'label_off' => esc_html__( 'No', 'turbo-addons-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        
        $this->add_control(
            'carousel_autoplay_timeout',
            [
                'label' => esc_html__( 'Autoplay Delay (ms)', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1000,
                'max' => 10000,
                'step' => 100,
                'default' => 3000,
                'condition' => [
                    'carousel_autoplay' => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'carousel_autoplay_speed',
            [
                'label' => esc_html__( 'Transition Speed (ms)', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 100,
                'max' => 5000,
                'step' => 100,
                'default' => 1000,
                'condition' => [
                    'carousel_autoplay' => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'carousel_prev_icon',
            [
                'label' => esc_html__( 'Prev Icon', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-left',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'carousel_nav_style!' => 'none',
                ],
            ]
        );
        
        $this->add_control(
            'carousel_next_icon',
            [
                'label' => esc_html__( 'Next Icon', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-right',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'carousel_nav_style!' => 'none',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('carousel_logo_container_style', [
            'label' => esc_html__('Box', 'turbo-addons-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

		$this->add_responsive_control(
            'carousel_logo_padding_controls',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
					'unit'   => 'px',
				],
                'selectors' => [
                    '{{WRAPPER}} .trad-logo-carousel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'carousel_logo_margin_controls',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
					'unit'   => 'px',
				],
                'selectors' => [
                    '{{WRAPPER}} .trad-logo-carousel' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'carousel_logo_box_shadow',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-logo-carousel',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'carousel_logo_box_border',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-logo-carousel',
            ]
        );

        $this->add_control(
            'carousel_logo_box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-logo-carousel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('carousel_logo_arrow_container_style', [
            'label' => esc_html__('Arrow', 'turbo-addons-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control(
            'carousel_logo_arrow_width',
            [
                'label' => esc_html__( 'Width', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 1920,
					],
					'em' => [
						'min' => 1,
						'max' => 10,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 30,
				],
                'selectors' => [
                    '{{WRAPPER}} .trad-logo-carousel .owl-nav button' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_logo_arrow_height',
            [
                'label' => esc_html__( 'Height', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 1920,
					],
					'em' => [
						'min' => 1,
						'max' => 10,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 30,
				],
                'selectors' => [
                    '{{WRAPPER}} .trad-logo-carousel .owl-nav button' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'carousel_logo_arrow_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
					'unit'   => 'px',
				],
                'selectors' => [
                    '{{WRAPPER}} .trad-logo-carousel .owl-nav button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'carousel_logo_arrow_shadow',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-logo-carousel .owl-nav button',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'carousel_logo_arrow_border',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-logo-carousel .owl-nav button',
            ]
        );

        $this->add_control(
            'carousel_logo_arrow_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-logo-carousel .owl-nav button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'trad_carousel_logo_icon_style',
            [
				'label' => esc_html__( 'Icon', 'turbo-addons-elementor' ),
                'separator' => 'before',
				'type'  => Controls_Manager::HEADING
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 300,
                    ],
                ],

                'default' => [
                        'size' => 30,
                        'unit' => 'px',
                    ],
                
                'selectors' => [
                    '{{WRAPPER}} .trad-logo-carousel i' => 'font-size: {{SIZE}}{{UNIT}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .trad-logo-carousel svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', // SVG icons
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-logo-carousel i' => 'color: {{VALUE}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .trad-logo-carousel svg' => 'fill: {{VALUE}};', // SVG icons
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('carousel_logo_dot_container_style', [
            'label' => esc_html__('Dot', 'turbo-addons-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control(
            'carousel_logo_dot_background_color',
            [
                'label' => esc_html__( 'Background Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#1C3389',
                'selectors' => [
                    '{{WRAPPER}} .trad-logo-carousel .owl-dot' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'carousel_logo_dot_background_active_color',
            [
                'label' => esc_html__( 'Active Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#878DA3',
                'selectors' => [
                    '{{WRAPPER}} .trad-logo-carousel .owl-dot.active' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'carousel_logo_dot_width',
            [
                'label' => esc_html__( 'Width', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'separator' => 'before',
                'size_units' => ['px', 'em', '%'],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 1920,
					],
					'em' => [
						'min' => 1,
						'max' => 10,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 10,
				],
                'selectors' => [
                    '{{WRAPPER}} .trad-logo-carousel .owl-dot' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_logo_dot_height',
            [
                'label' => esc_html__( 'Height', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 1920,
					],
					'em' => [
						'min' => 1,
						'max' => 10,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 10,
				],
                'selectors' => [
                    '{{WRAPPER}} .trad-logo-carousel .owl-dot' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'carousel_logo_dot_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
					'unit'   => 'px',
				],
                'selectors' => [
                    '{{WRAPPER}} .trad-logo-carousel .owl-dot' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'carousel_logo_dot_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '0',
					'right'  => '5',
					'bottom' => '0',
					'left'   => '0',
					'unit'   => 'px',
				],
                'selectors' => [
                    '{{WRAPPER}} .trad-logo-carousel .owl-dot' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'carousel_logo_dot_shadow',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-logo-carousel .owl-dot',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'carousel_logo_dot_border',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-logo-carousel .owl-dot',
            ]
        );

        $this->add_control(
            'carousel_logo_dot_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-logo-carousel .owl-dot' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="trad-logo-carousel">
            <div class="owl-carousel trad-logo-carousel-main">
            <?php
                if ( ! empty( $settings['logos'] ) ) :
                    foreach ( $settings['logos'] as $logo ) :
                        ?>
                        <div>
                            <?php if ( ! empty( $logo['logo_link']['url'] ) ) : ?>
                                <a 
                                    href="<?php echo esc_url( $logo['logo_link']['url'] ); ?>"
                                    <?php if ( ! empty( $logo['logo_link']['is_external'] ) ) : ?>
                                        target="_blank"
                                    <?php endif; ?>
                                    <?php if ( ! empty( $logo['logo_link']['nofollow'] ) ) : ?>
                                        rel="nofollow noopener"
                                    <?php endif; ?>
                                >
                            <?php endif; ?>

                                <img src="<?php echo esc_url( $logo['logo_image']['url'] ); ?>" alt="logo">

                            <?php if ( ! empty( $logo['logo_link']['url'] ) ) : ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach;
                endif;
            ?>
            </div>
        </div>
        <script>
            jQuery(document).ready(function($){
                $('.owl-carousel.trad-logo-carousel-main').owlCarousel({
                    loop: true,
                    margin: 15,
                    dots: true, // ✅ Enable dots
                    nav: true,  // ✅ Keep arrows if 
                    navText: [
                        `<?php \Elementor\Icons_Manager::render_icon( $settings['carousel_prev_icon'], [ 'aria-hidden' => 'true' ] ); ?>`,
                        `<?php \Elementor\Icons_Manager::render_icon( $settings['carousel_next_icon'], [ 'aria-hidden' => 'true' ] ); ?>`
                    ],
                    autoplay: <?php echo $settings['carousel_autoplay'] === 'yes' ? 'true' : 'false'; ?>,
                    autoplayTimeout: <?php echo esc_js( $settings['carousel_autoplay_timeout'] ?? 3000 ); ?>,
                    autoplaySpeed: <?php echo esc_js( $settings['carousel_autoplay_speed'] ?? 1000 ); ?>,
                    autoplayHoverPause: true,     // ✅ Pause on hover
                    responsiveClass: true,
                    responsive: {
                        0: {
                            items: <?php echo esc_js( $settings['carousel_items_mobile'] ?? 2 ); ?>,
                            slideBy: <?php echo esc_js( $settings['_elementor_settings']['carousel_slide_by_mobile'] ?? 1 ); ?>,
                            nav: <?php echo in_array( $settings['_elementor_settings']['carousel_nav_style_mobile'] ?? 'both', ['arrows', 'both'] ) ? 'true' : 'false'; ?>,
                            dots: <?php echo in_array( $settings['_elementor_settings']['carousel_nav_style_mobile'] ?? 'both', ['dots', 'both'] ) ? 'true' : 'false'; ?>
                        },
                        768: {
                            items: <?php echo esc_js( $settings['carousel_items_tablet'] ?? 3 ); ?>,
                            slideBy: <?php echo esc_js( $settings['_elementor_settings']['carousel_slide_by_tablet'] ?? 1 ); ?>,
                            nav: <?php echo in_array( $settings['_elementor_settings']['carousel_nav_style_tablet'] ?? 'both', ['arrows', 'both'] ) ? 'true' : 'false'; ?>,
                            dots: <?php echo in_array( $settings['_elementor_settings']['carousel_nav_style_tablet'] ?? 'both', ['dots', 'both'] ) ? 'true' : 'false'; ?>
                        },
                        1025: {
                            items: <?php echo esc_js( $settings['carousel_items'] ?? 4 ); ?>,
                            slideBy: <?php echo esc_js( $settings['carousel_slide_by'] ?? 1 ); ?>,
                            nav: <?php echo in_array( $settings['carousel_nav_style'] ?? 'both', ['arrows', 'both'] ) ? 'true' : 'false'; ?>,
                            dots: <?php echo in_array( $settings['carousel_nav_style'] ?? 'both', ['dots', 'both'] ) ? 'true' : 'false'; ?>
                        }
                    }
                });
            });
        </script>
        <?php
    }
    

}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Logo_Carousel() );