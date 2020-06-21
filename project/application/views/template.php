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

	<meta name="description" content="<?php echo $description; ?>" />
	<meta name="robots" content="index, follow" />

	<link rel="base" href="<?php echo base_url() ?>" />
	<link rel="canonical" href="<?php echo base_url($url) ?>" />
	<link rel="author" href="" />

	<meta itemprop="name" content="<?php echo $title; ?>" />
	<meta itemprop="description" content="<?php echo $description; ?>" />
	<meta itemprop="image" content="<?php echo base_url('assets/img/' . $image) ?>" />
	<meta itemprop="url" content="<?php echo base_url($url) ?>" />

	<meta property="og:type" content="article" />
	<meta property="og:title" content="<?php echo $title; ?>" />
	<meta property="og:description" content="<?php echo $description; ?>" />
	<meta property="og:image" content="<?php echo base_url('assets/img/' . $image) ?>" />
	<meta property="og:url" content="<?php echo base_url($url) ?>" />
	<meta property="og:site_name" content="<?php echo TITLE_NAME ?>" />
	<meta property="og:locale" content="pt_BR" />
	<meta property="article:author" content="https://www.facebook.com/" />
	<meta property="article:publisher" content="https://www.facebook.com/>" />

	<link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/styles.css'); ?>" rel="stylesheet" />
</head>

<body>
	<?php $this->load->view('inc/navbar-inc'); ?>
	<main class="main">
		<div id="body">
			<?php echo $contents; ?>
		</div>
	</main>
	<?php $this->load->view('inc/footer-inc'); ?>

	<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
</body>

</html>