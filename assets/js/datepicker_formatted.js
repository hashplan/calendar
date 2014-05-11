$(function(){
	$('.datepicker').datepicker({
	format:'yyyy-mm-dd',
    changeMonth: true,
    changeYear: true,
	showOtherMonths: true,
    selectOtherMonths: true,
	//minDate: 0,
	//maxDate: "+1M +10D",
	showButtonPanel: true,
	showOn:"focus",
	});
});
