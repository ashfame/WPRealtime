function enginerun() {
	(function($){
		$(document).ready(function(){
			// Make ajax call to fetch fresh stats
			$.ajax({
				type: 'POST',
				url: wprealtime.ajaxurl,
				data: {
					action: 'wprealtime_whats_new'
				}
			}).done(function(response){
				response = $.parseJSON(response);
				if ( response.status == 'success' ) {
					var dashboard_right_now_tds = $('#dashboard_right_now td');
					$(dashboard_right_now_tds).eq(0).find('a').html(response.count.posts.publish);
					$(dashboard_right_now_tds).eq(2).find('a').html(response.count.pages.publish);
					$(dashboard_right_now_tds).eq(4).find('a').html(response.count.categories);
					$(dashboard_right_now_tds).eq(6).find('a').html(response.count.tags);
					$(dashboard_right_now_tds).eq(8).find('a').html(response.count.comments.total_comments);
					$(dashboard_right_now_tds).eq(10).find('a').html(response.count.comments.approved);
					$(dashboard_right_now_tds).eq(12).find('a').html(response.count.comments.total_comments-response.count.comments.approved);
					$(dashboard_right_now_tds).eq(14).find('a').html(response.count.comments.spam);
				}
			});
			// Refetch stats after timeout
			setTimeout(enginerun,5000);
		});
	})(jQuery);
}

(function($){
	$(document).ready(function(){
		// Initial start for engine
		setTimeout(enginerun,5000);
	});
})(jQuery);