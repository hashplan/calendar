<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=config_item('meta_title'); ?></title>
    <link rel="icon" type="image/ico" href="<?=site_url(config_item('meta_icon')); ?>"/>
    <meta name="keywords" content="<?=config_item('meta_keywords'); ?>">
    <meta name="description" content="<?=config_item('meta_description'); ?>">
    <script type="text/javascript">
        var base_url = "<?=base_url('/')?>";
    </script>
    <!-- Bootstrap -->
    <?$this->carabiner->display('bootstrap', 'css');?>
    <link href="<?php echo site_url('assets/css/css/smoothness/jquery-ui-1.10.4.custom.min.css'); ?>" rel="stylesheet">
    <?$this->carabiner->display('page_assets', 'css');?>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries
    WARNING: Respond.js doesn't work if you view the page via file://
    [if lt IE 9]-->
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    <?$this->carabiner->display('header_js', 'js');?>

    <script src="<?php echo site_url('assets/js/account_settings.js'); ?>"></script>
    <script src="<?php echo site_url('assets/js/tinymce/tinymce.min.js'); ?>"></script>
    <!--<script src="<?php echo site_url('assets/js/tooltip_for_event_to_plan.js'); ?>"></script>-->
    <script src="<?php echo site_url('assets/js/invites_left_block.js'); ?>"></script>
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

    </script>
</head>

<body class="page-<?php echo $page_class ?>">