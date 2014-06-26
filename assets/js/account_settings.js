$(function() {
	$('.page-account-settings #event_cities').on('click', '.item-city-name', function(e) {
		e.preventDefault();
		var cityName = $(this).text();
		var cityId = $(this).siblings('.item-city-id').text();
		$('#metro-id').val(cityId);
		$('#metro-name').text(cityName);
		$('#event_cities').modal('hide');
	});
});