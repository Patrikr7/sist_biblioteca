<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="pt-br" itemscope itemtype="https://schema.org/WebSite">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta http-equiv="content-language" content="pt-br">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="theme-color" content="#">
	<meta name="msapplication-navbutton-color" content="#">
	<title><?php echo $title; ?></title>

	<link rel="shortcut icon" href="<?php echo base_url('assets/img/' . FAVICON) ?>">
	
	<meta name="robots" content="index, follow" />

	<link rel="base" href="<?php echo base_url() ?>" />
	<link rel="canonical" href="<?php echo base_url($url) ?>" />
	<link rel="author" href="" />

	<link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/font-awesome/5.0/css/fontawesome-all.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/toastr/toastr.min.css'); ?>" rel="stylesheet"/>
	<link href="<?php echo base_url('assets/plugins/sweetalert/sweetalert.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/styles.css'); ?>" rel="stylesheet" />
</head>

<body>
<?php $this->load->view('ci_panel/navbar'); ?>
	<main class="main">
		<div id="body">
			<?php echo $contents; ?>
		</div>
	</main>
<?php $this->load->view('ci_panel/footer'); ?>

	<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/jquery/jquery-form.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/toastr/toastr.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/sweetalert/sweetalert.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/boot.js'); ?>"></script>
</body>

</html>