jQuery( document ).ready(function($) {

    // Sticky Header.
    
    var stickyOffset = $('.sticky').offset().top;

    $(window).scroll(function(){
    var sticky = $('.sticky'),
        scroll = $(window).scrollTop();
    if (scroll > stickyOffset) sticky.addClass('fixed');
    else sticky.removeClass('fixed');
    });

    // Menu.

    var liParent = $("li.menu-item-has-children");
    if(liParent) {
        liParent.append('<span class="material-icons">expand_more</span>')
    }

    $("li.menu-item-has-children > span").click(function () {
        var childUl = $(this).closest(liParent).children("ul"),
            displayUl = childUl.css('display') == 'none' ? 'block' : 'none';
            childUl.css('display', displayUl)
            $(this).toggleClass('rotate-span')
    });

    // Tab Navigation Keyboard

    var liParentLink = liParent.find('a')
    liParentLink.on( 'keypress focusin' , function() {
        let ulParent = $(this).parents('ul.active')

        $('.active').not(ulParent).removeClass('active')
        
        $(this).find('+ ul').addClass('active')
    })

    $('li.menu-item:not(li.menu-item-has-children):not(ul.sub-menu li)').on('focusin keypress', function() {
        $('.active').removeClass('active')
    })

    // Searchbar 

    $(".menu-button-container a").click(function(e) {
        e.preventDefault()
        $(".search-bar").css('display', 'none')
        $(".search-bar > div").css('height', '0');
    })

    $(".search-contents").click(function(e) {
        e.preventDefault();
        $(".search-bar").css('display', 'block')
        $(".search-bar > div").css('height', 'auto');
    })

    // Back to Top.

    $("#back-to-top").click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });

    // Mobile Menu Toggle.

    var menuToggle = $(".menu-toggle"),
        mobileMenu = $(".mobile-menu-wrapper"),
        translateMenu = function(variable) {mobileMenu.css('transform', 'translate(' + variable + '%, 0)')},
        headingContainer = $('.heading-container');
    
    if(headingContainer.height() != 0) menuToggle.css({ 'top': '8%'})

    menuToggle.click(function() {

        if($(this).hasClass('close')) {

            if($('body').hasClass('rtl')) {
                translateMenu(100)
            } else {
                translateMenu(-100)
            }

        } else {
            translateMenu(0)
        }

        $(this).toggleClass('close')
    });

    // Homepage Products Tabs.

    let tabsButtons = ['new-arrivals', 'featured-products', 'onsale-items'];

    tabsButtons.forEach(function(el) {
        $('.' + el).click(function (e) {
            e.preventDefault();
            $('#' + el).css('display', 'block');

            $.map(tabsButtons, function (element) {
                if (el != element) {
                    $('#' + element).css('display', 'none');
                }
             });
            $('.product-tabs .active').removeClass('active');
            $(this).addClass('active');
        })
    })

    // Edit Add To Cart Buttons on Homepage Loop 

    let addToCart = $('.home .add_to_cart_button')
    addToCart.text(translationStrings.viewProduct);
    addToCart.on('click', function(e) {
        
        e.preventDefault();
        
        let productLink = $('.home .product a:first-child').attr('href');

        $(this).attr('href', productLink)
        window.location.href = productLink;
    })

    // WooCommerce Add Primary Button

    window.addEventListener('load', function() {
        $('.wc-block-grid__products .wc-block-grid__product-image img').addClass('product-img');
        $('.wc-block-grid__product-link').addClass('product-link');
    });

    $('a[aria-label="Change address"]').click(function () {
        $('.wc-block-components-button:not(.is-link)').addClass('btn-primary');
    })

    // WooCommerce Pagination

    $('.woocommerce-pagination a.next').empty().prepend('<span class="material-icons-outlined">navigate_next</span>');
    $('.woocommerce-pagination a.prev').empty().prepend('<span class="material-icons-outlined">chevron_left</span>');

    // WooCommerce Add Sidbare

    var shopWidget = $('.archive.woocommerce .widget-shop').remove();
    if($(window).width() >= 768){
        $('.archive.woocommerce #primary').prepend(shopWidget);
    }

    // WooCommerce Dynamic Add To Cart Number Icon

    $(document).on('added_to_cart', function() {
        $.ajax({
            type: 'POST',
            url: dziri_ajax.ajax_url,
            data: { 
                action: 'update_cart_count' 
            },
            success: function(response) {
                $('.cart-items-number').text(response);
            }
        });
    });

    // WooCommerce Remove Payement Method for COD

    var paymentsMethods = $('.wc_payment_methods li');
    if(paymentsMethods.length == 1 && jQuery.inArray('payment_method_cod', paymentsMethods[0].classList) == 1) {
        $('.wc_payment_methods').css('display', 'none')
    }

    // WooCommerce Add Custom Quantity To COD Form
    
    $(document).on('change', '.checkout-quantity', changeCheckoutQuantity);

    function changeCheckoutQuantity(event) {
        
        _this = event.target || event;
        
        var newQuantity = $(_this)[0].value
        var cartKey     = $(_this).data('cart-key')
        
        $('.woocommerce .quantity .qty').val(newQuantity);
        console.log(dziri_ajax.ajax_url);

        $.ajax({
            url: dziri_ajax.ajax_url, 
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'update_checkout_quantity',
                cart_key: cartKey,
                quantity: newQuantity,
            },
            success: function(response) {
                if (response.success) {
                    console.log(response);
                    
                    $('body').trigger('update_checkout');
                } else {
                    console.error(response.data);
                }
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    $(document).on('click', '.material-icons[data-name="remove"]', function() {
        var checkoutQuantity    = $('.checkout-quantity');

        if(checkoutQuantity[0].value > 1) checkoutQuantity[0].value = +checkoutQuantity[0].value - 1
        changeCheckoutQuantity(checkoutQuantity[0])
        })

    $(document).on('click', '.material-icons[data-name="add"]', function() {
        var checkoutQuantity    = $('.checkout-quantity');
        
        checkoutQuantity[0].value = +checkoutQuantity[0].value + 1
        changeCheckoutQuantity(checkoutQuantity[0])
    })

    // Get Selected Variation Value For Variable Products

    
    $('form.variations_form').on('found_variation', function(event, variation) {
        
        var variation_id = variation.variation_id;
        
        $.ajax({
            url: dziri_ajax.ajax_url,
            type: 'POST',
            dataType: 'json',
            async: true,
            data: {
                action: 'add_to_cart_on_variable',
                variation_id: variation_id
            },
            success: function(response) {
                console.log(response);
                $('body').trigger('update_checkout')
            },
            error: function(error) {
                console.log(error);
            }
        })
    });

    // Remove Add To Cart For Variable Products
    
    if($('.woocommerce-checkout-form').length > 0) {
        $('.woocommerce-variation-add-to-cart').hide()
    }
});

// Swiper Slider

const swiper1 = new Swiper('#swiper-slider', {
    loop: true,
    autoplay: {
        delay: 5000,
    },
    effect: 'creative',
    creativeEffect: {
    next: {
        translate: ['100%', 0, 0],
      },
    prev: {
        translate: ['-100%', 0, 0],
      },
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    scrollbar: {
      el: '.swiper-scrollbar',
      draggable: true,
    },
});

// Swiper Carousel

const swiper2 = new Swiper('#swiper-brands', {
    slidesPerView: 2,
    spaceBetween: 5,
    breakpoints: {
        600: {
            slidesPerView: 3,
            spaceBetween: 10
        },
        768: {
            slidesPerView: 4,
            spaceBetween: 15
        },
        992: {
            slidesPerView: 5,
            spaceBetween: 20
        }
    },
    loop: true,
    autoplay: {
        delay: 200000,
    },
    keyboard: true,
    mousewheel: true,
    creativeEffect: {
    next: {
        translate: ['20%', 0, 0],
      },
    prev: {
        translate: ['-20%', 0, 0],
      },
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    pagination: {
        el: '.swiper-pagination',
        type: 'bullets',
        clickable: true,
    }
});

