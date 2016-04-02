$( document ).ready(function() {
		
	$('.select-inst').on('click', function(event) {
		event.preventDefault();
		$(this).toggleClass('btn-primary');
		$('.search-block').toggleClass('hidden');
	});
	
	$('.search-region-btn').on('click', function(event) {
		event.preventDefault();

		if( $(this).hasClass('btn-primary') && !$(this).next().hasClass('btn-primary') ){
			$(this).next().click();
		}

		$(this).toggleClass('btn-primary');
		$('.search-region-list').toggleClass('hidden');


	});
	
	$('.search-direction-btn').on('click', function(event) {
		event.preventDefault();

		if( $(this).hasClass('btn-primary') && !$(this).prev().hasClass('btn-primary') ){
			$(this).prev().click();
		}

		$(this).toggleClass('btn-primary');
		$('.search-direction-list').toggleClass('hidden');
	});    
	
	$('.search-direction-list > li > a').on('click', function(event) {
		event.preventDefault();
		$(this).parent().find('ul').toggleClass('hidden');      
	});


	/* костыль для Yii2 pagination */
	var a_links = $('.pagination a');
	$.each(a_links, function(index, value) {
		var href = $(value).attr('href');
		href = href.replace('??', '?');
		href = href.replace(/\/\?/g, '/');
		href = href.replace('//page', '?page');
		href = href.replace('/?page', '?page');
		href = href.replace('/page', '?page');
		href = href.replace('/city', '?city');
		$(value).attr('href', href);
	});

	$('span.typeahead-button > button > i').on('click', function(event) {
		event.preventDefault();
		var query = $('#inst-query').val();
		document.location.href = '/search?q='+query;
	});
	
	
	
	/* inst selected */
	
	var hash = document.location.hash;
	
	if (hash != undefined) {
		
	}
	
	/* breadcrumb */
	
	if ( $('.breadcrumb > li').length ) {
		$('.close').click();
	}
		
}); // end ready
