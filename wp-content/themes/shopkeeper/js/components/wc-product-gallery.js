jQuery(document).ready(function($) {

	/**
	 * Initialize desktop slider ( default layout )
	 *
	 */
	function product_gallery_slider() {
		if ( $(".product-images-carousel").length ) {
			/**
			 * Init slider
			 */
			var product_images = new Swiper ('.product-images-carousel', {

				autoHeight: true,
				preloadImages: true,
				updateOnImagesReady: true,
		        lazyLoading: false,
		        preventClicks : ( getbowtied_scripts_vars.product_lightbox != 1 ) ? 'true' : 'false',
		        preventClicksPropagation :  getbowtied_scripts_vars.product_lightbox != 1 ? 'true' : 'false',
		        onSlideChangeEnd : function() {
		            activate_slide(product_images.activeIndex);
		        }

			});
			var $product_thumbnails = $('.product_thumbnails');

			/**
			 * Move slider on thumbnail click
			 */
			$product_thumbnails.on('click', '.carousel-cell', function(event) {
				var index = $(event.currentTarget).index();
				activate_slide(index);
			});

			/**
			 * Link between thumbs & slider
			 */
			function activate_slide(index) {
				product_images.slideTo(index, 300, false);

				var $product_thumbnails_cells 			= $product_thumbnails.find('.carousel-cell');
				var $product_thumbnails_height 			= $product_thumbnails.height();
				var $product_thumbnails_cells_height 	= $product_thumbnails_cells.outerHeight();

				$product_thumbnails.find('.is-nav-selected').removeClass('is-nav-selected');
				
				var $selected_cell = $product_thumbnails_cells.eq(product_images.activeIndex).addClass('is-nav-selected');

				var $scrollY = (product_images.activeIndex * $product_thumbnails_cells_height) - ( ($product_thumbnails_height - $product_thumbnails_cells_height) / 2) - 10;

				$product_thumbnails.animate({
					scrollTop: $scrollY
				}, 300);	
			}

			var temp_var = $('li.carousel-cell:first-child img').attr('src');

			/**
			 * Change slide on variation change 
			 */
			$(".variations_form").on('change', 'select', function() {

				if ( $('li.carousel-cell:first-child img').attr('src') != temp_var) {
					temp_var = $('li.carousel-cell:first-child img').attr('src');
					activate_slide(0);
				}

				if ( ($(".product_layout_3").length > 0) && ($(window).width() > 960) )
				{
					$('html,body').animate({
					   scrollTop: $("#primary").offset().top
					});
				}
			});

			$('.variations_form').on('click', '.reset_variations', function() {
				activate_slide(0);
			});

		}
	}

	/**
	 *  Initialize the mobile slider & thumbnail slider
	 */
	function product_gallery_mobile() {
		/**
		 * Main slider
		 */
		var mobileGallery = new Swiper('.product_content_wrapper .mobile_gallery', {
			preloadImages: true,
			updateOnImagesReady: true,
			autoHeight: true,
	        lazyLoading: false
		});

		/**
		 * Thumbnail slider
		 */
		var mobileGalleryThumbs = new Swiper('.product_content_wrapper .mobile_gallery_thumbs', {
		    centeredSlides: true,
		    freeMode : true,
	        slidesPerView: 'auto',
	        touchRatio: 0.5,
	        slideToClickedSlide: true,
	        nested: true,
	        grabCursor: true,
	        touchMoveStopPropagation: true,
	        preventClicks: true
	    });


		/**
		 * Link the sliders
		 */
		mobileGallery.params.control = mobileGalleryThumbs;
		mobileGalleryThumbs.params.control = mobileGallery;


		/**
		 * On variation change update images & reset slider
		 */
		$(document).on('change', '.single-product .variations_form', 'select', function() {
			var product_img_desktop = $('.product_images .product-image:first-child img').attr('src');
			$('.mobile_gallery .swiper-wrapper .swiper-slide:first-child img').attr('src', product_img_desktop);
			$('.mobile_gallery_thumbs .swiper-wrapper .swiper-slide:first-child').attr('style', 'background-image: url('+ product_img_desktop + ')');
			mobileGallery.slideTo(0);
		});

		// Product Gallery Mobile Featured Img
		$(document).on('click', ".product-image.mobile > a", function(e) {
			e.preventDefault();
			$('.product-image.featured a.fresco').trigger('click');
		});
	}

	// Fix Nth-Child Layout - dettach from DOM mobile featured image
	var imageMobile = $('.product_layout_4 .product-image.mobile').detach();
	$(window).on('load resize', function() {
		if ( $(window).width() >= 1024 && $('.product_layout_4').length > 0 ) {
			$('.product_layout_4 .product-image.mobile').detach();
		} else {
			$('.product_layout_4 .product_images .featured ').after(imageMobile);
		}
	});

	$('.easyzoom').on('click', '.easyzoom-flyout', function(){
		$(this).siblings('.fresco.zoom').trigger('click');
	});


	// Product Layout Default Gallery Video Min Height
	function minHeightVideo() {

		if ( $('.product_layout_classic')  && $('.carousel-cell.youtube') ) {

			var productInfos = 	$('.product_infos');

			if ( $(window).width() > 640 && $(window).width() < 1024) {
				productInfos.css({
					'margin-top' : '50px'
				});
			} else {
				productInfos.css({
					'margin-top' : '0'
				});
			}
			
		}
	}

	$(window).on('resize', function() {
		minHeightVideo();
	});

	$(window).load(function() {
		product_gallery_slider();
		minHeightVideo();
		product_gallery_mobile();
	});
});