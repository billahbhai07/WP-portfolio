<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Class TRAD_Team_Slider
 *
 * Elementor widget for displaying team members in a slider.
 *
 * @since 1.0.0
 */
class TRAD_Team_Slider extends Widget_Base {

    public function get_name() {
        return 'trad-team-slider';
    }

    public function get_title() {
        return esc_html__('Team Slider', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-slides trad-icon'; // Use appropriate Elementor icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
    }

    public function get_style_depends() {
        return ['trad-team-slider-style', 'trad-owl-carousel-style', 'owl-carousel-theme' ];
    }

    public function get_script_depends() {
        return [ 'trad-team-slider-script', 'trad-owl-carousel-script' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'team_slider_responsive_settings',
            [
                'label' => esc_html__('Responsive Settings', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'team_slider_responsive_items',
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
            'team_slider_content',
            [
                'label' => esc_html__('Team Member', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'team_member_image', 
            [
                'label' => esc_html__('Upload Image', 'turbo-addons-elementor'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => trad_get_placeholder_image(),
                ],
            ]
        );
        $repeater->add_control(
            'team_member_name',
            [
                'label' => esc_html__('Name', 'turbo-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('John Doe', 'turbo-addons-elementor'),
                'placeholder' => esc_html__('Enter Team Member Name', 'turbo-addons-elementor'),
            ]
        );

        $repeater->add_control(
            'team_member_designation',
            [
                'label' => esc_html__('Designation', 'turbo-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Web Developer', 'turbo-addons-elementor'),
                'placeholder' => esc_html__('Enter Team Member Designation', 'turbo-addons-elementor'),
            ]
        );

        $repeater->add_control(
            'team_member_other_info',
            [
                'label' => esc_html__('More Information', 'turbo-addons-elementor'),
                'type' => Controls_Manager::WYSIWYG,
                'label_block' => true,
                'default' => esc_html__('admin@gmail.com', 'turbo-addons-elementor'),
                'placeholder' => esc_html__('Enter Team Member Other Information', 'turbo-addons-elementor'),
            ]
        );

        $repeater->add_control(
			'team_member_facebook_link',
			[
				'label'       => __( 'Facebook URL', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
				'default'     => [
					'url'         => '#',
					'is_external' => 'true'
				],
				'dynamic'     => [
					'active'  => true
				],
				'placeholder' => __( 'https://your-link.com', 'turbo-addons-elementor' ),
			]
		);

        $repeater->add_control(
			'team_member_twiter_link',
			[
				'label'       => __( 'Twiter URL', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
				'default'     => [
					'url'         => '#',
					'is_external' => 'true'
				],
				'dynamic'     => [
					'active'  => true
				],
				'placeholder' => __( 'https://your-link.com', 'turbo-addons-elementor' ),
			]
		);

        $repeater->add_control(
			'team_member_linkedin_link',
			[
				'label'       => __( 'Linkedin URL', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
				'default'     => [
					'url'         => '#',
					'is_external' => 'true'
				],
				'dynamic'     => [
					'active'  => true
				],
				'placeholder' => __( 'https://your-link.com', 'turbo-addons-elementor' ),
			]
		);

        $repeater->add_control(
			'team_member_instagram_link',
			[
				'label'       => __( 'Instagram URL', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
				'default'     => [
					'url'         => '#',
					'is_external' => 'true'
				],
				'dynamic'     => [
					'active'  => true
				],
				'placeholder' => __( 'https://your-link.com', 'turbo-addons-elementor' ),
			]
		);

        $repeater->add_control(
			'team_member_additional_link',
			[
				'label'       => __( 'Additional URL', 'turbo-addons-elementor' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
				'default'     => [
					'url'         => '#',
					'is_external' => 'true'
				],
				'dynamic'     => [
					'active'  => true
				],
				'placeholder' => __( 'https://your-link.com', 'turbo-addons-elementor' ),
                'description' => esc_html__( "To remove the icon, simply remove the '#'.", 'turbo-addons-elementor' ),
			]
		);

        $this->add_control(
            'team_member_items',
            [
                'label'       => esc_html__('Team Members', 'turbo-addons-elementor'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'team_member_image' => ['url' => trad_get_placeholder_image()],
                        'team_member_name' => esc_html__('John Doe', 'turbo-addons-elementor'),
                        'team_member_designation' => esc_html__('Web Developer', 'turbo-addons-elementor'),
                        'team_member_other_info' => esc_html__('admin@gmail.com', 'turbo-addons-elementor'),
                        'team_member_facebook_link' => ['url' => 'https://facebook.com/johndoe'],
                        'team_member_twiter_link' => ['url' => 'https://twitter.com/johndoe'],
                        'team_member_linkedin_link' => ['url' => 'https://linkedin.com/in/johndoe'],
                        'team_member_instagram_link' => ['url' => 'https://instagram.com/johndoe'],
                        'team_member_additional_link' => ['url' => '#'],
                    ],
                    [
                        'team_member_image' => ['url' => trad_get_placeholder_image()],
                        'team_member_name' => esc_html__('Jane Smith', 'turbo-addons-elementor'),
                        'team_member_designation' => esc_html__('Graphic Designer', 'turbo-addons-elementor'),
                        'team_member_other_info' => esc_html__('jane@example.com', 'turbo-addons-elementor'),
                        'team_member_facebook_link' => ['url' => 'https://facebook.com/janesmith'],
                        'team_member_twiter_link' => ['url' => 'https://twitter.com/janesmith'],
                        'team_member_linkedin_link' => ['url' => 'https://linkedin.com/in/janesmith'],
                        'team_member_instagram_link' => ['url' => 'https://instagram.com/janesmith'],
                        'team_member_additional_link' => ['url' => '#'],
                    ],
                    [
                        'team_member_image' => ['url' => trad_get_placeholder_image()],
                        'team_member_name' => esc_html__('David Brown', 'turbo-addons-elementor'),
                        'team_member_designation' => esc_html__('Project Manager', 'turbo-addons-elementor'),
                        'team_member_other_info' => esc_html__('david@example.com', 'turbo-addons-elementor'),
                        'team_member_facebook_link' => ['url' => 'https://facebook.com/davidbrown'],
                        'team_member_twiter_link' => ['url' => 'https://twitter.com/davidbrown'],
                        'team_member_linkedin_link' => ['url' => 'https://linkedin.com/in/davidbrown'],
                        'team_member_instagram_link' => ['url' => 'https://instagram.com/davidbrown'],
                        'team_member_additional_link' => ['url' => '#'],
                    ],
                ],
                'title_field' => '{{ team_member_name }}',
            ]
        );
        
        $this->end_controls_section();
        $this->start_controls_section(
            'team_slider_box_section',
            [
                'label' => esc_html__('Box', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'team_slider_box_bg',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .trad-team-slider-wrapper-main',
            ]
        );
        $this->add_control(
            'team_slider_overlay_bg_color',
            [
                'label' => esc_html__('Overlay Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-overlay' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'team_slider_box_border',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-wrapper-main',
            ]
        );

        $this->add_responsive_control(
            'team_slider_box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-wrapper-main' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'team_slider_box_shadow',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-wrapper-main',
            ]
        );

        $this->add_responsive_control(
            'team_slider_box_margin',
            [
                'label' => esc_html__('Margin', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-wrapper-main' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'team_slider_box_padding',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-wrapper-main' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 

        // Width Control
        $this->add_responsive_control(
            'trad_team_slider_width',
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
                    '{{WRAPPER}} .trad-team-slider-wrapper-main' => 'width: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        // Height Control
        $this->add_responsive_control(
            'trad_team_slider_height',
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
                    '{{WRAPPER}} .trad-team-slider-wrapper-main' => 'height: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'team_slider_image_section',
            [
                'label' => esc_html__('Image', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // Image Width Control
        $this->add_responsive_control(
            'team_slider_image_width',
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
                    '{{WRAPPER}} .trad-team-slider-wrapper-main .trad-team-slider-image' => 'width: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        // Image Height Control
        $this->add_responsive_control(
            'team_slider_image_height',
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
                    '{{WRAPPER}} .trad-team-slider-wrapper-main .trad-team-slider-image' => 'height: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        // Group Border Control
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'team_slider_image_border',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-wrapper-main .trad-team-slider-image',
            ]
        );

        // Border Radius Control
        $this->add_responsive_control(
            'team_slider_image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-wrapper-main .trad-team-slider-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Group Box Shadow Control
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'team_slider_image_box_shadow',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-wrapper-main .trad-team-slider-image',
            ]
        );

        $this->end_controls_section();
        // Add Typhography
        $this->start_controls_section(
            'team_slider_typhography_section',
            [
                'label' => esc_html__('Content', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'team_slider_typhography_name',
                'label' => esc_html__('Name Typography', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-name',
            ]
        );

        $this->add_control(
            'trad_team_slider_name_color',
            [
                'label' => esc_html__( 'Name Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Padding control for .trad-team-slider-name
        $this->add_responsive_control(
            'trad_team_slider_name_padding',
            [
                'label' => esc_html__( 'Name Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Margin control for .trad-team-slider-name
        $this->add_responsive_control(
            'trad_team_slider_name_margin',
            [
                'label' => esc_html__( 'Name Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
			'trad_designation_before_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'team_slider_typhography_designation',
                'label' => esc_html__('Designation Typography', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-text',
            ]
        );
        $this->add_control(
            'trad_team_slider_designation_color',
            [
                'label' => esc_html__( 'Designation Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Padding control for .trad-team-slider-name
        $this->add_responsive_control(
            'trad_team_slider_designation_padding',
            [
                'label' => esc_html__( 'Designation Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Margin control for .trad-team-slider-name
        $this->add_responsive_control(
            'trad_team_slider_designation_margin',
            [
                'label' => esc_html__( 'Designation Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
			'trad_designation_after_hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'team_slider_typhography_more_info',
                'label' => esc_html__('More Information Typography', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-overlay p',
            ]
        );

        $this->add_control(
            'trad_team_slider_more_info_color',
            [
                'label' => esc_html__( 'More Information Color', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-overlay p' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Padding control for .trad-team-slider-name
        $this->add_responsive_control(
            'trad_team_slider_more_info_padding',
            [
                'label' => esc_html__( 'More Information Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-overlay p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Margin control for .trad-team-slider-name
        $this->add_responsive_control(
            'trad_team_slider_more_info_margin',
            [
                'label' => esc_html__( 'More Information Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-overlay p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        
        $this->end_controls_section();

        $this->start_controls_section(
            'team_slider_alignment_section',
            [
                'label' => esc_html__('Alignment', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'team_slider_overlay_alignment',
            [
                'label' => esc_html__( 'Overlay Alignment', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-overlay' => 'align-items: {{VALUE}};',
                ],
            ]
        );
        

        $this->end_controls_section();
        // Add Icon
        $this->start_controls_section(
            'team_slider_social_icon_section',
            [
                'label' => esc_html__('Icon', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs( 'trad_team_slider_social_icon_style_tab' );
        //  Controls tab For Normal
        $this->start_controls_tab(
            'trad_team_slider_social_icon_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'turbo-addons-elementor' ),
            ]
        );
        // Font size control for .trad-team-slider-social-link
        $this->add_responsive_control(
            'team_slider_social_link_font_size',
            [
                'label' => esc_html__( 'Size', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'unit' => 'px',
                    'size' => 18,
                ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                    'em' => [
                        'min' => 0.5,
                        'max' => 3,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-social-link' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        //Social Icons Background
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'team_slider_icons_bg',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .trad-team-slider-social-link',
            ]
        );
        //Social Icons Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'team_slider_icons_border',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-social-link',
            ]
        );
        //Social Icons Border Radius
        $this->add_responsive_control(
            'team_slider_icons_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-social-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        //Social Icons Box Shadow
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'team_slider_icons_box_shadow',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-social-link',
            ]
        );
        // Gap control for social icons
        $this->add_responsive_control(
            'team_slider_social_icons_gap',
            [
                'label' => esc_html__( 'Gap', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 3,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-social-icons' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'label_block' => true,
            ]
        );

        // Margin control for social icons
        $this->add_responsive_control(
            'team_slider_social_icons_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-social-icons' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'label_block' => true,
            ]
        );

        //Padding control for social icons
        $this->add_responsive_control(
            'team_slider_social_icons_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-social-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'label_block' => true,
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'trad_team_slider_social_icon_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'turbo-addons-elementor' ),
            ]
        );
        //Social Icons Background
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'team_slider_icons_hover_bg',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .trad-team-slider-social-link:hover',
            ]
        );
        //Social Icons Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'team_slider_icons_hover_border',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-social-link:hover',
            ]
        );
        //Social Icons Border Radius
        $this->add_responsive_control(
            'team_slider_icons_border_hover_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-social-link:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        //Social Icons Box Shadow
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'team_slider_icons_hover_box_shadow',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-social-link:hover',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        // Add Arrow
        $this->start_controls_section(
            'team_slider_nav_arrow_section',
            [
                'label' => esc_html__('Arrow', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'team_slider_nav_bg',
                'label' => esc_html__('Background', 'turbo-addons-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .trad-team-slider-wrapper-main .owl-nav button',
            ]
        );

        $this->add_control(
            'team_slider_nav_icon_color',
            [
                'label' => esc_html__('Nav Icon Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-wrapper-main .owl-nav button svg' => 'fill: {{VALUE}};', // Apply the color to the SVG icons
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'team_slider_nav_button_border',
                'label' => esc_html__('Border', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-wrapper-main .owl-nav button',
            ]
        );

        $this->add_responsive_control(
            'team_slider_nav_button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'turbo-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-team-slider-wrapper-main .owl-nav button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'team_slider_nav_button_box_shadow',
                'label' => esc_html__('Box Shadow', 'turbo-addons-elementor'),
                'selector' => '{{WRAPPER}} .trad-team-slider-wrapper-main .owl-nav button',
            ]
        );
        

        $this->add_responsive_control(
            'team_slider_nav_icon_size',
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
                    '{{WRAPPER}} .trad-team-slider-wrapper-main .owl-nav button svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'team_slider_nav_icon_top',
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
                    '{{WRAPPER}} .trad-team-slider-wrapper-main .owl-nav button svg' => 'top: {{SIZE}}{{UNIT}}; position: relative;',
                ],
            ]
        );

        
        $this->add_responsive_control(
            'team_slider_nav_top_position',
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
                    '{{WRAPPER}} .trad-team-slider-wrapper-main .owl-nav button' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        ); 

        $this->add_control(
            'team_slider_nav_display',
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

        // Add Dots
        $this->start_controls_section(
            'team_slider_nav_dot_section',
            [
                'label' => esc_html__('Dots', 'turbo-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'team_slider_dots_top',
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
            'team_slider_dots_left',
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
            'team_slider_dots_background_color',
            [
                'label' => esc_html__('Dots Background Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-dots button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'team_slider_active_dots_background_color',
            [
                'label' => esc_html__('Active Dots Background Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-dots button.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'team_slider_dots_display',
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
        $team_responsive = [];
        if (!empty($settings['team_slider_responsive_items'])) {
            foreach ($settings['team_slider_responsive_items'] as $item) {
                $team_responsive[$item['breakpoint']] = $item['items'];
            }
        }
        if (empty($settings['team_member_items'])) return;
       ?>
        <div class="trad-team-slider-wrapper-main">
            <div class="trad-team-slider owl-carousel">
                <?php foreach ($settings['team_member_items'] as $member) : ?>
                    <div class="trad-team-slider-member">
                    <?php // phpcs:ignore PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage -- fallback for default images without attachment ID ?>
                        <img class="trad-team-slider-image" src="<?php echo esc_url($member['team_member_image']['url']); ?>" alt="<?php echo esc_attr(sanitize_text_field($member['team_member_name'])); ?>">
                        <div class="trad-team-slider-overlay">
                            <h3 class="trad-team-slider-name"><?php echo esc_html(sanitize_text_field($member['team_member_name'])); ?></h3>
                            <h4 class="trad-team-slider-text"><?php echo esc_html(sanitize_text_field($member['team_member_designation'])); ?></h4>
                            <p class="trad-team-slider-text-description"><?php echo wp_kses_post($member['team_member_other_info']); ?></p>
                            <div class="trad-team-slider-social-icons">
                                <?php if (!empty($member['team_member_facebook_link']['url'])) : ?>
                                    <a class="trad-team-slider-social-link" href="<?php echo esc_url($member['team_member_facebook_link']['url']); ?>" target="_blank" rel="noopener" ><i class="fab fa-facebook"></i></a>
                                <?php endif; ?>
                                <?php if (!empty($member['team_member_twiter_link']['url'])) : ?>
                                    <a class="trad-team-slider-social-link" href="<?php echo esc_url($member['team_member_twiter_link']['url']); ?>" target="_blank" rel="noopener" ><i class="fab fa-twitter"></i></a>
                                <?php endif; ?>
                                <?php  if (!empty($member['team_member_linkedin_link']['url'])) : ?>
                                    <a class="trad-team-slider-social-link" href="<?php echo esc_url($member['team_member_linkedin_link']['url']); ?>" target="_blank" rel="noopener" ><i class="fab fa-linkedin"></i></a>
                                <?php endif; ?>
                                <?php if (!empty($member['team_member_instagram_link']['url'])) : ?>
                                    <a class="trad-team-slider-social-link" href="<?php echo esc_url($member['team_member_instagram_link']['url']); ?>" target="_blank" rel="noopener" ><i class="fab fa-instagram"></i></a>
                                <?php endif; ?>
                                <?php if (!empty($member['team_member_additional_link']['url'])) : ?>
                                    <a class="trad-team-slider-social-link" href="<?php echo esc_url($member['team_member_additional_link']['url']); ?>" target="_blank" rel="noopener" ><i class="fas fa-info-circle"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <script>
        jQuery(document).ready(function(){
            jQuery(".trad-team-slider").owlCarousel({
                loop: true,
                margin: 20,
                autoplay: true,
                autoplayTimeout: 3000,
                nav: <?php echo esc_js($settings['team_slider_nav_display'] === 'yes' ? 'true' : 'false'); ?>,
                dots: <?php echo esc_js($settings['team_slider_dots_display'] === 'yes' ? 'true' : 'false'); ?>,
                navText: [
                                '<svg width="50" height="50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/></svg>',
                                '<svg width="50" height="50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>'],
                responsive: {
                    <?php
                        foreach ($team_responsive as $breakpoint => $items) {
                            $clean_breakpoint = preg_replace('/[^a-zA-Z0-9_-]/', '', $breakpoint);
                            $clean_items = intval($items);
                            if ($clean_breakpoint !== '') {
                                echo "'" . esc_js($clean_breakpoint) . "': { items: " . esc_js($clean_items) . " },";
                            }
                        }
                    ?>
                }
            });
        });
        </script>

       <?php
    }
}

// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new TRAD_Team_Slider() );
