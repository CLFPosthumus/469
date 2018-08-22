jQuery(document).ready(function($){

	//==============================================================================
	//	Minicart events
	//==============================================================================

	if (getbowtied_scripts_vars.option_minicart == 1) {
		/* toggle minicart*/
		$('body:not(.woocommerce-account)').on('click', '.shopping-bag-button .tools_button, .product_notification_wrapper', function(e) {

			$('.product_notification_wrapper').parent().hide();
			
			if ( $(window).width() >= 1024 ) {

				e.preventDefault();
				$('.shopkeeper-mini-cart').toggleClass('open');
				e.stopPropagation();	
				
			} else {

				e.stopPropagation();	
			}

		});

		if( $('body').hasClass('gbt_custom_notif') ) {
			$('body').on('click', '.woocommerce-error', function(e) {
				$('.woocommerce-error').hide();
			});

			$('body').on('click', '.woocommerce-info', function(e) {
				$('.woocommerce-info').hide();
			});

			$('body').on('click', '.woocommerce-message', function(e) {
				$('.woocommerce-message').hide();
			});
		}

		/* close minicart */
		$('body').on('click', function(event){
			if( $('.shopkeeper-mini-cart').hasClass('open') ) 
			{
				if (!$(event.target).is('.shopkeeper-mini-cart') && !$(event.target).is('.shopping-bags-button .tools-button') && !$(event.target).is('.woocommerce-message')
					&& ( $('.shopkeeper-mini-cart').has(event.target).length === 0) )
				{
					$('.shopkeeper-mini-cart').removeClass('open');
				}
			}
		});
	}

	//=====================================================================
	//	Build dynamic add to cart message
	//=====================================================================
	var notificationContent = '';

	$('body').on('click', '.ajax_add_to_cart', function(){
		$('.woocommerce-message').remove();
		if ($('body').hasClass('woocommerce-wishlist'))
		{
			var imgSrc = $(this).parents('tr').find('img.attachment-shop_thumbnail').attr('src');
			var prodTitle = $(this).parents('tr').find('.product-name a').html();
		}
		else 
		{
			var imgSrc = $(this).parents('li').find('img.attachment-shop_catalog').attr('src');
			var prodTitle = $(this).parents('li').find('.product-title-link').html();
		}

		if ( typeof imgSrc != 'undefined' && typeof prodTitle != 'undefined' && $('body').hasClass('gbt_custom_notif') )
		{
			notificationContent = '<div class="woocommerce-message"><div class="product_notification_wrapper"><div class="product_notification_background" style="background-image:url(' + imgSrc + ')"></div><div class="product_notification_text">&quot;' + prodTitle + '&quot;' + addedToCartMessage +'</div></div></div>';
		}
		else 
		{
			notificationContent = false;
		}
	});

	//======================================================
	//  Display notification on ajax add to cart
	//======================================================
	$(document).on('added_to_cart', function(event, data) {
		if (notificationContent != false)
		{
			$('#content').prepend(notificationContent);
		}
	});

				
});