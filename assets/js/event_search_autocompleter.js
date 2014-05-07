$(function(){
  $("#event_list").autocomplete({
	source: "dashboard/events_autocomplete",
	dataType: 'jsonp',
  });
	 
	 $("#event_list").keyup(function(){
		var value =  $("#event_list").val();
		 $.ajax({
				url:'dashboard/events_autocomplete',
				type:'POST',
				//minLength: 2,
				data:  {name:value},
				success:function(event_array){
					//$('#search_result').html(event_array);	
					$('#search_result').text("testing the autocomplete: " +  value);	
				}
			});
	});
});
