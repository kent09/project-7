(function($) {
    $(document).on('ready', function() {
        $('.product-feature-image').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            adaptiveHeight: true,
            arrows: false,
            fade: true,
            asNavFor: '.side-thumbnail'
        });

        $('.side-thumbnail').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.product-feature-image',
            vertical: true,
            dots: true,
            focusOnSelect: true
        });

        //plugin bootstrap minus and plus
        //http://jsfiddle.net/laelitenetwork/puJ6G/
        $('.btn-number').click(function(e) {
            e.preventDefault();
            fieldName = $(this).attr('data-field');
            type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                if (type == 'minus') {
                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }
                } else if (type == 'plus') {
                    input.val(currentVal + 1).change();
                }
            } else {
                input.val(0);
            }
        });

        $('.input-number').focusin(function() {
            $(this).data('oldValue', $(this).val());
        });

        $('.input-number').change(function() {

            valueCurrent = parseInt($(this).val());

            name = $(this).attr('name');
            if (valueCurrent >= 0) {
                $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                // alert('Sorry, the minimum value was reached');
                (this).val($(this).data('oldValue'));
            }

        });

        $(".input-number").keydown(function(e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
		
		    $('#pickUpModal #gform_submit_button_3').click(function() {

                var products = [];
                $.each($("form.composite_form > .composite_component option:selected"), function(){            
                    products.push($(this).text());
                });
                $('#pickUpModal input[name=input_9]').val(products.join(", "));
                
                var $quote = $('form.composite_form .fit_quote input[name=_delivery]').val();

                if ($quote == 'quote') {
                    $('#pickUpModal input[name=input_15]').val('Fitting Quote');
                } else {
                    $('#pickUpModal input[name=input_15]').val('Pick Up');
                }
            });
		
		$('#left-sidebar .woof_container_product_cat h4').text("ACCESSORIES");

        function radioCheck($element) {
            if($element.is(':checked')) {
                $element.parent().parent().find('#inlineRadio2').attr('disabled', true);
            } else {
                $element.parent().parent().find('#inlineRadio2').attr('disabled', false);
            }
        }

        function cartButtonText() {
            $('input[type=radio][name=_delivery]').click(function() {
                $value = $("input[type=radio][name=_delivery]:checked").val();
                inputDelivery($value);
            });

        }
        //$('.cart > button').text('GET A QUOTE');

        if ( $('[name="_delivery"]').val() == 'delivery' ) {
          $('.quantity-holder').show();
          $('.single_add_to_cart_button').removeAttr('style');
        } else {
          $('.quantity-holder').hide();
          $('.single_add_to_cart_button').attr('style','margin-left:0;');
        }

        if ($('.composite_add_to_cart_button').length > 0 ) {
          $('.composite_add_to_cart_button').addClass('open-modal');
        }

        function inputDelivery(el) {
            if (el == 'delivery' ) {
                $('.cart .single_add_to_cart_button').text('ADD TO CART');
                $('.cart .single_add_to_cart_button').removeClass('open-modal');
                $('.quantity-holder').show();
                $('.single_add_to_cart_button').removeAttr('style');
            } else {
                $('.cart .single_add_to_cart_button').text('GET A QUOTE');
                $('.cart .single_add_to_cart_button').addClass('open-modal');
                $('.quantity-holder').hide();
                $('.single_add_to_cart_button').attr('style','margin-left:0;');
            }
        }

        function menuParent() {
            $('#main-menu li a').each(function() {
                $(this).click(function(){
                    if($(this).attr("href") != "#") {
                        location.href =  $(this).attr('href');
                    }
                });
            });
        }

        function menuMobile() {
            $('#main-menu li a').each(function() {
                $(this).click(function(e) {
                    e.preventDefault();

                    $this = $(this);
                    $anchor = $this.parent().find('.dropdown-menu').first();

                    if($anchor.length) {
                        if($anchor.is(":visible")) {
                            if($this.attr('href') != '#') {
                                location.href =  $this.attr('href');
                            } 
                            $this.parent().find('.dropdown-menu').slideUp(function() {
                                $('#main-menu li').removeClass("show");
                            });
                        } else {
                            $this.parent().children('.dropdown-menu').slideDown(function() {
                                $this.parent().addClass("show");
                            });
                        }
                    } else {
                        location.href =  $this.attr('href');
                    }
                });
            });
        }

        function menuHover() {
            $('#main-menu > .menu-item-has-children > ul > .menu-item-object-make_model').mouseenter(function() {
                $(this).parent().addClass('adwidth');
            });
            $('#main-menu > li > ul').mouseleave(function() {
                $(this).removeClass('adwidth');
            });
        }
        $one = 0;
        function homeMoveTop(){
            $('#main-menu .menu-item-home').prependTo($("#main-menu"));
        }
        function homeReturnBack() {
            $('#main-menu > li:nth-last-child(3)').after($('#main-menu .menu-item-home'));
        }

       

        function hideFilterTitle() {
            if($('.widget_price_filter > form').length < 1){
                $('.widget_price_filter > h4').remove();
                $('.woof_price_search_container').css({ 'padding-bottom' : '5px', 'margin-bottom' : '9px'});
                if($(window).width() < 768 ) {
                    $('.woof_price_search_container').hide();
                }
            }
        }

        function categoryCheckbox() {
            $('.widget-woof > h3').click(function() {
                let $class = $('.woof_container_make_model');
                checkboxToggle($(this), $class);
            });
            $('.widget_product_categories > h3').click(function() {
                let $class = $('.widget_product_categories > .product-categories');
                checkboxToggle($(this), $class);
            });
            $('.widget_wp_oz_widget > h3').click(function() {
                let $class = $('.widget_wp_oz_widget > .product-categories');
                checkboxToggle($(this), $class);
            });
			
			$('#left-sidebar .woof_container_product_cat h4').click(function() {
                let $class = $('#left-sidebar .woof_container_product_cat .woof_block_html_items');
                checkboxToggle($(this), $class);
            });
        }

        function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
        }

        function checkboxToggle($this, $class) {
            if($(window).width() < 768) {
                $this.toggleClass('collapsed');
                $class.slideToggle();
            }
        }

        // product similar title height
        function productSimilarHeight() {
            $(window).bind('load resize', function() {    
                let maxheight = 0, $list = $('ul.products > li');
                if($(window).width() > 576 ) {
                    $list.each(function() {
                        total = $(this).innerHeight();
                        if( maxheight < total) {
                            maxheight = total;
                        }
                    });
                    $list.height(maxheight);
                } else {
                    $list.height('auto');
                }
            });
        }

        function clearFilterTransfer() {
            $('.woof_redraw_zone > .filter-link').insertAfter($(".woof_container_inner_makesmodels .woof_block_html_items"));
        }

        var product_category = getUrlParameter('product_category');
        if(product_category) {
            let $class
            $('#left-sidebar .product-categories li').each(function(){
                $class = $(this).attr('class');
                if($class.includes(product_category)) {
                    $(this).addClass('current-cat');
                    return;
                }
            });
        }
        
        $('.single-product form.cart .single_add_to_cart_button').on('click', function(){
            if($(this).hasClass('open-modal')){
                event.preventDefault();

                // if ( $('[name="_delivery"]:checked').val() == 'pickup') {
                if ( !$('[name="_delivery"]:checked').val() != 'delivery') {
                    var addOns = '';

                    $('input[class="bundled_product_checkbox"]:checked').each(function(index, el) {
                        var parent = $(this).parent().parent();
                        var t = parent.find('.item_title').text();
                        var p = parent.find('.price').text();
                        addOns += t+' '+p+', ';
                    });

                    $('#gform_3').find('[name="input_9"]').val(addOns);

                    $('#pickUpModal').modal('show');

                // } else if( $('[name="_delivery"]:checked').val() == 'quote') {
                //     $('#fittingModal').modal('show');
                // } else {
                //     $('#contactModal').modal('show');
                }
            }
        });


        $(window).resize(function() {
            if($(window).width() > 768) {
                $('.widget_product_categories > .product-categories').show();
                $('.widget_wp_oz_widget > .product-categories').show();
                $('.woof_container_make_model').show();
                $('.widget_product_categories > h3').removeClass('collapsed');
                $('.widget_wp_oz_widget > h3').removeClass('collapsed');
                $('.widget-woof > h3').removeClass('collapsed');
            } else {
                $('.widget_product_categories > .product-categories').hide();
                $('.widget_wp_oz_widget > .product-categories').hide();
                $('.woof_container_make_model').hide();
            }
        });

        $(window).load(function() {
            $('#zip-tagline .text').text('Own it now. Pay Later');
            $('#zip-tagline .learn-more').text('Learn more >>');
            
        });

        $('#inputQuote').click(function() {
            radioCheck($(this));
        });

         function screenWidth() {
            if($(window).width() > 991) { 
                menuHover();
                menuParent();
            } else {
                menuMobile();
                homeMoveTop();
            }
            
            
        }

        $(window).resize(function() {
            if($(window).width() < 991) {
                if($one == 0) {
                   homeMoveTop();
                   $one = 1;
                }
            } else {
                if($one == 1) {
                    homeReturnBack();
                    $one = 0;
                }
            }
        });

        $(document).mouseup(function(e) {
            let container = $("#main-menu");
            let modal = $('#quick-quote-modal');

            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) 
            {
                $('#main-menu .dropdown-menu').slideUp(function() {
                    $(this).parent().removeClass("show");
                });
            }

            if (!modal.is(e.target) && modal.has(e.target).length === 0) {
                modal.find('#qq-popup-close').trigger('click');
            }

        });


        // category filter checkbox select all child checkbox
        $('.woof_list_checkbox input[type="checkbox"]').each(function() {
            $child = $(this).parent().children('ul').find('input[type="checkbox"]');
            $ul = $(this).parent().children('ul');
            
            if($(this).is(':checked')) {
                if($child.length) {
                    $ul.show();
                }
            }
        });

        // paypal button 
        // var html = '<div class="paypal-btn">';
        //     html += '<img src="/wp-content/themes/understrap-child-master/images/paypal-logo.png">';
        //     html += '</div>';
        // $('#woo_pp_ec_button_cart').append(html);

        
        $('.navbar-toggler').click(function(){
            $(this).toggleClass('open');
        });

        if ( $('.component_options_select').length > 0) {
          $('.component_options_select').each(function(index, value){
            const placeholder = default_placeholder[index];
            const first_opt = $(this).find('option:first-child');
            const default_text = first_opt.text();
            first_opt.text('').text(placeholder);
          });


        }

        radioCheck($('#inputQuote'));
        
        productSimilarHeight();

        clearFilterTransfer();
        
        categoryCheckbox();

        cartButtonText();

        screenWidth();

        hideFilterTitle();

    });
})(jQuery);


'use strict';


/* global jQuery, PhotoSwipe, PhotoSwipeUI_Default, console */

(function($) {

  // Init empty gallery array
  var container = [];

  // Loop over gallery items and push it to the array
  $('.feature-default-desktop .woocommerce-product-gallery__wrapper a').each(function() {
    var $link = $(this).find('img'),
      item = {
        src: $link.data('src'),
        w: $link.data('large_image_width'),
        h: $link.data('large_image_height')
      };
    container.push(item);
  });

  // Define click event on gallery item
  $('.feature-default-desktop .woocommerce-product-gallery__image').on('click', function(event) {

    // Prevent location change
    event.preventDefault();

    // Define object and gallery options
    var $pswp = $('.pswp')[0],
      options = {
        index: $(this).parent('.item').index(),
        bgOpacity: 0.85,
        showHideOpacity: true
      };

    // Initialize PhotoSwipe
    var gallery = new PhotoSwipe($pswp, PhotoSwipeUI_Default, container, options);
    gallery.init();
  });

}(jQuery));