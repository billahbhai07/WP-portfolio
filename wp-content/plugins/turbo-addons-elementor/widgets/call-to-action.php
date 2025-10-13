<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class TR_Call_To_Action_Widget extends Widget_Base {

    public function get_name() {
        return 'trad-call-to-action';
    }

    public function get_title() {
        return esc_html__('Call to Action', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-call-to-action trad-icon';
    }

    public function get_categories() {
        return ['turbo-addons'];
    }
    public function get_keywords() {
        return ['call to action','action','action button','button'];
    }

    public function get_style_depends() {
        return ['trad-call-to-action-style'];
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
            'trad_heading',
            [
                'label' => esc_html__('Heading', 'turbo-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('A nice attention grabbing header!', 'turbo-addons-elementor'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'trad_paragraph',
            [
                'label' => esc_html__('Paragraph', 'turbo-addons-elementor'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__('A descriptive sentence for the Call To Action (CTA).', 'turbo-addons-elementor'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'trad_button_text',
            [
                'label' => esc_html__('Button Text', 'turbo-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Contact Us Now!', 'turbo-addons-elementor'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'trad_button_url',
            [
                'label' => esc_html__('Button URL', 'turbo-addons-elementor'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'turbo-addons-elementor'),
            ]
        );

        $this->end_controls_section();

        //===================================Style section========================================
        //==========================================================================================

        // Background controller//
        $this->start_controls_section(
            'cta_box_Background_section',
            [
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        ); 
        $this->start_controls_tabs(
			'background_style_tabs'
		);
        $this->start_controls_tab(
			'style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
			]
		);
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'trad_cta_background',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .trad-wrapper-full',
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
			'style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
			]
		);
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'trad_cta_background_hover',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .trad-wrapper-full:hover',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section(); //--------------------------- end background controller
        
        $this->start_controls_section(
            'cta_box_Background_section_overlay',
            [
                'label' => esc_html__('Background Overlay', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        ); 
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'trad_cta_background_overlay',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .trad-wrapper-full::after',
            ]
        );

        $this->add_responsive_control(
			'cta_background_overlay_opacity',
			[
				'label' => esc_html__( 'Opacity', 'turbo-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => .5,
				],
				'range' => [
					'px' => [
						'max' => 1,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} > .elementor-element-populated > .trad-wrapper-full::after' => 'opacity: {{SIZE}};',
				],
			]
		);

        $this->end_controls_section(); //--------------------------- end background overlay controller



        $this->start_controls_section(
            'cta_box_style_section',
            [
                'label' => esc_html__('Box', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        ); 
        $this->add_responsive_control(
            'cta_content_alignment',
            [
                'label' => esc_html__( 'Alignment', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Top', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Bottom', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .trad-cta-wrapper' => 'align-items: {{VALUE}};',
                    '{{WRAPPER}} .trad-details-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'trad_cta_flex_direction',
            [
                'label' => esc_html__('Direction', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Row', 'turbo-addons-elementor'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'row-reverse' => [
                        'title' => esc_html__('Row Reverse', 'turbo-addons-elementor'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'column' => [
                        'title' => esc_html__('Column', 'turbo-addons-elementor'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'column-reverse' => [
                        'title' => esc_html__('Column Reverse', 'turbo-addons-elementor'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'row', // Default flex direction
                'selectors' => [
                    '{{WRAPPER}} .trad-cta-wrapper' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'trad_cta_padding',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default' => [
                    'top' => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '10',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-wrapper-full' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

          // Button border style controller
          $this->add_control(
            'trad_cta_border_style',
            [
                'label' => esc_html__('Border Style', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'solid' => esc_html__('Solid', 'turbo-addons-elementor'),
                    'dashed' => esc_html__('Dashed', 'turbo-addons-elementor'),
                    'dotted' => esc_html__('Dotted', 'turbo-addons-elementor'),
                    'double' => esc_html__('Double', 'turbo-addons-elementor'),
                    'groove' => esc_html__('Groove', 'turbo-addons-elementor'),
                    'ridge' => esc_html__('Ridge', 'turbo-addons-elementor'),
                    'inset' => esc_html__('Inset', 'turbo-addons-elementor'),
                    'outset' => esc_html__('Outset', 'turbo-addons-elementor'),
                    'none' => esc_html__('None', 'turbo-addons-elementor'),
                ],
                'default' => 'solid',
                'selectors' => [
                    '{{WRAPPER}} .trad-wrapper-full' => 'border-style: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'trad_cta_border',
            [
                'label' => esc_html__('Border Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#D1D1D1',
                'selectors' => [
                    '{{WRAPPER}} .trad-wrapper-full' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        // Button border controller
        $this->add_control(
            'trad_cta_border_width',
            [
                'label' => esc_html__('Border Width', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '1',
                    'right' => '1',
                    'bottom' => '1',
                    'left' => '1',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-wrapper-full' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Button border radius controller
        $this->add_control(
            'trad_cta_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '5',
                    'right' => '5',
                    'bottom' => '5',
                    'left' => '5',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-wrapper-full' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}}; border-bottom-left-radius: {{BOTTOM}}{{UNIT}}; border-bottom-right-radius: {{LEFT}}{{UNIT}};',
                ],
                
            ]
        );
       
        $this->end_controls_section();

        // --------------content section-------------------
        $this->start_controls_section(
            'cta_content_section',
            [
                'label' => esc_html__('Content', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Heading controller
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cta_title_typography',
				'label' => __('Title Typography', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-details-wrapper h2',
			]
		);

        $this->add_control(
            'trad_cta_heading_color',
            [
                'label' => esc_html__('Title Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-details-wrapper h2' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Paragraph controller
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cta_paragraph_typography',
				'label' => __('Paragraph Typography', 'turbo-addons-elementor'),
				'selector' => '{{WRAPPER}} .trad-cta-description',
			]
		);
        $this->add_control(
            'cta_trad_paragraph_color',
            [
                'label' => esc_html__('Paragraph Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-cta-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();



        $this->start_controls_section(
            'button_section',
            [
                'label' => esc_html__('Button', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Button background color controller
        $this->add_control(
            'trad_button_bg_color',
            [
                'label' => esc_html__('Background Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-blue-cta-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Button text color controller
        $this->add_control(
            'trad_button_text_color',
            [
                'label' => esc_html__('Text Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#3686BE',
                'selectors' => [
                    '{{WRAPPER}} .trad-blue-cta-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Button hover background color controller
        $this->add_control(
            'trad_button_hover_bg_color',
            [
                'label' => esc_html__('Hover Background Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-blue-cta-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Button hover text color controller
        $this->add_control(
            'trad_button_hover_text_color',
            [
                'label' => esc_html__('Hover Text Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-blue-cta-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'trad_button_border_color',
            [
                'label' => esc_html__('Border Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .trad-blue-cta-button' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        // Button border controller
        $this->add_control(
            'trad_button_border',
            [
                'label' => esc_html__('Border Width', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .trad-blue-cta-button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '2',
                    'right' => '2',
                    'bottom' => '2',
                    'left' => '2',
                    'unit' => 'px',
                ],
            ]
        );

        // Button border style controller
        $this->add_control(
            'trad_button_border_style',
            [
                'label' => esc_html__('Border Style', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'solid' => esc_html__('Solid', 'turbo-addons-elementor'),
                    'dashed' => esc_html__('Dashed', 'turbo-addons-elementor'),
                    'dotted' => esc_html__('Dotted', 'turbo-addons-elementor'),
                    'double' => esc_html__('Double', 'turbo-addons-elementor'),
                    'groove' => esc_html__('Groove', 'turbo-addons-elementor'),
                    'ridge' => esc_html__('Ridge', 'turbo-addons-elementor'),
                    'inset' => esc_html__('Inset', 'turbo-addons-elementor'),
                    'outset' => esc_html__('Outset', 'turbo-addons-elementor'),
                    'none' => esc_html__('None', 'turbo-addons-elementor'),
                ],
                'default' => 'solid',
                'selectors' => [
                    '{{WRAPPER}} .trad-blue-cta-button' => 'border-style: {{VALUE}};'
                ],
            ]
        );

        // Button border radius controller
        $this->add_control(
            'trad_button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .trad-blue-cta-button' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}}; border-bottom-left-radius: {{BOTTOM}}{{UNIT}}; border-bottom-right-radius: {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '5',
                    'right' => '5',
                    'bottom' => '5',
                    'left' => '5',
                    'unit' => 'px',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        
        <div class="trad-wrapper-full">
            <div class="trad-cta-wrapper">
                <div class="trad-details-wrapper">
                    <h2>
                        <?php echo esc_html($settings['trad_heading']); ?>
                    </h2>
                    <span class="trad-cta-description">
                        <?php echo wp_kses_post($settings['trad_paragraph']); ?>
                    </span>
                </div>
                <a class="trad-blue-cta-button" href="<?php echo esc_url($settings['trad_button_url']['url']); ?>">
                    <?php echo esc_html($settings['trad_button_text']); ?>
                </a>
            </div>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new TR_Call_To_Action_Widget() );
