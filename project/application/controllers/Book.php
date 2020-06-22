<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Book extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['book_model', 'bookCategories_model']);
        $this->load->library('upload', config_upload('./assets/uploads/', 'jpg|png', 1500, 'book'));
    }

    public function page_index($page = null)
    {
        $url = base_url('painel/livros');
        $total_rows = $this->book_model->getCount();
        $per_page = 3;
        $totalPages = ceil($total_rows / $per_page); 

        $curr_page = 0;

        if(empty($this->uri->segment(3))):
            $page = 1;
        endif;

        if(isset($page) && trim($page) != ''):
            if ((($per_page * $page) - $per_page) > 0) {
                $curr_page = (($per_page * $page) - $per_page);
            }
        endif;

        if(($page > $totalPages || $page < 1) && $total_rows != 0):
            redirect('painel/livros/' . $totalPages, 'refresh');
            exit;
        endif;        

        $this->pagination->initialize(config_pagination($url, $total_rows, $per_page));

        $dados = [
            'title' => 'Livros',
            'title_page' => 'Listar Livros',
            'message' => 'Listar Livros!',
            'url' => "",
            'books' => $this->book_model->getBooks($per_page, $curr_page),
            'links'      => $this->pagination->create_links(),
            'categories' => $this->bookCategories_model->ListCategories()
        ];
        $this->template->load('ci_panel/template', 'ci_panel/book/home', $dados);
    }

    public function page_create()
    {
        $dados = array(
            'title' => 'Livro',
            'title_page' => 'Novo Livro',
            'message' => 'Novo Livro!',
            'url' => "",
            'categories' => $this->bookCategories_model->ListCategories(),
        );
        $this->template->load('ci_panel/template', 'ci_panel/book/create', $dados);
    }

    public function page_update()
    {
        $dados = array(
            'title' => 'Editar Livro',
            'title_page' => 'Editar Livro',
            'message' => 'Editar Livro!',
            'url' => "",
            'book' => $this->book_model->getBooks($this->uri->segment(4)),
            'categories' => $this->bookCategories_model->ListCategories(),
        );
        $this->template->load('ci_panel/template', 'ci_panel/book/update', $dados);
    }

    public function page_filter()
    {
        $dados = array(
            'title' => 'Confira o resultado de sua pesquisa',
            'title_page' => 'Sua pesquisa retornou <b>'.count($this->session->filter).'</b> resultado(s)',
            'message' => 'Página de Filtro!',
            'url' => "",
            'books' => $this->session->filter,
            'categories' => $this->bookCategories_model->ListCategories()
        );
        $this->template->load('ci_panel/template', 'ci_panel/book/search', $dados);
    }

    public function create()
    {
        $json = [];
        $dados_form = $this->input->post();

        if ($this->form_validation->set_rules('book_title', 'Título', 'trim|required|min_length[5]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('book_author', 'Autor', 'trim|required|min_length[5]|alpha_numeric_spaces')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('book_publishing', 'Editora', 'trim|required|min_length[5]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('book_launch', 'Ano de Lançamento', 'trim|required|numeric|min_length[4]|max_length[4]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('book_amount', 'Quantidade', 'trim|required|numeric|max_length[3]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('book_description', 'Descrição', 'trim|required')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('check[]', 'Categorias', 'trim|required')->run() === false):
            $json["error"] = validation_errors();

        elseif (empty($_FILES["book_img"]["name"])):
            $json["error"] = "Escolha uma imagem!";

        else:

            $url = slug($this->input->post('book_title'));
            if ($this->book_model->getBookTitle($this->input->post('book_title'))->num_rows() >= 1):
                $url .= '-' . $this->book_model->getBookTitle($this->input->post('book_title'))->num_rows();
            endif;

            if (file_exists(FCPATH . '/assets/uploads/book/' . $_FILES['book_img']['name'])):
                $json['error'] = 'A imagem <strong>' . $_FILES['book_img']['name'] . '</strong> já existe!';

            elseif ($this->upload->do_upload('book_img')):
                $dados_upload = $this->upload->data();

                // FAZ O CROP DA IMAGEM
                $imageSize = $this->image_lib->get_image_properties(FCPATH . '/assets/uploads/book/'.$dados_upload['file_name'], TRUE);
                $this->image_lib->initialize(config_crop(FCPATH . 'assets/uploads/book/', $dados_upload['file_name'], 800, 800, $imageSize));

                if(!$this->image_lib->crop()):
                    // DELETA A IMAGEM
                    unlink('./assets/uploads/book/' . $dados_upload['file_name']);
                    $json['error'] = $this->image_lib->display_errors();

                else:
                    $this->image_lib->clear();

                    $dados_form['book_img'] = $url . $dados_upload['file_ext'];
                    $dados_form['book_categories'] = implode(',', $dados_form['check']);
                    $dados_form['book_date'] = date('Y-m-d H:i:s');
                    $dados_form['book_read'] = 0;
                    $dados_form['book_url'] = $url;
                    unset($dados_form['check']);

                    if ($this->book_model->create($dados_form)):

                        // RENOMEIA A IMAGEM DENTRO DA PASTA
                        rename($dados_upload['full_path'], $dados_upload['file_path'] . $url . $dados_upload['file_ext']);

                        $json['success'] = 'Cadastro realizado com sucesso!';
                        $json['redirect'] = '../livros';

                    else:
                        // DELETA A IMAGEM EM CASO DE ERRO
                        unlink($dados_upload['full_path']);
                        $json['error'] = 'Erro ao efetuar o cadastro, entre em contato com o suporte!';

                    endif;
                endif;

            else:
                $json['error'] = $this->upload->display_errors();

            endif;

        endif;

        echo json_encode($json);
    }

    public function update()
    {
        $json = [];
        $dados_form = $this->input->post();

        $id = $this->book_model->getBookId($dados_form['book_id']);
        $book = $this->book_model->getBookTitle($dados_form['book_title'])->row();
        $url = $this->book_model->getBookUrl($dados_form['book_title'], $dados_form['book_id']);

        if ($book && ($book->book_id != $dados_form['book_id'])):
            $json["error"] = 'O livro <strong>' . $dados_form['book_title'] . '</strong> já existe!';

        elseif ($this->form_validation->set_rules('book_title', 'Título', 'trim|required|min_length[5]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('book_author', 'Autor', 'trim|required|min_length[5]|alpha_numeric_spaces')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('book_publishing', 'Editora', 'trim|required|min_length[5]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('book_launch', 'Ano de Lançamento', 'trim|required|numeric|min_length[4]|max_length[4]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('book_amount', 'Quantidade', 'trim|required|max_length[3]|numeric')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('book_description', 'Descrição', 'trim|required')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('check[]', 'Categorias', 'trim|required')->run() === false):
            $json["error"] = validation_errors();

		elseif (empty($_FILES["book_img"]["name"])):
			// PEGA IMAGEM E SEPARA O NOME E A EXTENSAO
            list($txt, $ext) = explode('.', $id['book_img']);
            $img = $url . '.' . $ext;

            $dados_form['book_img'] = $img;
            $dados_form['book_categories'] = implode(',', $dados_form['check']);
            $dados_form['book_date'] = date('Y-m-d H:i:s');
            $dados_form['book_read'] = 0;
            $dados_form['book_url'] = $url;
            unset($dados_form['check']);

            if ($this->book_model->update($dados_form)):
                // RENOMEIA A IMAGEM DENTRO DA PASTA
                rename('./assets/uploads/book/' . $id['book_img'], './assets/uploads/book/' . $img);

                $json['success'] = 'Registro atualizado com sucesso!';
                $json['redirect'] = '../../livros';

            else:
                $json['error'] = 'Erro ao atualizar, entre em contato com o suporte!';

            endif;

        else:

            if (file_exists(FCPATH . 'assets/uploads/book/' . $_FILES['book_img']['name'])):
                $json['error'] = 'A imagem <strong>' . $_FILES['book_img']['name'] . '</strong> já existe!';

            // UPLOAD DE IMAGEM
            elseif ($this->upload->do_upload('book_img')):
                $dados_upload = $this->upload->data();

                // FAZ O CROP DA IMAGEM
                $imageSize = $this->image_lib->get_image_properties(FCPATH . '/assets/uploads/book/'.$dados_upload['file_name'], TRUE);                
                $this->image_lib->initialize(config_crop(FCPATH . 'assets/uploads/book/', $dados_upload['file_name'], 800, 800, $imageSize));

                if(!$this->image_lib->crop()):
                    // DELETA A IMAGEM
                    unlink('./assets/uploads/book/' . $dados_upload['file_name']);
                    $json['error'] = $this->image_lib->display_errors();

                else:
                    $this->image_lib->clear();
                    if(file_exists(FCPATH . '/assets/uploads/book/' . $id['book_img'])):
                        // DELETA A IMAGEM ANTIGA
                        unlink('./assets/uploads/book/' . $id['book_img']);
                    endif;

                    $dados_form['book_img'] = $url . $dados_upload['file_ext'];
                    $dados_form['book_categories'] = implode(',', $dados_form['check']);
                    $dados_form['book_date'] = date('Y-m-d H:i:s');
                    $dados_form['book_read'] = 0;
                    $dados_form['book_url'] = $url;
                    unset($dados_form['check']);

                    if ($this->book_model->update($dados_form)):
                        
                        // RENOMEIA A IMAGEM DENTRO DA PASTA
                        rename($dados_upload['full_path'], $dados_upload['file_path'] . $url . $dados_upload['file_ext']);                    

                        $json['success'] = 'Registro atualizado com sucesso!';
                        $json['redirect'] = '../../livros';

                    else:
                        // DELETA A IMAGEM EM CASO DE ERRO
                        unlink($dados_upload['full_path']);
                        $this->book_model->updateImg($dados_form['clt_id']);
                        $json['error'] = 'Erro ao atualizar, entre em contato com o suporte!';

                    endif;
                endif;

            else:
                $json['error'] = $this->upload->display_errors();

            endif;

        endif;

        echo json_encode($json);
    }

    public function delete()
    {
        $this->book_model->delete();
    }

    public function filter()
    {        
        $this->book_model->search();
    }
}
