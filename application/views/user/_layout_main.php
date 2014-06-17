<?php $this->load->view('/components/page_head');?>

<body class="page page-<?php echo $page_class ?>">

<?php $this->load->view('components/user_header_menu') ?>
<div class = "container">
	<div class = "row">
		<!--Main column-->
		<div class = "col-md-9">
			<?php $this->load->view($subview);?>
		</div>
	</div>
</div>
<?php $this->load->view('/components/page_tail');?>