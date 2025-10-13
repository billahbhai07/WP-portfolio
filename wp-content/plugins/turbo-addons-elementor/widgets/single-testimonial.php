<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Plugin;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Trad_Single_Testimonial extends Widget_Base {
    public function get_name() {
        return 'trad-single-testimonial';
    }

    public function get_title() {
        return esc_html__('Single Testimonial', 'turbo-addons-elementor');
    }

    public function get_icon() {
        return 'eicon-testimonial trad-icon'; // Choose an appropriate icon
    }

    public function get_categories() {
        return ['turbo-addons']; // Change to your desired category
    }

    public function get_style_depends() {
        return ['trad-single-testimonial-style'];
    }
    
    protected function register_controls() {
        // ----------------------------------------  Testimonial Grid Content ------------------------------
        $this->start_controls_section(
            'trad_single_testimonial',
            [
                'label' => esc_html__( 'Testimonial', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'trad_single_testimonial_style', [
                'label' => esc_html__( 'Select Layout', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'style-1' => esc_html__( 'Style 1', 'turbo-addons-elementor' ),
                    'style-2' => esc_html__( 'Style 2', 'turbo-addons-elementor' )
                ],
                'default' => 'style-1',
            ]
        );
        $this->add_control(
            'testimonial_name', [
                'label' => esc_html__( 'Name', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( 'Mr. John' , 'turbo-addons-elementor' ),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'testimonial_designation', [
                'label' => esc_html__( 'Designation', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( 'CEO,' , 'turbo-addons-elementor' ),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'testimonial_location', [
                'label' => esc_html__( 'Location', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( 'California, USA' , 'turbo-addons-elementor' ),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'testimonial_rating', [
                'label' => esc_html__( 'Rating', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__( '1', 'turbo-addons-elementor' ),
                    '2' => esc_html__( '2', 'turbo-addons-elementor' ),
                    '3' => esc_html__( '3', 'turbo-addons-elementor' ),
                    '4' => esc_html__( '4', 'turbo-addons-elementor' ),
                    '5' => esc_html__( '5', 'turbo-addons-elementor' ),
                    'none' => esc_html__( 'None', 'turbo-addons-elementor' )
                ],
                'default' => 4
            ]
        );
        $this->add_control(
            'testimonial_desc', [
                'label' => esc_html__( 'Review Comment', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( 'Powerful, versatile, feature-rich Elementor widget addon.' , 'turbo-addons-elementor' ),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'testimonial_img', [
                'label' => esc_html__( 'Picture', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => trad_get_placeholder_image(),
                ],
            ]
        );
        $this->end_controls_section(); // End Testimonial Content

        $this->start_controls_section(
            'trad_single_testimonial_show_hide',
            [
                'label' => esc_html__( 'Show / Hide', 'turbo-addons-elementor' ),
            ]
        );
        $this->add_control(
            'author_location_visibility',
            [
                'label' => __('Author Location', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'turbo-addons-elementor'),
                'label_off' => __('Hide', 'turbo-addons-elementor'),
                'return_value' => 'block', // Value for "Show"
                'default' => 'block', // Default set to block
            ]
        );
        $this->add_control(
            'author_rating_visibility',
            [
                'label' => __('Rating', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'turbo-addons-elementor'),
                'label_off' => __('Hide', 'turbo-addons-elementor'),
                'return_value' => 'block', // Value for "Show"
                'default' => 'block', // Default set to block
            ]
        );
        $this->end_controls_section();

        /**
         * Style Tab
         * ------------------------------ Testimonial  Content Area Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'trad_content_style_section', [
                'label' => esc_html__( 'Box', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'content_wrapper_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial-slider' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_wrapper_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial-slider' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        // Border Control (Group Control)
        $this->add_group_control(
            Group_Control_Border::get_type(),
                [
                    'name' => 'content_wrapper_border',
                    'label' => esc_html__('Border', 'turbo-addons-elementor'),
                    'selector' => '{{WRAPPER}} .trad-single-testimonial-slider',
                ]
        );
        $this->add_responsive_control(
            'content_wrapper_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'default'=>[
                    'top' =>'10',
                    'left' =>'10',
                    'right' =>'10',
                    'bottom' =>'10',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial-slider' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_wrapper_shadow',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-single-testimonial-slider',
            ]
        ); 
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'content_wrapper_background',
                'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .trad-single-testimonial-slider',
            ]
        );
        $this->end_controls_section();

        /**
         * Style Tab
         * ------------------------------ Testimonial layout Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'trad_single_testimonial_layout', [
                'label' => esc_html__( 'Item Style', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'author_info_alignment',
            [
                'label' => esc_html__( 'Author Info Position', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'top' => [
                        'title' => esc_html__( 'Top', 'turbo-addons-elementor' ),
                        'icon' => 'fas fa-angle-up',
                    ],
                    'bottom' => [
                        'title' => esc_html__( 'Bottom', 'turbo-addons-elementor' ),
                        'icon' => 'fas fa-angle-down',
                    ]
                ],
                'default' => 'top',
                'toggle' => true
            ]
        );

            $this->add_control(
                'thumbnail_alignment',
                [
                    'label' => esc_html__( 'Thumbnail Position', 'turbo-addons-elementor' ),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'top' => [
                            'title' => esc_html__( 'Top', 'turbo-addons-elementor' ),
                            'icon' => 'fas fa-angle-up',
                        ],
                        'bottom' => [
                            'title' => esc_html__( 'Bottom', 'turbo-addons-elementor' ),
                            'icon' => 'fas fa-angle-down',
                        ]
                    ],
                    'default' => 'top',
                    'toggle' => true
                ]
            );

            $this->add_control(
                'rating_alignment',
                [
                    'label' => esc_html__( 'Rating Position', 'turbo-addons-elementor' ),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'top' => [
                            'title' => esc_html__( 'Top', 'turbo-addons-elementor' ),
                            'icon' => 'fas fa-angle-up',
                        ],
                        'bottom' => [
                            'title' => esc_html__( 'Bottom', 'turbo-addons-elementor' ),
                            'icon' => 'fas fa-angle-down',
                        ]
                    ],
                    'default' => 'top',
                    'toggle' => true,
                    'condition' => [
                        'author_rating_visibility' => 'block', // Show only if 'author_location_visibility' is 'block'
                    ],
                ]
            );

            $this->add_responsive_control(
                'layout_content_text_alignment',
                [
                    'label' => esc_html__( 'Alignment', 'turbo-addons-elementor' ),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'default' => 'center',
                    'toggle' => true,
                    'selectors' => [
                        '{{WRAPPER}} .trad-single-testimonial' => 'text-align: {{VALUE}} !important',
                    ],
                    'condition' => ['trad_single_testimonial_style' => 'style-1' ]
                ]
            );

            $this->add_control(
                'trad_portfolio_justify_content',
                [
                    'label' => __('Image Alignment', 'turbo-addons-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => [
                        'flex-start' => __('Left', 'turbo-addons-elementor'),
                        'center' => __('Center', 'turbo-addons-elementor'),
                        'flex-end' => __('Right', 'turbo-addons-elementor'),
                        'space-between' => __('Space Between', 'turbo-addons-elementor'),
                        'space-around' => __('Space Around', 'turbo-addons-elementor'),
                        'space-evenly' => __('Space Evenly', 'turbo-addons-elementor'),
                    ],
                    'default' => 'center',
                    'selectors' => [
                        '{{WRAPPER}} .trad-single-testimonial .trad-author-meta-wrap' => 'display: flex; justify-content: {{VALUE}}; align-items: center;',
                    ],
                    'condition' => ['trad_single_testimonial_style' => 'style-2' ]
                ]
            );
            
            $this->add_responsive_control(
                'layout_area_margin',
                [
                    'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-single-testimonial' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'layout_area_padding',
                [
                    'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-single-testimonial' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'single_testimonial_border',
                    'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
                    'selector' => '{{WRAPPER}} .trad-single-testimonial',
                ]
            );
            $this->add_responsive_control(
                'layout_area_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-single-testimonial' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ],
                ]
            );
            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'layout_area_shadow',
                    'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                    'selector' => '{{WRAPPER}} .trad-single-testimonial',
                ]
            ); 
            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'layout_area_background',
                    'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .trad-single-testimonial',
                ]
            );

        $this->end_controls_section();

        /**
         * Style Tab
         * ------------------------------ Testimonial Name Style Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'trad_single_testimonial_title_style', [
                'label' => esc_html__( 'Name', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
             
        $this->add_control(
            'name_color',
            [
                'label' => esc_html__( 'Title Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial .trad-author-name' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-single-testimonial .trad-author-name',
            ]
        );
        $this->add_responsive_control(
            'name_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial .trad-author-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'name_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial .trad-author-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab
         * ------------------------------ Testimonial Designation Style Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'trad_single_testimonial_designation_style', [
                'label' => esc_html__( 'Designation', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
           
        $this->add_control(
            'designation_color',
            [
                'label' => esc_html__( 'Title Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial .trad-author-designation' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'designation_typography',
                'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-single-testimonial .trad-author-designation',
            ]
        );
        $this->add_responsive_control(
            'designation_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial .trad-author-designation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'designation_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial .trad-author-designation' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 


        $this->end_controls_section();

        /**
         * Style Tab
         * ------------------------------ Testimonial Location Style Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'trad_single_testimonial_location_style', [
                'label' => esc_html__( 'Location', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
             
        $this->add_control(
            'location_color',
            [
                'label' => esc_html__( 'Title Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial .trad-author-location' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'location_typography',
                'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-single-testimonial .trad-author-location',
            ]
        );
        $this->add_responsive_control(
            'location_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial .trad-author-location' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'location_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial .trad-author-location' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab
         * ------------------------------ Testimonial Descriptions Style Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'trad_single_testimonial_description_style', [
                'label' => esc_html__( 'Descriptions', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'descriptions_color',
            [
                'label' => esc_html__( 'Title Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial .trad-testimonial-text p' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'descriptions_typography',
                'label' => esc_html__( 'Typography', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-single-testimonial .trad-testimonial-text p',
            ]
        );
        $this->add_responsive_control(
            'descriptions_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial .trad-testimonial-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'descriptions_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-single-testimonial .trad-testimonial-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'descriptions_border',
                    'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
                    'selector' => '{{WRAPPER}} .trad-single-testimonial .trad-testimonial-text',
                ]
            );
            $this->add_responsive_control(
                'descriptions_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .trad-single-testimonial .trad-testimonial-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ],
                ]
            );
            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'descriptions_shadow',
                    'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                    'selector' => '{{WRAPPER}} .trad-single-testimonial .trad-testimonial-text',
                ]
            ); 
            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'descriptions_background',
                    'label' => esc_html__( 'Background', 'turbo-addons-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .trad-single-testimonial .trad-testimonial-text',
                ]
            );

        $this->end_controls_section();


        /**
         * Style Tab
         * ------------------------------ Testimonial Rating Style Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'trad_single_testimonial_rating_style', [
                'label' => esc_html__( 'Rating', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'rating_justify_content',
            [
                'label' => __('Rating Alignment', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'flex-start' => __('Left', 'turbo-addons-elementor'),
                    'center' => __('Center', 'turbo-addons-elementor'),
                    'flex-end' => __('Right', 'turbo-addons-elementor'),
                    'space-between' => __('Space Between', 'turbo-addons-elementor'),
                    'space-around' => __('Space Around', 'turbo-addons-elementor'),
                    'space-evenly' => __('Space Evenly', 'turbo-addons-elementor'),
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-rating' => 'display: flex; justify-content: {{VALUE}}; align-items: center;',
                ],
            ]
        );
        $this->add_control(
            'rating_color',
            [
                'label' => esc_html__('Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#E4B500',
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-rating .elementor-icon i' => 'color: {{VALUE}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .trad-testimonial-rating .elementor-icon svg' => 'fill: {{VALUE}};', // SVG icons
                ],
               
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 18,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-rating .elementor-icon i' => 'font-size: {{SIZE}}{{UNIT}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .trad-testimonial-rating .elementor-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', // SVG icons
                ],
            ]
        );
        $this->add_responsive_control(
            'rating_margin',
            [
                'label' => esc_html__( 'Icon Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-icon svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'rating_block_margin',
            [
                'label' => esc_html__( 'Icon Block Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'rating_block_padding',
            [
                'label' => esc_html__( 'Icon Block Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-rating' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab
         * ------------------------------ Testimonial Quote Style Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'trad_single_testimonial_quote_style', [
                'label' => esc_html__( 'Quote', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'trad_quote_justify_content',
            [
                'label' => esc_html__( 'Alignment', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'turbo-addons-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-text' => 'text-align: {{VALUE}} !important',
                ],
                'condition' => ['trad_single_testimonial_style' => 'style-2' ]
            ]
        );
        $this->add_control(
            'left_quote_icon',
            [
                'label' => esc_html__( 'Left Quote Icon', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-quote-left',
                    'library' => 'solid',
                ],
            ]
        );
        $this->add_control(
            'right_quote_icon',
            [
                'label' => esc_html__( 'Right Quote Icon', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-quote-right',
                    'library' => 'solid',
                ],
            ]
        );
        $this->add_control(
            'quote_color',
            [
                'label' => esc_html__('Quote Color', 'turbo-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-text .elementor-icon i' => 'color: {{VALUE}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .trad-testimonial-text .elementor-icon svg' => 'fill: {{VALUE}};', // SVG icons
                ],
            ]
        );
        $this->add_control(
            'quote_icon_size',
            [
                'label' => esc_html__('Icon Size', 'turbo-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-text .elementor-icon i' => 'font-size: {{SIZE}}{{UNIT}};', // Font Awesome or other font-based icons
                    '{{WRAPPER}} .trad-testimonial-text .elementor-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', // SVG icons
                ],
            ]
        );
        $this->add_control(
            'quote_bg_color',
            [
                'label' => esc_html__( 'Quote Background Color', 'turbo-addons-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-text' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'quote_left_space',
            [
                'label' => esc_html__( 'Quote Left Space', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '15',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-text .trad-testimonial-left-quote' => 'margin-right: {{SIZE}}{{UNIT}};'
                ],
            ]
        );
        $this->add_responsive_control(
            'quote_right_space',
            [
                'label' => esc_html__( 'Quote Right Space', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '15',
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-text .trad-testimonial-right-quote' => 'margin-left: {{SIZE}}{{UNIT}};'
                ],
            ]
        );
        $this->add_responsive_control(
            'testimonial_qoute_icon_margin',
            [
                'label' => esc_html__('Margin', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-text .elementor-icon i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .trad-testimonial-text .elementor-icon svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'testimonial_quote_icon_padding',
            [
                'label' => esc_html__('Padding', 'turbo-addons-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-text .elementor-icon i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .trad-testimonial-text .elementor-icon svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab
         * ------------------------------ Testimonial Image Style Settings ------------------------------
         *
         */
        $this->start_controls_section(
            'trad_single_testimonial_image_style', [
                'label' => esc_html__( 'Image', 'turbo-addons-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'img_width',
            [
                'label' => esc_html__( 'Width', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 80,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-thumb img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'img_height',
            [
                'label' => esc_html__( 'Height', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 80,
                ],
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-thumb img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'img_margin',
            [
                'label' => esc_html__( 'Margin', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-thumb img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'img_padding',
            [
                'label' => esc_html__( 'Padding', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-thumb img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'img_border',
                'label' => esc_html__( 'Border', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-testimonial-thumb img',
            ]
        );
        $this->add_responsive_control(
            'img_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'turbo-addons-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .trad-testimonial-thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'img_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'turbo-addons-elementor' ),
                'selector' => '{{WRAPPER}} .trad-testimonial-thumb img',
            ]
        );
        $this->end_controls_section();


    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $selected_template_for_testimonial = isset( $settings['trad_single_testimonial_style'] ) ? $settings['trad_single_testimonial_style'] : 'style-1';
        if ( 'style-1' === $selected_template_for_testimonial ) {
            include plugin_dir_path( __FILE__ ) . '../templates/single-testimonial/style-1.php';
        } elseif ( 'style-2' === $selected_template_for_testimonial ) {
            include plugin_dir_path( __FILE__ ) . '../templates/single-testimonial/style-2.php';
        }
    }
    
}
// Register the widget with Elementor.
Plugin::instance()->widgets_manager->register_widget_type( new Trad_Single_Testimonial() );