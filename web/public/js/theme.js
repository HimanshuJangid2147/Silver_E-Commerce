(function($) {
    'use strict';

			/*==== One Page Nav  ====*/
			
			var top_offset = $('.one_page').height() +0;
			$('.one_page .juyelas_menu .nav_scroll').onePageNav({
				currentClass: 'current',
				changeHash: false,
				scrollSpeed: 1000,
				 scrollOffset: top_offset,
				scrollThreshold: 0.5,
				filter: '',
				easing: 'swing',
			});
			
			$(".nav_scroll > li:first-child").addClass("current");

			/*==== sticky nav 1  ====*/
			$('.one_page').scrollToFixed({
				preFixed: function() {
					$(this).find('.scroll_fixed').addClass('prefix');
				},
				postFixed: function() {
					$(this).find('.scroll_fixed').addClass('postfix').removeClass('prefix');
				}
			});	
		
			/*==== sticky nav 2  ====*/
			var headers1 = $('.trp_nav_area');
			$(window).on('scroll', function() {

				if ($(window).scrollTop() > 200) {
					headers1.addClass('hbg2');
				} else {
					headers1.removeClass('hbg2');
				}		
			});	

			/*==== Mobile Menu  ====*/
			$('.mobile-menu nav').meanmenu({
				meanScreenWidth: "990",
				meanMenuContainer: ".mobile-menu",
				onePage: true,
			});
			
			/*==== Top quearys menu  ====*/
			var emsmenu = $(".em-quearys-menu i.t-quearys");
			var emscmenu = $(".em-quearys-menu i.t-close");
			var emsinner = $(".em-quearys-inner");
			emsmenu.on('click', function() {
				emsinner.addClass('em-s-open');
				$(this).addClass('em-s-hiddens');
				emscmenu.removeClass('em-s-hidden');
			});
			emscmenu.on('click', function() {
				emsinner.removeClass('em-s-open');
				$(this).addClass('em-s-hidden');
				emsmenu.removeClass('em-s-hidden');
			});

			/*==== popup mobile menu  ====*/
			
			var mrightma = $(".mobile_menu_o i.openclass");
			var mrightmi = $(".mobile_menu_o i.closeclass");
			var mrightmir = $(".mobile_menu_inner");
			var mobile_ov = $(".mobile_overlay");
			mrightma.on('click', function() {
				mrightmir.addClass('tx-s-open');
				mobile_ov.addClass('mactive');
			});
			mrightmi.on('click', function() {
				mrightmir.removeClass('tx-s-open');
				mobile_ov.removeClass('mactive');
			});

			/*==== WOW active js ====*/
			new WOW().init();

			/*==== scrollUp  ====*/
			
			$.scrollUp({
				scrollText: '<i class="icofont-thin-up"></i>',
				easingType: 'linear',
				scrollSpeed: 900,
				animation: 'fade'
			});

			/*==== Venubox  ====*/
			$('.venobox').venobox({
				numeratio: true,
				infinigall: true
			});

			/*==== project active ====*/
			
			var witrbslick = $('.proj_active');				
				if(witrbslick.length > 0){
				witrbslick.slick({
					infinite: true,
					autoplay: true,
					autoplaySpeed: 6000,
					speed: 2000,					
					slidesToShow: 4,
					slidesToScroll: 1,
					arrows:true ,
					dots: false,
					responsive: [
						{
							breakpoint: 1200,
							settings: {
								slidesToShow: 3,
								slidesToScroll: 1,
							}
						},
						{
							breakpoint: 992,
							settings: {
								slidesToShow: 2,
								slidesToScroll: 1,
							}
						},
						{
							breakpoint: 767,
							settings: {
								slidesToShow: 1,
								slidesToScroll: 1,
							}
						}
						]
					});
				}
			
			/*==== slider active ====*/
			var witrbslick = $('.slider_active');
                            	
				if(witrbslick.length > 0){
			
				witrbslick.slick({
					infinite: true,
					autoplay: true,
					default: true,
					autoplaySpeed: 3000,
					speed: 1000,					
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: true,
					dots: false,
					responsive: [
						{
							breakpoint: 1200,
							settings: {
								slidesToShow: 1,
								slidesToScroll: 1,
							}
						},
						{
							breakpoint: 992,
							settings: {
								slidesToShow: 1,
								slidesToScroll: 1,
							}
						},
						{
							breakpoint: 767,
							settings: {
								slidesToShow: 1,
								slidesToScroll: 1,
							}
						}
						]
					});
				}		
				/*==== single service active ====*/
				
				var witrbslick = $('.brand_active');
									
					if(witrbslick.length > 0){
				
					witrbslick.slick({
						infinite: true,
						autoplay: true,
						default: true,
						autoplaySpeed: 3000,
						speed: 1000,					
						slidesToShow: 5,
						slidesToScroll: 1,
						arrows: true,
						dots: false,
						responsive: [
							{
								breakpoint: 1200,
								settings: {
									slidesToShow: 5,
									slidesToScroll: 1,
								}
							},
							{
								breakpoint: 992,
								settings: {
									slidesToShow: 4,
									slidesToScroll: 1,
								}
							},
							{
								breakpoint: 767,
								settings: {
									slidesToShow: 1,
									slidesToScroll: 1,
								}
							}
							]
						});
					}		
				
			/*==== blog active ====*/
			
			var witrbslick = $('.blog_active');				
				if(witrbslick.length > 0){
				witrbslick.slick({
					infinite: true,
					autoplay: true,
					autoplaySpeed: 6000,
					speed: 2000,					
					slidesToShow: 3,
					slidesToScroll: 1,
					arrows: true,
					dots: false,
					responsive: [
						{
							breakpoint: 1200,
							settings: {
								slidesToShow: 3,
								slidesToScroll: 1,
							}
						},
						{
							breakpoint: 992,
							settings: {
								slidesToShow: 2,
								slidesToScroll: 1,
							}
						},
						{
							breakpoint: 767,
							settings: {
								slidesToShow: 1,
								slidesToScroll: 1,
							}
						}
						]
					});
				}
				
			/*==== blog sidebar active ====*/
			$('.blog_sidebar_image_act').slick({	
				infinite: true,
				autoplay: true,
				autoplaySpeed: 3000,
				speed: 1000,					
				slidesToShow: 1,
				slidesToScroll: 1,
				centerMode: true,
				centerPadding: '',					
				arrows: false,
				dots: false,
				responsive: [
					{
						breakpoint: 1200,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1,
						}
					},
					{
						breakpoint: 992,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1,
						}
					},
					{
						breakpoint: 768,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1,
						}
					}
					]
				});
				
			/*==== testimonial active ====*/
			
			var witrbtslick = $('.test_active');				
			if(witrbtslick.length > 0){
			witrbtslick.slick({
				infinite: true,
				autoplay: true,
				slidesToShow:3,
				spaceBetween: 10,
				autoplaySpeed: 6000,
				speed: 2000,					
				slidesToScroll: 1,
				arrows:false ,
				dots:false,
				responsive: [
					{
						breakpoint: 1200,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 1,
						}
					},
					{
						breakpoint: 992,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 1,
						}
					},
					{
						breakpoint: 767,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1,
						}
					}
					]
				});
			}

			/*==== portfolio isotop ====*/
			
			$('.portfolio_active').imagesLoaded( function() {
				if ($.fn.isotope) {

					var $portfolio = $('.portfolio_active');

					$portfolio.isotope({

						itemSelector: '.grid-item',

						filter: '*',

						resizesContainer: true,

						layoutMode: 'masonry',

						transitionDuration: '0.8s'

					});

					$('.filter_menu li').on('click', function() {

						$('.filter_menu li').removeClass('current_menu_item');

						$(this).addClass('current_menu_item');

						var selector = $(this).attr('data-filter');

						$portfolio.isotope({

							filter: selector,

						});

					});

				};
			});
				
			/*==== Mouse Direction Hover Iffect ====*/
			
			$('.single_protfolio').directionalHover();
			$('.single_protfolio').directionalHover({
				overlay: "em_port_content",
				easing: "swing",
				speed: 50
			});	
			
			/*==== Bootstrap Accordion  ====*/
			$('.faq-part .card').each(function () {
				var $this = $(this);
				$this.on('click', function (e) {
					var has = $this.hasClass('active');
					$('.faq-part .card').removeClass('active show');
					if (has) {
						$this.removeClass('active show');
					} else {
						$this.addClass('active show');
					}
				});
			});
			
			/*==== counter active ====*/
				
			$('.counter').counterUp({
				delay: 20,
				time: 3000
			});

})(jQuery);




