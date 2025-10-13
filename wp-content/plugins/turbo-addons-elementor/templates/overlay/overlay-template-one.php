<div class="trad-image-overlay-template-one-container <?php echo esc_attr( $settings['trad_overlay_animation_effect'] ); ?>">  
    <div class="trad-image-overlay-template-one-text">

    <?php if ( 'yes' === $settings['show_overlay_title'] ) : ?>
        <h4 class="trad-image-overlay-template-one-text-title <?php echo esc_attr( $dynamic_class_default_title ); ?>">
            <?php echo esc_html( sanitize_text_field( $settings['trad_overlay_image_title'] ) ); ?>
        </h4>
    <?php endif; ?>

    <?php if ( 'yes' === $settings['show_overlay_text'] ) : ?>
        <p class="trad-image-overlay-text-area <?php echo esc_attr( $dynamic_class_default_paragraph ); ?>">
            <?php echo esc_html( sanitize_text_field( $settings['trad_overlay_image_text_area'] ) ); ?>
        </p>
    <?php endif; ?>

    <?php if ( 'yes' === $settings['show_overlay_icons'] && ! empty( $settings['icon_list'] ) ) : ?>
        <div class="trad-image-overlay-template-one-social-icons <?php echo esc_attr( $dynamic_class_default_icons ); ?>">
            <?php foreach ( $settings['icon_list'] as $index => $item ) :
                $repeater_setting_key = $this->get_repeater_setting_key( 'icon', 'icon_list', $index );
                $icon_color_style = ! empty( $item['icon_color'] ) ? 'fill: ' . esc_attr( $item['icon_color'] ) . ';' : '';
            ?>
                <div class="elementor-icon trad-social-icon">
                    <?php if ( ! empty( $item['icon']['value'] ) ) :
                        $icon_link = $item['icon_link']['url'] ?? '';
                        $icon_target = $item['icon_link']['is_external'] ? ' target="_blank"' : '';
                        $icon_nofollow = $item['icon_link']['nofollow'] ? ' rel="nofollow"' : '';
                    ?>
                        <a href="<?php echo esc_url( $icon_link ); ?>"<?php echo esc_attr($icon_target) . esc_attr($icon_nofollow); ?>>
                            <?php
                            \Elementor\Icons_Manager::render_icon(
                                $item['icon'],
                                [
                                    'aria-hidden'   => 'true',
                                    'style'         => $icon_color_style,
                                    'data-setting'  => $repeater_setting_key,
                                ]
                            );
                            ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ( 'yes' === $settings['show_overlay_button'] ) : 
    $button_url    = ! empty( $settings['trad_overlay_image_button_link']['url'] ) ? esc_url( $settings['trad_overlay_image_button_link']['url'] ) : '#';
    $button_target = $settings['trad_overlay_image_button_link']['is_external'] ? ' target="_blank"' : '';
    $button_rel    = $settings['trad_overlay_image_button_link']['nofollow'] ? ' rel="nofollow"' : '';
    ?>
        <a class="trad-image-overlay-template-two-text-link <?php echo esc_attr( $dynamic_class_default_button ); ?>"
        href="<?php echo esc_url( $button_url) ; ?>"<?php echo esc_attr( $button_target ) . esc_attr($button_rel); ?>>
            <?php echo esc_html( sanitize_text_field( $settings['trad_overlay_image_button_text'] ) ); ?>
        </a>
    <?php endif; ?>
</div>

</div>

