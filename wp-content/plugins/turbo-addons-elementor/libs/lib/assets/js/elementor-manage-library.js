(function ($) {
	"use strict";

    var TRAD_TURBO_LIB;

    TRAD_TURBO_LIB = {

        init: function () {

            window.elementor.on(
                'document:loaded',
                window._.bind(TRAD_TURBO_LIB.onPreviewLoaded, TRAD_TURBO_LIB)
            );
        },

        onPreviewLoaded: function () {

            var main_wrap = $('#elementor-preview-iframe').contents();
            var wrapper_html = "<div style='display:none;' class='trad-lib-wrap'>"
                                    +"<div class='trad-lib-inner'>"
                                        +"<div class='trad-lib-header'>"
                                            +"<div class='trad-lib-lhead'>"
                                                +"<h2 class='trad-lib-logo'>Library</h2>"
                                                +"<h2 class='trad-lib-back-to-home'>Back to template</h2>"
                                            +"</div>"
                                            +"<div class='trad-lib-centerhead'>"
                                                +"<ul>"
                                                   +"<li data-type='page' class='active'>Page</li>"
                                                   +"<li data-type='section'>Section</li>"
                                                   + /*"<li data-type='header-footer'>Header footer</li>"
                                                   +"<li data-type='theme-builder'>Theme builder</li>"
                                                   +*/"<li data-type='element'>Elements</li>"
                                                +"<ul>"
                                            +"</div>"                                            
                                            +"<div class='trad-lib-rhead'>"
                                                +"<i class='eicon-sync'></i>"
                                                +"<i class='trad-lib-close eicon-close'></i>"
                                            +"</div>"                                            
                                        +"</div>"
                                        +"<div class='trad-lib-inner'>"
                                            +"<div class='trad-lib-search-input'>"
                                                +"<input class='trad-lib-xl-search' type='text' placeholder='Find Your Best Match'>"
                                            +"</div>"
                                            +"<div class='trad-lib-content'>"
                                            +"</div>"
                                        +"</div>"
                                    +"</div>"
                                    +"<div data-type='element' class='trad-lib-xl-settings'></div>"
                                +"</div>";

            
                                main_wrap.find('.elementor-add-template-button').after("<div class='elementor-add-section-area-button trad-turbo-add-button trad-turbobtn' style='margin-left:5px; margin-right:5px;'></div>");

            $('#elementor-editor-wrapper').append(wrapper_html);
            $('#elementor-editor-wrapper').append('<div class="trad-turbo-lib-preview"><div>');
            main_wrap.find('.trad-turbo-add-button').click(function(){

                $('#elementor-editor-wrapper').find('.trad-lib-wrap').show();
                var ajax_data = {
                    page : '1',
                    category:'',
                    type : 'page',
                };
                process_data(ajax_data);

            });

            $(document).on('click', '.insert-tmpl', function(e) {

                var tmpl_id = $(this).data('id');
                // console.log('tmpl_id', tmpl_id);
                var parent_site = $(this).data('parentsite');
                // console.log('parent_site', parent_site);

                $('.trad-lib-content').addClass('loading');
                $.ajax({
                    type: 'POST',
                    url: ajaxurl, 
                    data: {
                      action: 'trad_turbo_addon_import_template',
                      nonce: trad_turbo_lib_params.nonce,
                      id: tmpl_id,
                      parent_site: parent_site,
                    },
                    success: function(data, textStatus, XMLHttpRequest) {
                        // console.log('data', data);
                        var xl_data = JSON.parse(data); 
                        elementor.getPreviewView().addChildModel(xl_data, {silent: 0});
                        $('.trad-lib-content').removeClass('loading');
                        $('#elementor-editor-wrapper').find('.trad-lib-wrap').hide();

                        //Added Reset =================================
                        // Reset tab selection and set "Page" as active
                        $('.trad-lib-centerhead li').removeClass('active');
                        $('.trad-lib-centerhead li[data-type="page"]').addClass('active');

                        // Clear any stored content to force reload
                        $('.trad-lib-content').html('');

                    },
                    error: function (jqXHR, exception) {
                        // console.log(exception);
                    }, 

                  });
            });

            $(document).on('click', '.trad-lib-rhead .eicon-sync', function(e) {
                $('.trad-lib-content').addClass('loading');
                $('.trad-lib-xl-search').val('');
                var type = $('.trad-lib-centerhead li.active').data('type') || 'page';
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                      action: 'trad_turbo_addon_xl_tab_reload_template',
                    },
                    success: function(data, textStatus, XMLHttpRequest) {
                        $('.xl-loader').hide();
                        var ajax_data = {
                            page : '1',
                            category:'',
                            type : type,
                        };
                        process_data(ajax_data);                        
                    },
                  });
            });

            $(document).on('click', '.lib-img-wrap', function(e) {
                var live_link = $(this).data('preview');
                var win = window.open( live_link, '_blank');
                if (win) {
                    //Browser has allowed it to be opened
                    win.focus();
                } 
                //Browser has blocked it
                // else {
                //     alert('Please allow popups for this website');
                // }
            });

            $(document).on('click', '.trad-turbo-lib-preview .close', function(e) {
            
                $('.trad-turbo-lib-preview .inner').html('');
                $('.trad-turbo-lib-preview').removeClass('loading');
                $('.trad-lib-back-to-home').hide();
                $('.trad-lib-content').show();
                $('.trad-lib-logo').show();

            });

            $(document).on('click', '.page-link', function(e) {
                $('.trad-lib-content').addClass('loading');
                var page_no = $(this).data('page-number');
                var category = $('#elementor-editor-wrapper').find('.trad-lib-xl-settings').attr('data-catsettings');
                // var type = $('#elementor-editor-wrapper').find('.trad-lib-xl-settings').attr('data-type');
                var type = $('.trad-lib-centerhead li.active').data('type') || 'page';
                var search = $('#elementor-editor-wrapper').find('.trad-lib-xl-settings').attr('data-search');
                $('#elementor-editor-wrapper').find('.trad-lib-xl-settings').attr('data-pagesettings', page_no);
                var ajax_data = {
                    page: page_no,
                    category: category,
                    type : type,
                    search : search,
                };
                process_data(ajax_data);
            });

            $(document).on('click', '.filter-wrap a', function(e) {
                var category = $(this).data('cat');
                $('#elementor-editor-wrapper').find('.trad-lib-xl-settings').attr('data-catsettings', category);
                $('.trad-lib-content').addClass('loading');
                var ajax_data = {
                    page : '1',
                    category:category,
                };
                process_data(ajax_data);
            });

            $(document).on('keyup', '.trad-lib-xl-search', function(e) {
                var search = $(this).val();
                $('#elementor-editor-wrapper').find('.trad-lib-xl-settings').attr('data-search', search);
                // var type = $('#elementor-editor-wrapper').find('.trad-lib-xl-settings').attr('data-type');
                var type = $('.trad-lib-centerhead li.active').data('type') || 'page';
                $('.trad-lib-content').addClass('loading');
                var ajax_data = {
                    page : '1',
                    type : type,
                    search : search,
                };
                process_data(ajax_data);
            });

            // Top type filter
            $(document).on('click', '.trad-lib-centerhead li', function(e) {
                var type = $(this).data('type');
                $(this).addClass("active").siblings().removeClass("active");
                $('#elementor-editor-wrapper').find('.trad-lib-xl-settings').attr('data-type', type);
                $('.trad-lib-content').addClass('loading');
                $('.trad-lib-xl-search').val('');
                $('#elementor-editor-wrapper').find('.trad-lib-xl-settings').attr('data-search','');
                var ajax_data = {
                    page : '1',
                    category:'',
                    type : type,
                };
                process_data(ajax_data);
            });

            function process_data($data){

                  $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                      action: 'trad_turbo_addon_process_ajax',
                      data : $data,
                      nonce: trad_turbo_lib_nonce_verify.nonce,
                    },

                    success: function(data, textStatus, XMLHttpRequest) {

                        $('.trad-lib-content').removeClass('loading');
                        $('.trad-lib-content').html(data);

                        $('.item-wrap').masonry({
                            itemSelector: '.item',
                            isAnimated: false,
                            transitionDuration: 0
                        });

                        $('.item-wrap').masonry('reloadItems');
                        $('.item-wrap').masonry('layout');

                        $('.item-wrap').imagesLoaded( function() {
                        $('.item-wrap').masonry('layout');
                        });
                    },

                  });
            }

            $('#elementor-editor-wrapper').find('.trad-lib-close').click(function(){
                $('#elementor-editor-wrapper').find('.trad-lib-wrap').hide();
                $('.live-preview').html('');
                $('.trad-lib-content').show();
                $('.trad-lib-back-to-home').hide();

                //Added Reset =================================
                // Reset tab selection and set "Page" as active
                $('.trad-lib-centerhead li').removeClass('active');
                $('.trad-lib-centerhead li[data-type="page"]').addClass('active');

                // Clear any stored content to force reload
                $('.trad-lib-content').html('');
            });
        },

    };

    $(window).on('elementor:init', TRAD_TURBO_LIB.init);

}(jQuery));	

//})(jQuery);