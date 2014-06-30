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
	<!--	<link href="--><?php //echo site_url('assets/css/css/smoothness/jquery-ui-1.10.4.custom.min.css');?><!--" rel="stylesheet">-->

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries
    WARNING: Respond.js doesn't work if you view the page via file://
    [if lt IE 9]-->
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>


	<script src="<?php echo site_url('assets/js/jquery-1.11.0.js');?>"></script>
	<!--	<script src="--><?php //echo site_url('assets/js/jquery-ui-1.10.4.custom.min.js');?><!--"></script>-->
	<script src="<?php echo site_url('assets/js/bootstrap.min.js');?>"></script>
	<script src="<?php echo site_url('assets/js/bootstrap-datepicker.js');?>"></script>
	<script src="<?php echo site_url('assets/js/event_search.js');?>"></script>
	<script src="<?php echo site_url('assets/js/friends_search.js');?>"></script>
	<script src="<?php echo site_url('assets/js/people_you_may_know.js');?>"></script>
	<script src="<?php echo site_url('assets/js/user_added_event_form.js');?>"></script>
	<script src="<?php echo site_url('assets/js/event_modal.js');?>"></script>
	<script src="<?php echo site_url('assets/js/account_settings.js');?>"></script>
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
			toolbar_items_size: 'small'
		});
	</script>
	<script>
		function startTime() {
			var today=new Date();
			var h=today.getHours();
			var m=today.getMinutes();
			var s=today.getSeconds();
			var dy = today.getDate();
			var weekday = new Array(7);
				weekday[0]=  "Sunday";
				weekday[1] = "Monday";
				weekday[2] = "Tuesday";
				weekday[3] = "Wednesday";
				weekday[4] = "Thursday";
				weekday[5] = "Friday";
				weekday[6] = "Saturday";

			var d = weekday[today.getDay()];
			
			var month = new Array();
				month[0] = "January";
				month[1] = "February";
				month[2] = "March";
				month[3] = "April";
				month[4] = "May";
				month[5] = "June";
				month[6] = "July";
				month[7] = "August";
				month[8] = "September";
				month[9] = "October";
				month[10] = "November";
				month[11] = "December";
			
			var mn = month[today.getMonth()];
			
			m = checkTime(m);
			s = checkTime(s);
			document.getElementById('homepage_timer').innerHTML = d+" "+ mn+" " +dy+", "+ h+":"+m+":"+s;
			var t = setTimeout(function(){startTime()},500);
		}

		function checkTime(i) {
			if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
			return i;
		}
	</script>
</head>

<body class="page-<?php echo $page_class ?>">

<?php echo $this->load->view($sub_layout) ?>

<hr>
<div class = "container">
	<ul class=" nav navbar-nav">
		<li><?php echo anchor('page/about','About');?></li>
		<li><?php echo anchor('page/howitworks','How it Works');?></li>
		<li><?php echo anchor('page/faq','FAQ');?></li>
		<li><?php echo anchor('email/contact','Contact', 'data-toggle="modal" data-target="#contact_form"');?></li>
	</ul>

	<ul class = "nav navbar-nav navbar-right">
		<li class = "push-right text-muted">&copy 2014. All rights reserved</li>
	</ul>
</div>

</body>
</html>