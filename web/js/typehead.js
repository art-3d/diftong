$(document).on('ready', function(event){
	if( window.location.pathname == '/'){
		$.getScript('js/jquery.typeahead.js', function(data, textStatus, jqxhr) {

			$.ajax({
				dataType: 'json',
				url: '/ajax/get-inst',
			  success: function(data) {
			  

				  var institutions = new Array();
				  var cities = new Object();				
				  var ids = new Object();
					  $.each(data.insts, function(index, inst){
						  institutions.push(inst.title);
						  cities[inst.title] = inst.city;
						  ids[inst.title] = inst.title_en != undefined ? inst.title_en : '/inst/'+inst.id;
					  });
					  $.each(data.techs, function(index, tech){
						  institutions.push(tech.title);
						  cities[tech.title] = tech.city;
						  ids[tech.title] = '/tech/'+tech.id;
					  });

				  $('#inst-query').typeahead({
					  source: institutions,
					  minLength: 1,
					  maxLength: 20,
					  maxItem: 7,
					  emptyTemplate: 'По запросу <b>{{query}}</b> ничего не найдено',
					  template: function(query, item){
						  //display
						  //group
						  //matchedKey
						  //return item.display + ' | ' + cities[item.display];
						  return "{{display}} <small style='color:#999;'>"+cities[item.display]+"</small>";
					  },
					  callback: {
						  onClickAfter: function(node, query, event) {
							  setTimeout(function(){
								  document.location.href = ids[event.display];
							  }, 500);
						  }
					  }
				  });
			  },
			  
			});


	}); // end loading script


	} // end if
});
