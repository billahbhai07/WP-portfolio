<div class="trad-single-testimonial-slider">
    <div class="trad-single-testimonial text-center trad-testimonial-style--default">
        <?php
        // Author Info (Top)
        if ($settings['author_info_alignment'] === 'top') {
            echo '<div class="trad-author-meta-wrap">';
            
            // Thumbnail (Top)
            if (!empty($settings['testimonial_img']) && $settings['thumbnail_alignment'] === 'top') {
                $img = $settings['testimonial_img'];
                if (!empty($img['url'])) {
                    $altText = \Elementor\Control_Media::get_image_alt($img);
                    echo '<div class="trad-author-meta-thumb">';
                        echo '<div class="trad-testimonial-thumb">';
                            echo '<img src="' . esc_url($img['url']) . '" alt="' . esc_attr($altText) . '">';
                        echo '</div>';
                    echo '</div>';
                }
            }

            // Author Info (Name, Designation, Location)
            echo '<div class="trad-author-meta-info">';
            
            // Author Name
            if (!empty($settings['testimonial_name'])) {
                echo '<p class="trad-author-name">' . esc_html($settings['testimonial_name']) . '</p>';
            }

            // Author Designation
            if (!empty($settings['testimonial_designation'])) {
                echo '<p class="trad-author-designation">' . esc_html($settings['testimonial_designation']) . '</p>';
            }

            // Author Location
            if(!empty($settings['author_location_visibility'])) {
                if (!empty($settings['testimonial_location'])) {
                    echo '<span class="trad-author-location">' . esc_html($settings['testimonial_location']) . '</span>';
                }
            }

            echo '</div>'; // Close .trad-author-meta-info
            echo '</div>'; // Close .trad-author-meta-wrap
        }

        // Rating (Top)
        if (!empty($settings['author_rating_visibility'])) {
            if (!empty($settings['testimonial_rating']) && $settings['rating_alignment'] === 'top') {
                echo '<div class="trad-testimonial-rating">';
                echo '<div class="elementor-icon">';
                
                $rating = $settings['testimonial_rating'];
                $j = 0;
        
                for ($i = 0; $i <= 4; $i++) {
                    $j++;
        
                    echo '<span class="trad-testimonial-star">';
                    ob_start();
        
                    if ($rating === 'none') {
                        \Elementor\Icons_Manager::render_icon(
                            ['value' => 'far fa-star', 'library' => 'fa-regular'],
                            ['aria-hidden' => 'true']
                        );
                    } elseif ($rating >= $j || $rating == '5') {
                        \Elementor\Icons_Manager::render_icon(
                            ['value' => 'fas fa-star', 'library' => 'fa-solid'],
                            ['aria-hidden' => 'true']
                        );
                    } elseif ($rating < $j && $rating > $i) {
                        \Elementor\Icons_Manager::render_icon(
                            ['value' => 'fas fa-star-half-alt', 'library' => 'fa-solid'],
                            ['aria-hidden' => 'true']
                        );
                    } else {
                        \Elementor\Icons_Manager::render_icon(
                            ['value' => 'far fa-star', 'library' => 'fa-regular'],
                            ['aria-hidden' => 'true']
                        );
                    }
        
                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- safe icon output from Elementor
                    echo ob_get_clean();
        
                    echo '</span>';
                }
        
                echo '</div>';
                echo '</div>';
            }
        }
        

        // Testimonial Text
        // Testimonial Description
        if (!empty($settings['testimonial_desc'])) {
            $leftQuote = '';
            if (!empty($settings['left_quote_icon'])) {
                ob_start();
                \Elementor\Icons_Manager::render_icon($settings['left_quote_icon'], ['aria-hidden' => 'true']);
                $leftQuote = '<span class="trad-testimonial-left-quote">' . ob_get_clean() . '</span>';
            }

            $rightQuote = '';
            if (!empty($settings['right_quote_icon'])) {
                ob_start();
                \Elementor\Icons_Manager::render_icon($settings['right_quote_icon'], ['aria-hidden' => 'true']);
                $rightQuote = '<span class="trad-testimonial-right-quote">' . ob_get_clean() . '</span>';
            }

            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $leftQuote and $rightQuote are safe
            echo '<div class="trad-testimonial-text"><p class="elementor-icon">' . $leftQuote . wp_kses_post($settings['testimonial_desc']) . $rightQuote . '</p></div>';
        }
        ?>

        <div class="trad-testimonial-author">
            <?php
            // Author Info (Bottom)
            if ($settings['author_info_alignment'] === 'bottom') {
                echo '<div class="trad-author-meta-wrap">';
                // Thumbnail (Bottom)
                if (!empty($settings['testimonial_img']) && $settings['thumbnail_alignment'] === 'bottom') {
                    $img = $settings['testimonial_img'];
                    if (!empty($img['url'])) {
                        $altText = \Elementor\Control_Media::get_image_alt($img);
                        echo '<div class="trad-author-meta-thumb">';
                            echo '<div class="trad-testimonial-thumb">';
                                echo '<img src="' . esc_url($img['url']) . '" alt="' . esc_attr($altText) . '">';
                            echo '</div>';
                        echo '</div>';
                    }
                }

                // Author Info (Name, Designation, Location)
                echo '<div class="trad-author-meta-info">';
                
                // Author Name
                if (!empty($settings['testimonial_name'])) {
                    echo '<p class="trad-author-name">' . esc_html($settings['testimonial_name']) . '</p>';
                }

                // Author Designation
                if (!empty($settings['testimonial_designation'])) {
                    echo '<p class="trad-author-designation">' . esc_html($settings['testimonial_designation']) . '</p>';
                }

                // Author Location
                if(!empty($settings['author_location_visibility'])) {
                    if (!empty($settings['testimonial_location'])) {
                        echo '<span class="trad-author-location">' . esc_html($settings['testimonial_location']) . '</span>';
                    }
                }

                echo '</div>'; // Close .trad-author-meta-info
                echo '</div>'; // Close .trad-author-meta-wrap
            }

            // Rating (Bottom)
            if (!empty($settings['author_rating_visibility'])) {
                if (!empty($settings['testimonial_rating']) && $settings['rating_alignment'] === 'bottom') {
                    echo '<div class="trad-testimonial-rating elementor-icon">';
                    echo '<div class="elementor-icon">';
            
                    $rating = $settings['testimonial_rating'];
                    $j = 0;
            
                    for ($i = 0; $i <= 4; $i++) {
                        $j++;
            
                        echo '<span class="trad-testimonial-star">';
                        ob_start();
            
                        if ($rating === 'none') {
                            \Elementor\Icons_Manager::render_icon(
                                ['value' => 'far fa-star', 'library' => 'fa-regular'],
                                ['aria-hidden' => 'true']
                            );
                        } elseif ($rating >= $j || $rating == '5') {
                            \Elementor\Icons_Manager::render_icon(
                                ['value' => 'fas fa-star', 'library' => 'fa-solid'],
                                ['aria-hidden' => 'true']
                            );
                        } elseif ($rating < $j && $rating > $i) {
                            \Elementor\Icons_Manager::render_icon(
                                ['value' => 'fas fa-star-half-alt', 'library' => 'fa-solid'],
                                ['aria-hidden' => 'true']
                            );
                        } else {
                            \Elementor\Icons_Manager::render_icon(
                                ['value' => 'far fa-star', 'library' => 'fa-regular'],
                                ['aria-hidden' => 'true']
                            );
                        }
            
                        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- safe Elementor icon HTML
                        echo ob_get_clean();
            
                        echo '</span>';
                    }
            
                    echo '</div>';
                    echo '</div>';
                }
            }
            
            ?>
        </div>
    </div>
</div>
