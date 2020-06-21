<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['client_model', 'bookLeased_model']);
        $this->load->library('upload', config_upload('./assets/uploads/', 'jpg|png', 1500, 'client'));
    }

    public function index()
    {
        $dados = [
            'title' => 'Clientes',
            'title_page' => 'Listar Clientes',
            'message' => 'Listar Clientes!',
            'url' => "",
            'clients' => $this->client_model->getClients(),
        ];
        $this->template->load('ci_panel/template', 'ci_panel/client/home', $dados);
    }

    public function page_create()
    {
        $dados = array(
            'title' => 'Novo Cliente',
            'title_page' => 'Novo Cliente',
            'message' => 'Novo Cliente!',
            'url' => "",
            'status' => $this->db->get('tb_status')->result_array(),
        );

        $this->template->load('ci_panel/template', 'ci_panel/client/create', $dados);
    }

    public function page_update()
    {
        $dados = array(
            'title' => 'Atualizar Cliente',
            'title_page' => 'Atualizar Cliente',
            'message' => 'Atualizar Cliente!',
            'url' => "",
            'client' => $this->client_model->getClients($this->uri->segment(4)),
            'status' => $this->db->get('tb_status')->result_array(),
        );
        $this->template->load('ci_panel/template', 'ci_panel/client/update', $dados);
    }

    public function create()
    {
        $json = [];
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ($this->form_validation->set_rules('clt_name', 'Nome', 'trim|required|min_length[5]|alpha_numeric_spaces')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('clt_email', 'Email', 'trim|required|valid_email|is_unique[tb_client.clt_email]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('clt_cpf', 'CPF', 'trim|required|is_unique[tb_client.clt_cpf]|callback_validator_cpf')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('clt_rg', 'RG', 'trim|required|is_unique[tb_client.clt_rg]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('clt_nasc', 'Data de Nascimento', 'trim|required|regex_match[/^([0-9]{1,2})\\/([0-9]{1,2})\\/([0-9]{4})$/]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('clt_tel_cel', 'Tel/Cel', 'trim|required')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('clt_cel', 'Celular', 'trim|required')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('clt_genero', 'Gênero', 'trim|required')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('addr_zipcode', 'CEP', 'trim|required|regex_match[/^[0-9]{5}-[0-9]{3}$/]|min_length[8]|max_length[10]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('addr_street', 'Endereço', 'trim|required|min_length[5]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('addr_number', 'Número', 'trim|required|alpha_numeric_spaces')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('addr_comp', 'Complemento', 'trim|required|max_length[10]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('addr_district', 'Bairro', 'trim|required|min_length[3]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('addr_city', 'Cidade', 'trim|required|min_length[3]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('addr_state', 'Estado', 'trim|required|min_length[2]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('addr_country', 'País', 'trim|required')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('clt_status', 'Status', 'trim|required')->run() === false):
            $json["error"] = validation_errors();

        elseif (empty($_FILES["clt_img"]["name"])):
            $json["error"] = "Escolha uma foto!";

        else:
            $url = slug($this->input->post('clt_name'));
            if ($this->client_model->getClientName($this->input->post('clt_name'))->num_rows() >= 1):
                $url .= '-' . $this->client_model->getClientName($this->input->post('clt_name'))->num_rows();
            endif;

            if (file_exists(FCPATH . '/assets/uploads/client/' . $_FILES['clt_img']['name'])):
                $json['error'] = 'A imagem <strong>' . $_FILES['clt_img']['name'] . '</strong> já existe!';

            elseif ($this->upload->do_upload('clt_img')):
                $dados_upload = $this->upload->data();

                $dados_form = $this->input->post();
                $dados_form['clt_img'] = $url . $dados_upload['file_ext'];
                $dados_form['clt_nasc'] = date('Y-m-d', strtotime(implode('-', explode('/', $dados['clt_nasc']))));
                $dados_form['clt_url'] = $url;

                if ($this->client_model->create($dados_form)):
                    // RENOMEIA A IMAGEM DENTRO DA PASTA
                    rename($dados_upload['full_path'], $dados_upload['file_path'] . $url . $dados_upload['file_ext']);

                    $json['success'] = 'Cadastro realizado com sucesso!';
                    $json['redirect'] = '../clientes';

                else:
                    // DELETA A IMAGEM EM CASO DE ERRO
                    unlink($dados_upload['full_path']);
                    $json['error'] = 'Erro ao efetuar o cadastro, entre em contato com o suporte!';

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
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $id = $this->client_model->getClientId($dados['clt_id']);
        $email = $this->client_model->getClientEmail($dados['clt_email']);
        $cpf = $this->client_model->getClientCPF($dados['clt_cpf']);
        $rg = $this->client_model->getClientRG($dados['clt_rg']);
        $url = $this->client_model->getClientUrl($dados['clt_name'], $dados['clt_id']);

        if ($this->form_validation->set_rules('clt_name', 'Nome', 'trim|required|min_length[5]|alpha_numeric_spaces')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('clt_email', 'Email', 'trim|required|valid_email')->run() === false):
            $json["error"] = validation_errors();

        elseif ($email && ($dados['clt_id'] !== $email['clt_id'])):
            $json["error"] = 'O email <strong>' . $dados['clt_email'] . '</strong> já existe';

        elseif ($this->form_validation->set_rules('clt_cpf', 'CPF', 'trim|required|callback_validator_cpf')->run() === false):
            $json["error"] = validation_errors();

        elseif ($cpf && ($dados['clt_id'] !== $cpf['clt_id'])):
            $json["error"] = 'O CPF <strong>' . $dados['clt_cpf'] . '</strong> já existe';

        elseif ($this->form_validation->set_rules('clt_rg', 'RG', 'trim|required')->run() === false):
            $json["error"] = validation_errors();

        elseif ($rg && ($dados['clt_id'] !== $rg['clt_id'])):
            $json["error"] = 'O RG <strong>' . $dados['clt_rg'] . '</strong> já existe';

        elseif ($this->form_validation->set_rules('clt_nasc', 'Data de Nascimento', 'trim|required|regex_match[/^([0-9]{1,2})\\/([0-9]{1,2})\\/([0-9]{4})$/]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('clt_tel_cel', 'Tel/Cel', 'trim|required')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('clt_cel', 'Celular', 'trim|required')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('clt_genero', 'Gênero', 'trim|required')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('addr_zipcode', 'CEP', 'trim|required|regex_match[/^[0-9]{5}-[0-9]{3}$/]|min_length[8]|max_length[10]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('addr_street', 'Endereço', 'trim|required|min_length[5]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('addr_number', 'Número', 'trim|required|alpha_numeric_spaces')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('addr_comp', 'Complemento', 'trim|required|max_length[10]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('addr_district', 'Bairro', 'trim|required|min_length[3]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('addr_city', 'Cidade', 'trim|required|min_length[3]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('addr_state', 'Estado', 'trim|required|min_length[2]')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('addr_country', 'País', 'trim|required')->run() === false):
            $json["error"] = validation_errors();

        elseif ($this->form_validation->set_rules('clt_status', 'Status', 'trim|required')->run() === false):
            $json["error"] = validation_errors();

        elseif (empty($_FILES["clt_img"]["name"])):

            if (!empty($id['clt_img'])):
                list($txt, $ext) = explode('.', $id['clt_img']);
                $img = $url . '.' . $ext;
            else:
                $img = null;
            endif;

            $dados_form = $this->input->post();
            $dados_form['clt_img'] = $img;
            $dados_form['clt_nasc'] = date('Y-m-d', strtotime(implode('-', explode('/', $dados['clt_nasc']))));
            $dados_form['clt_url'] = $url;

            if ($this->client_model->update($dados_form)):

                // RENOMEIA A IMAGEM DENTRO DA PASTA
                if (!empty($id['clt_img'])):
                    rename('./assets/uploads/client/' . $id['clt_img'], './assets/uploads/client/' . $img);
                endif;

                $json['success'] = 'Cadastro atualizado com sucesso!';
                $json['redirect'] = '../../clientes';

            else:
                $json['error'] = 'Erro ao efetuar o cadastro, entre em contato com o suporte!';

            endif;

        else:

            if (file_exists(FCPATH . '/assets/uploads/client/' . $_FILES['clt_img']['name'])):
                $json['error'] = 'A imagem <strong>' . $_FILES['clt_img']['name'] . '</strong> já existe!';

            elseif ($this->upload->do_upload('clt_img')):
                $dados_upload = $this->upload->data();

                // DELETA A IMAGEM ANTIGA
                unlink('./assets/uploads/client/' . $id['clt_img']);

                $dados_form = $this->input->post();
                $dados_form['clt_img'] = $url . $dados_upload['file_ext'];
                $dados_form['clt_nasc'] = date('Y-m-d', strtotime(implode('-', explode('/', $dados['clt_nasc']))));
                $dados_form['clt_url'] = $url;

                if ($this->client_model->update($dados_form)):
                    // RENOMEIA A IMAGEM DENTRO DA PASTA
                    rename($dados_upload['full_path'], $dados_upload['file_path'] . $url . $dados_upload['file_ext']);

                    $json['success'] = 'Cadastro atualizado com sucesso!';
                    $json['redirect'] = '../../clientes';

                else:
                    // DELETA A IMAGEM EM CASO DE ERRO
                    unlink($dados_upload['full_path']);
                    $this->client_model->updateImg($dados['clt_id']);
                    $json['error'] = 'Erro ao atualizar registro, entre em contato com o suporte!';

                endif;

            else:
                $json['error'] = $this->upload->display_errors();

            endif;

        endif;

        echo json_encode($json);
    }

    // CALLBACK VALIDA CPF
    public function validator_cpf($cpf)
    {
        if (validateCPF($cpf)):
            return true;
        else:
            $this->form_validation->set_message('validator_cpf', 'Campo CPF inválido!');
            return false;
        endif;
    }

    public function delete()
    {
        $this->client_model->delete();
    }

    public function status()
    {
        $json = array();
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        //var_dump($this->bookLeased_model->getClientLeasedsId($dados['del_id'])); die;
        $Client = $this->client_model->getClientId($dados['del_id']);

        $id = $dados['del_id'];
        unset($dados['callback'], $dados['callback_action'], $dados['del_id']);        

        if (empty($Client)) {
            $json['error'] = 'Oppsss, você tentou ativar ou inativar um cliente que não existe!';
            $json['type'] = 'warning';

        } elseif($this->bookLeased_model->getClientLeasedsId($id) && $Client['clt_status'] == 1){
            $json['error'] = 'Oppsss, você tentou inativar um cliente que contém livros alugados!';
            $json['type'] = 'warning';

        } elseif ($Client['clt_status'] == 1) {
            $dados['clt_status'] = 2;

            if ($this->client_model->status($dados, $id)):
                $json['success'] = 'Cliente inativado com sucesso!';
                $json['redirect'] = '../cliente';
            endif;

        } else {
            $dados['clt_status'] = 1;

            if ($this->client_model->status($dados, $id)):
                $json['success'] = 'Cliente ativado com sucesso!';
                $json['redirect'] = '../cliente';
            endif;

        }

        echo json_encode($json);
    }

}
