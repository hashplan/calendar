<!DOCTYPE html>
<html lang = "en">
  <head>
  <meta charset = "UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $meta_title; ?></title>
    <!-- Bootstrap -->
	<link href="<?php echo site_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
	<link href="<?php echo site_url('assets/css/datepicker.css');?>" rel="stylesheet">
	<link href="<?php echo site_url('assets/css/styles.css');?>" rel="stylesheet">
	<link href="<?php echo site_url('assets/css/css/smoothness/jquery-ui-1.10.4.custom.min.css');?>" rel="stylesheet">
	<!--<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>-->
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries
    WARNING: Respond.js doesn't work if you view the page via file:// 
    [if lt IE 9]-->
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    
	
	<!--<script src="http://code.jquery.com/jquery-latest.js"></script>-->
	<script src="<?php echo site_url('assets/js/jquery-1.11.0.js');?>"></script>
	<script src="<?php echo site_url('assets/js/jquery-ui-1.10.4.custom.min.js');?>"></script>
	<script src="<?php echo site_url('assets/js/bootstrap.min.js');?>"></script>
	<!--<script src="<?php echo site_url('assets/js/bootstrap-datepicker.js');?>"></script>-->
	<script src="<?php echo site_url('assets/js/event_search.js');?>"></script>
	<!--<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>-->
	<script src="<?php echo site_url('assets/js/tinymce/tinymce.min.js');?>"></script>
	<script src="<?php echo site_url('assets/js/tooltip_for_event_to_plan.js');?>"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTf3-ayxTEKP8dZW7QWZIuoNnVBl0jas4&sensor=true"></script>
	<script src="<?php echo site_url('assets/js/google_maps_api.js');?>"></script>
<script type="text/javascript">
tinymce.init({
        selector: "textarea",
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
});</script>
</head>