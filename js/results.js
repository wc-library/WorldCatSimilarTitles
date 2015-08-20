

$(document).on('ready',function() {
	$('#lookup-modal').on('show.bs.modal', function (event) {
		var row = $(event.relatedTarget).find('td').map(function(index, td) {
			return $(td).text();
		});

		var postdata = {
			'idtype':    $(this).data('idtype'),
			'id':        row[0],
			'title':     row[1],
			'author':    row[2],
			'publisher': row[3],
			'date':      row[4],
			'related':   row[5]
		};

		$.post('ajax_modal.php',{ jsonData: JSON.stringify(postdata) },function(data,status){
			$('#lookup-modal').find('.modal-body').html(data);
		});
	});

	$(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
	// scroll body to 0px on click
	$('#back-to-top').click(function () {
		$('#back-to-top').tooltip('hide');
		$('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});

	$('#back-to-top').tooltip('show');
});