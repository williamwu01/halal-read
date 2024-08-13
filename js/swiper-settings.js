document.addEventListener('DOMContentLoaded', function() {
	const swiperHome = new Swiper('.swiper-home', {
			loop: true,  // Disable loop to handle dynamic loading
			autoHeight: true,
			navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
			},
			slidesPerView: 1,
			spaceBetween: 10,
			breakpoints: {
					800: {
							slidesPerView: 1,
							spaceBetween: 20
					},
			},
			on: {
					reachEnd: function () {
							loadMoreBooks();
					}
			}
	});

	let page = 2;

	// function loadMoreBooks() {
	// 		var ajaxurl = swiper_home_params.ajax_url;
	// 		var data = {
	// 				action: 'load_more_books',
	// 				page: page
	// 		};

	// 		jQuery.post(ajaxurl, data, function(response) {
	// 				if (response) {
	// 						var newSlides = jQuery(response);
	// 						swiperHome.appendSlide(newSlides);
	// 						swiperHome.update();
	// 						page++;
	// 				}
	// 		});
	// }
});
