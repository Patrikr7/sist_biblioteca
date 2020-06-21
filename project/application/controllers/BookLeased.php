<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BookLeased extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('bookLeased_model');
        $this->load->model('book_model');
        $this->load->model('client_model');
    }

    public function index()
    {
        $dados = [
            'title' => 'Livros Locado',
            'title_page' => 'Livros Locado',
            'message' => 'Livros Locado!',
            'url' => "",
            'bookLeased' => $this->bookLeased_model->getBookLeasedsJoin(),
        ];
        $this->template->load('ci_panel/template', 'ci_panel/book-leased/home', $dados);
    }

    public function page_create()
    {
        $dados = array(
            'title' => 'Locação',
            'title_page' => 'Locação',
            'message' => 'Locação!',
            'url' => "",
            'client' => $this->client_model->getClientActive(),
            'book' => $this->book_model->getBooksAvailable(),
        );
        $this->template->load('ci_panel/template', 'ci_panel/book-leased/create', $dados);
    }

    public function create()
    {
        $json = [];
        $dados_form = $this->input->post();

        if ($this->form_validation->set_rules('id_client', 'Cliente', 'trim|required')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('id_book', 'Livro', 'trim|required')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('date_start', 'Data início', 'trim|required|regex_match[/^([0-9]{1,2})\\/([0-9]{1,2})\\/([0-9]{4})$/]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('date_end', 'Data de entrega', 'trim|required|regex_match[/^([0-9]{1,2})\\/([0-9]{1,2})\\/([0-9]{4})$/]')->run() === false):
            $json["error"] = validation_errors();

        elseif (date("Y-m-d", strtotime(implode('-', explode('/', $dados_form['date_end'])))) < date("Y-m-d", strtotime(implode('-', explode('/', $dados_form['date_start']))))):
            $json["error"] = 'Data de entrega não pode ser menor que a data de início!';

        else:

            $dados_form['date_start'] = date('Y-m-d', strtotime(implode('-', explode('/', $dados_form['date_start']))));
            $dados_form['date_end'] = date('Y-m-d', strtotime(implode('-', explode('/', $dados_form['date_end']))));
			$dados_form['leased'] = 1;

            if ($this->bookLeased_model->create($dados_form)):
				$json['success'] = 'Livro alugado com sucesso!';

                $this->book_model->setBookReadAmount($dados_form["id_book"]);
                
                $json['redirect'] = '../livros-locado';

            else:
                $json['error'] = 'Erro ao alugar livro, entre em contato com o suporte!';

            endif;

        endif;

        echo json_encode($json);
	}
	
	public function update()
    {
		$this->bookLeased_model->update();
	}
}
