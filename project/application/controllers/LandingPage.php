<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landingpage extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
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
	
	public function sobre()
	{
		$dados = array(			
			'title'   => 'INICIAL TEMPLATE - SOBRE',
			'description' => 'DESCRIPTION',
			'image' => 'site.jpg',
			'title_page' => 'Sobre a Empresa',
			'message' => 'Sobre o template de teste!',
			'url' => $this->uri->segment(1)
		);
		$this->template->load('template', 'about-view', $dados);
	}
	
	public function contato()
	{
		$dados = array(			
			'title'   => 'INICIAL TEMPLATE - CONTATO',
			'description' => 'DESCRIPTION',
			'image' => 'site.jpg',
			'title_page' => 'Contato',
			'message' => 'Entre em contato!',
			'url' => $this->uri->segment(1)
		);
		$this->template->load('template', 'contact-view', $dados);
	}
}
