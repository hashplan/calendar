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
    <script src="<?= site_url('assets/js/html5shiv.js'); ?>"></script>
    <script src="<?= site_url('assets/js/respond.min.js'); ?>"></script>

    <?$this->carabiner->display('header_js', 'js');?>

    <script src="<?= site_url('assets/js/account_settings.js'); ?>"></script>
    <script src="<?= site_url('assets/js/invites_left_block.js'); ?>"></script>

</head>

<body class="page-<?php echo $page_class ?>">
<div class="notification"><?=display_notification()?></div>