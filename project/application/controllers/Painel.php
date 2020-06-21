<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Painel extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model([
			'client_model', 
			'book_model',
			'bookLeased_model'
		]);
	}
	
	public function index()
	{
		$dados = [
			'title'   => 'Painel',
			'title_page' => 'TITLE PAGE',
			'message' => 'Aqui você encontra o painel!',
			'url' => "",
			'countClient' => count($this->client_model->getClients()),
			'countBook' => count($this->book_model->getBooks()),
			'countBookLeased' => (empty($this->bookLeased_model->getBookLeasedsJoin()) ? '0' : count($this->bookLeased_model->getBookLeasedsJoin())),
			'books' => $this->book_model->getLimitBooks(4),
			'booksRead' => $this->book_model->getLimitBooks(4, true)
		];
		$this->template->load('ci_panel/template', 'ci_panel/home', $dados);
	}
}
