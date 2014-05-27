<!DOCTYPE html>
<html lang = "en">
<head>
	<meta charset = "UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo config_item('meta_title'); ?></title>
    <link rel="icon" type="image/ico" href="<?php echo site_url('assets/img/logo/h.png');?>"/>
	<meta name="keywords" content="Events, social, calendar, plan, share, enjoy, music, sports, broadway, to do, comedy">
	<meta name="description" content="Hashplan is a social application empowering users to search for events in their local community, schedule them on their plans and share with friends.">
	<script type="text/javascript">
		var base_url = "<?=base_url('/')?>";
	</script>
	<!-- Bootstrap -->
	<link href="<?php echo site_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
	<link href="<?php echo site_url('assets/css/datepicker.css');?>" rel="stylesheet">
	<link href="<?php echo site_url('assets/css/styles.css');?>" rel="stylesheet">
	<!--<link href="<?php echo site_url('assets/css/css/smoothness/jquery-ui-1.10.4.custom.min.css');?>" rel="stylesheet">-->
	<!--<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>-->

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries
    WARNING: Respond.js doesn't work if you view the page via file:// 
    [if lt IE 9]-->
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>


	<script src="<?php echo site_url('assets/js/jquery-1.11.0.js');?>"></script>
	<script src="<?php echo site_url('assets/js/jquery-ui-1.10.4.custom.min.js');?>"></script>
	<script src="<?php echo site_url('assets/js/bootstrap.min.js');?>"></script>
	<script src="<?php echo site_url('assets/js/event_search.js');?>"></script>
	<script src="<?php echo site_url('assets/js/event_modal.js');?>"></script>
	<script src="<?php echo site_url('assets/js/tinymce/tinymce.min.js');?>"></script>
	<script src="<?php echo site_url('assets/js/tooltip_for_event_to_plan.js');?>"></script>
	<script type="text/javascript">
		tinymce.init({
			selector: "input_variable_here",
			plugins: [
				"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
				"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
				"table contextmenu directionality emoticons template textcolor paste fullpage textcolor"
			],

			toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
			toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | inserttime preview | forecolor backcolor",
			toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",

			menubar: true,
			toolbar_items_size: 'small',
		});
	</script>
	<script>
		function startTime() {
			var today=new Date();
			var h=today.getHours();
			var m=today.getMinutes();
			var s=today.getSeconds();
			m = checkTime(m);
			s = checkTime(s);
			document.getElementById('homepage_timer').innerHTML = h+":"+m+":"+s;
			var t = setTimeout(function(){startTime()},500);
		}

		function checkTime(i) {
			if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
			return i;
		}
</script>
</head>