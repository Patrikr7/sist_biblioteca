<?php

class Client_model extends CI_Model
{
    protected $table = 'tb_client';

    public function __construct()
    {
        parent::__construct();
    }

    public function getClients($uri = false)
    {
        if ($uri === false):
            $query = $this->db->get($this->table);
            return $query->result_array();
        else:
            $query = $this->db->get_where($this->table, array('clt_url' => $uri));
            return $query->row();
        endif;
    }

    //BUSCA CLIENTE PELO NOME
    public function getClientName($name)
    {
        return $this->db->get_where($this->table, array('clt_name' => $name));
    }

    //BUSCA CLIENTE PELO ID
    public function getClientId($id)
    {
        return $this->db->get_where($this->table, array('clt_id' => $id))->row_array();
    }

    //BUSCA CLIENTE PELO ID NA TABELA tb_book_leased 'TABELA DE LIVROS ALUGADOS'
    public function getClientLeasedId($id)
    {
        return $this->db->get_where('tb_book_leased', array('id_client' => $id))->row_array();
    }

    //BUSCA CLIENTE PELO CPF
    public function getClientCPF($cpf)
    {
        return $this->db->get_where($this->table, array('clt_cpf' => $cpf))->row_array();
    }

    //BUSCA CLIENTE PELO RG
    public function getClientRG($rg)
    {
        return $this->db->get_where($this->table, array('clt_rg' => $rg))->row_array();
    }

    //BUSCA CLIENTE PELO EMAIL
    public function getClientEmail($email)
    {
        return $this->db->get_where($this->table, array('clt_email' => $email))->row_array();
    }

    //CONFIGURA A URL
    public function getClientUrl($name, $id)
    {
        $url = slug($name);
        $array = [
            'clt_url' => $url,
            'clt_id !=' => $id,
        ];

        $query = $this->db->where($array)->get($this->table)->num_rows();

        if ($query > 0):
            return $url . '-' . $id;
        else:
            return $url;
        endif;
    }

    // CLIENTES ATIVOS
    public function getClientActive()
    {
        return $this->db->select('*')
            ->where('clt_status', '1')
            ->order_by('clt_name', 'ASC')
            ->from($this->table)
            ->get()
            ->result_array();
    }

    public function create($data)
    {
        $this->db->insert($this->table, $data);

        if ($this->db->insert_id()):
            return true;
        else:
            return false;
        endif;
    }

    public function update($data)
    {        
        $this->db->where('clt_id', $data['clt_id']);
        unset($data['clt_id']);
        $this->db->update($this->table, $data);

        if ($this->db->affected_rows() === 0 || $this->db->affected_rows() > 0):
            return true;

        else:
            return false;
        endif;
    }

    // CASO DE ERRO AO ATUALIZAR REGISTRO, SETA A IMAGEM COMO NULL NO BD
    public function updateImg($id)
    {        
        $this->db->set('clt_img', NULL);
        $this->db->where('clt_id', $id);
        $this->db->update($this->table);
    }

    public function delete()
    {
        $json = [];
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $client = $this->getClientId($dados['del_id']);

        if (!$this->getClientId($dados['del_id'])):
            $json['error'] = 'Oppss! você tentou remover um cliente que não existe!';
            $json['type'] = "warning";

        elseif($this->getClientLeasedId($dados['del_id'])):
            $json['error'] = 'Oppss! você tentou remover um cliente que se encontra na tabela de livros alugados. Você só poderá deixar o cliente inativo!';
            $json['type'] = "warning";

        else:
            $this->db->delete($this->table, array('clt_id' => $dados['del_id']));
            if ($this->db->affected_rows()):
                if (!empty($client['clt_img'])):
                    unlink('./assets/uploads/client/' . $client['clt_img']);
                endif;
                $json['success'] = "Cliente deletado com sucesso!";
            else:
                $json['error'] = "Erro ao deletar a cliente, entre em contato com suporte!";
                $json['type'] = 'warning';
            endif;
        endif;

        echo json_encode($json);
    }

    public function status($status, $id)
    {        
        $this->db->set('clt_status', $status['clt_status']);
        $this->db->where('clt_id', $id);
        $this->db->update($this->table);

        if ($this->db->affected_rows() === 0 || $this->db->affected_rows() > 0):
            return true;

        else:
            return false;
        endif;
    }
}
