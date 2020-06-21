<?php

class BookLeased_model extends CI_Model
{
    protected $table = 'tb_book_leased';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('book_model');
    }

    public function getBookLeaseds()
    {
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    //BUSCA RESERVA PELO ID
    public function getBookLeasedsId($id)
    {
        return $this->db->get_where($this->table, array('id' => $id))->row_array();
    }

    //BUSCA LIVRO PELO ID
    public function getBookId($id)
    {
        return $this->db->get_where($this->table, array('id_book' => $id))->row_array();
    }

    //BUSCA CLIENTE PELO ID
    public function getClientLeasedsId($id)
    {
        $this->db->select('*')
            ->from($this->table)
            ->where('(date_returned IS NULL) AND id_client = ' . $id);
        return $this->db->get()->result_array();
    }

    public function getBookLeasedsJoin()
    {
        $this->db->select('c.clt_id, c.clt_name, b.*, l.*')
            ->from($this->table.' AS l')
            ->where('leased = 1 AND (date_returned IS NULL)')
            ->join('tb_client AS c', 'c.clt_id  = l.id_client', 'inner')
            ->join('tb_books AS b', 'b.book_id  = l.id_book', 'inner')
            ->order_by('l.date_end', 'ASC');
        return $this->db->get()->result_array();
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

    public function update()
    {
        $json = [];
        $dados = $this->input->post();
        $Leased = $this->getBookLeasedsId($dados['del_id']);
        $id = $dados['del_id'];
        unset($dados['callback'], $dados['callback_action'], $dados['del_id']);

        if (empty($Leased)):
            $json['error'] = 'Oppss! Você tentou remover uma reserva que não existe!';
            $json['warning'] = 'warning';

        else:
            $dados['leased'] = 0;
            $dados['date_returned'] = date('Y-m-d H:i:s');

            $this->db->where('id', $id);
            $this->db->update($this->table, $dados);

            if ($this->db->affected_rows()):
                $json['success'] = 'Livro devolvido com sucesso!';

                $this->book_model->setBookMoreAmount($Leased['id_book']);

                $json['redirect'] = '../livros-locado';

            else:
                return false;
            endif;

        endif;

        echo json_encode($json);
    }
}
