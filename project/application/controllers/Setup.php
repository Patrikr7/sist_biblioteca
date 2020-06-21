<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setup extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
	}
	
	public function index()
	{
		$dados = array(
			'title'   => 'INICIAL TEMPLATE',
			'description' => 'DESCRIPTION',
			'image' => 'site.jpg',
			'title_page' => 'TITLE PAGE',
			'message' => 'Aqui você encontra a página de teste!',
			'url' => ""
		);
		$this->template->load('template', 'home-view', $dados);
	}
}
