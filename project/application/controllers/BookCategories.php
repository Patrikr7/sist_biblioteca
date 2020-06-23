<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BookCategories extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('bookCategories_model');
    }

    public function index()
    {
        $dados = [
            'title' => 'Categorias | ' . TITLE_NAME,
            'title_page' => 'Listar Categorias',
            'message' => 'Listar Categories!',
            'url' => "",
            'categories' => $this->bookCategories_model->ListCategories()
        ];
        $this->template->load('ci_panel/template', 'ci_panel/book-categories/home', $dados);
    }

    public function page_create()
    {
        $dados = array(
            'title' => 'Nova Categoria | ' . TITLE_NAME,
            'title_page' => 'Nova Categoria',
            'message' => 'Nova Categoria!',
            'url' => "",
            'categories' => $this->bookCategories_model->ListCategories()
        );
        $this->template->load('ci_panel/template', 'ci_panel/book-categories/create', $dados);
    }

    public function page_update()
    {
        $dados = array(
            'title' => 'Atualizar Categoria | ' . TITLE_NAME,
            'title_page' => 'Atualizar Categoria',
            'message' => 'Atualizar Categoria!',
            'url' => "",
            'categorie' => $this->bookCategories_model->getBookCategories($this->uri->segment(4)),
            'categories' => $this->bookCategories_model->ListCategories()
        );
        $this->template->load('ci_panel/template', 'ci_panel/book-categories/update', $dados);
    }

    public function create()
    {
        $json = [];
        $dados_form = $this->input->post();

        if ($this->form_validation->set_rules('cat_title', 'Nome', 'trim|required')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('cat_parent', 'Categoria Pai')->run() === false):
            $json["error"] = validation_errors();

        else:
            $url = slug($dados_form['cat_title']);
            if ($this->bookCategories_model->getCategorieTitle($dados_form['cat_title'])->num_rows() >= 1):
                $url .= '-' . $this->bookCategories_model->getCategorieTitle($dados_form['cat_title'])->num_rows();
            endif;

            $dados_form['cat_parent'] = (empty($dados_form['cat_parent']) ? null : $dados_form['cat_parent']);
            $dados_form['cat_url'] = $url;

            if ($this->bookCategories_model->create($dados_form)):                

				$json['success'] = 'Categoria cadastra com sucesso!';                
                $json['redirect'] = '../categorias';

            else:
                $json['error'] = 'Erro ao cadastrar, entre em contato com o suporte!';

            endif;

        endif;

        echo json_encode($json);
    }

    public function update()
    {
        $json = [];
        $dados_form = $this->input->post();

        $id = $this->bookCategories_model->getCategorieId($dados_form['cat_id']);
        $title = $this->bookCategories_model->getCategorieTitle($dados_form['cat_title'])->row_array();

        $url = $this->bookCategories_model->getCategorieUrl($dados_form['cat_title'], $dados_form['cat_id']);

        $cat_parent = $this->bookCategories_model->getCategorieId($dados_form['cat_parent']);

        if ($this->form_validation->set_rules('cat_title', 'Nome', 'trim|required')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('cat_parent', 'Categoria Pai')->run() === false):
            $json["error"] = validation_errors();

        elseif ($title && $title['cat_id'] !== $id['cat_id']):
            $json["error"] = "Esta categoria já existe";
        
        elseif($dados_form['cat_id'] === $dados_form['cat_parent']):
            $json["error"] = "<b>Atenção:</b> Categoria não pode ser filha dela mesma!";

        elseif(!empty($dados_form['cat_parent']) && $cat_parent['cat_parent'] === $dados_form['cat_id']):
            $json["error"] = "<b>Atenção:</b> Categoria não pode ser filha de uma categoria que é sua filha!";

        elseif($this->bookCategories_model->getCategorieParent($dados_form['cat_id']) && !empty($dados_form['cat_parent']) && ($id['cat_parent'] != $dados_form['cat_parent'])):
            $json["error"] = "<b>Atenção:</b> Categoria está sendo usada como pai!";

        else:
            $dados_form['cat_parent'] = (empty($dados_form['cat_parent']) ? null : $dados_form['cat_parent']);
            $dados_form['cat_url'] = $url;

            if ($this->bookCategories_model->update($dados_form)):

                $json['success'] = 'Cadastro atualizado com sucesso!';
                $json['redirect'] = '../../categorias';

            else:
                $json['error'] = 'Erro ao atualizar, entre em contato com o suporte!';

            endif;

        endif;

        echo json_encode($json);
    }

    public function delete()
    {
        $this->bookCategories_model->deleteCategorie();
    }
}
