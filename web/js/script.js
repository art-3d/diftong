$( document ).ready(function() {
	'use strict';

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
	
	$(document).on('click', '.direction > a', function(event) {
		event.preventDefault();
		
		var direction = $(this).text().trim();

		// change url
		window.history.pushState(null, $('title').text(), $(this).attr('href') );
		
		// lodash load
		if (typeof _ === 'undefined') {
			$.ajax({
				url: '/js/lodash.min.js',
				dataType: 'script',
				success: function(data) {
					showSubjects(direction);
				}
			});
		} else {
			showSubjects(direction);
		}
	});

	$(document).on('click', '.all-directions', function(event){
		event.preventDefault();
		showDirections();
	});

	/* check direction in url */

	var search = window.location.search;
	if (search != '') {
		$('a[href="'+search+'"]').click();
	}

	/* add subject */
	$(document).on('click', '#add-subject-btn', function(event) {
		event.preventDefault();

		var subject_title = $('#subject-title').val();

		var url = '/main/add-subject'+window.location.search;
		url += '&title='+subject_title;

		var pathname = window.location.pathname;
		if ( null !== pathname.match(/\/inst\/[\d]+/) ) {
			var inst_id = pathname.replace(/\D*/, '');
			url += '&inst_id='+inst_id;
		} else if( null !== pathname.match(/\/tech\/[\d]*/) ) {
			var tech_id = pathname.replace(/\D*/, '');
			url += '&tech_id='+tech_id;
		}else {
			var title_en = pathname.replace('/', '');
			url += '&title_en='+title_en;
		}
	
		// rules		
		if (subject_title.length < 2 || !subject_title.match(/[0-9a-zа-я\s]*/i) ) return false;


		$.ajax({
			url: url,
			dataType: 'json',
			success: function(data) {
				window.location.reload(true);
			},
		}).always( function(data) {
			window.location.reload(true);
		});

	});

	/* press enter */
	$(document).on('keypress', '#subject-title', function(event){
		if (event.which == 13) $('#add-subject-btn').click();
	});

	/* select subject */
	$(document).on('click', 'a.subject', function(event) {

		// lodash load
		if (typeof _ === 'undefined') {
			$.ajax({
				url: '/js/lodash.min.js',
				dataType: 'script',
				success: function(data) {
					showFiles();
				}
			});
		} else {
			setTimeout(showFiles, 10);
		}
	});
	
	
	/* breadcrumb */
	
	if ( $('.breadcrumb > li').length ) {
		$('.close').click();
	}
		
}); // end ready


/* show / hide (directions/subjects) */

function showSubjects(direction) {
	$('.directions').hide();
	$('h4[name=directions]').html('<a class="btn btn-primary all-directions" href="'+window.location.pathname+'">Все направления</a>');

	
	var url = '/main/get-subject' + window.location.search;
	var pathname = window.location.pathname;



	if ( null !== pathname.match(/\/inst\/[\d]+/) ) {
		var inst_id = pathname.replace(/\D*/, '');
		url += '&inst='+inst_id;
	} else if( null !== pathname.match(/\/tech\/[\d]*/) ) {
		var tech_id = pathname.replace(/\D*/, '');
		url += '&tech='+tech_id;
	}else {
		var title_en = pathname.replace('/', '');
		url += '&title_en='+title_en;
	}

	$.ajax({
		dataType: 'json',
		url: url,
	}).success(function(data){
		$.ajax({
			dataType: 'html',
			url: '/lodash/subjects.html'
		}).success(function(template){
			data = {subjects: data};
			data.direction = direction;

			var tmpl = _.template(template);
			var result = tmpl(data);

			$('.page-header').next().after(result);
		});
	});


}

function showDirections() {
	$('h4[name=directions]').html('Направления');
	$('.directions').show();
	$('.subjects').remove();

	// change url
	window.history.pushState(null, $('title').text(), window.location.pathname );
}

/* show files */
function showFiles() {

	var pathname = window.location.pathname;
	var id = window.location.hash.substr(1);

	$.ajax({
		method: 'POST',
		dataType: 'json',
		url: '/main/get-file',
		data: {pathname: pathname, id: id},
	}).success(function(data) {
		console.log(data);
	});

}