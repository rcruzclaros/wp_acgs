jQuery(document).ready(function($) {
	/**
	 * Binnacle remove
	 */  
	$('a[data-binnacle-remove]').click(function(e) {
		e.preventDefault();
		var binid = $(this).attr('data-binnacle-remove');

		$.ajax({
		   type : "post",
		   url : ajax_object.ajax_url,
		   data : {
			   action: "acgs_binnacle_remove",
			   bid: binid,
		   },
		   error: function(response){
		   },
		   success: function(response) {
			  if(response.success == true) {

				$('a[id='+binid+'], button[id='+binid+']').closest('tr').remove();

				M.toast({html: 'Binnacle item removed', classes: 'teal darken-1'})

				setTimeout(function() {
					document.location.reload();
				}, 800);
			  }
		   }
	   });

	});

	/**
	 * Submit events filter via ajax
	 */
	if ($('#events_search_form').length > 0) {

		$('#events_search_form').submit(function(e) {
			e.preventDefault();
			$('#search_events_results').css('opacity', '0.5');

			var fullname = $('#events_search_form input[name="fullname"]').val(),
				lname = $('#events_search_form input[name="lname"]').val(),
				parish = $('#events_search_form select[name="parish"]').val(),
				city = $('#events_search_form select[name="city"]').val(),
				type = $('#events_search_form select[name="type"]').val()
			
			$.ajax({
			   type : "post",
			   url : ajax_object.ajax_url,
			   data : {
				   action: "search_ceremony_events",
				   'fullname': fullname,
				   'lname': lname,
				   'parish': parish,
				   'city': city,
				   'type': type
			   },
			   error: function(jqXHR, status, errorThrown){
			   		console.error('Error searching ceremony events: ' + errorThrown);
			   },
			   success: function(response) {
			   		$('#search_events_results').html(response);
				  if(response) {

				  	$('#search_events_results').html(response);

				  }
			   },
			   complete: function(jqXHR, status) {
			   		$('#search_events_results').css('opacity', '1');
			   }
		   });

		});

		$('#events_search_form').trigger('submit');
	}

});