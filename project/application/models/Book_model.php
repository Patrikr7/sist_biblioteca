<?php

class Book_model extends CI_Model
{
    protected $table = 'tb_books';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('bookLeased_model');
    }

    private $Limit;

    public function getBooks($uri = false)
    {
        if ($uri === false):
            $query = $this->db->get($this->table);
            return $query->result_array();
        else:
            $query = $this->db->get_where($this->table, array('book_url' => $uri));
            return $query->row();
        endif;
    }

    //BUSCA LIVRO PELO TITULO
    public function getBookTitle($title)
    {
        return $this->db->get_where($this->table, array('book_title' => $title));
    }

    //BUSCA LIVRO PELO ID
    public function getBookId($id)
    {
        return $this->db->get_where($this->table, array('book_id' => $id))->row_array();
    }

    //CONFIGURA A URL
    public function getBookUrl($title, $id)
    {
        $url = slug($title);
        $array = [
            'book_url' => $url,
            'book_id !=' => $id,
        ];

        $query = $this->db->where($array)->get($this->table)->num_rows();

        if ($query > 0):
            return $url . '-' . $id;
        else:
            return $url;
        endif;
    }

    public function getLimitBooks($limit, $read = false)
    {
        $this->Limit = (int) $limit;

        if ($read):
            $this->db->select('*')
                ->where('book_read >', '0')
                ->order_by('book_read', 'DESC')
                ->limit($this->Limit)
                ->from($this->table);
            $query = $this->db->get();

            return $query->result_array();
        else:
            $this->db->select('*')
                ->order_by('book_date', 'DESC')
                ->limit($this->Limit)
                ->from($this->table);
            $query = $this->db->get();

            return $query->result_array();
        endif;
    }

    // LIVROS DISPONIVEIS
    public function getBooksAvailable()
    {
        return $this->db->select('*')
            ->where('book_amount >', '0')
            ->where('book_status', '1')
            ->order_by('book_date', 'DESC')
            ->from($this->table)
            ->get()
            ->result_array();
    }

    public function get_total()
    {
        return $this->db->count_all($this->table);
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
        $this->db->where('book_id', $data['book_id']);
        unset($data['book_id']);
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
        $this->db->set('book_img', null);
        $this->db->where('book_id', $id);
        $this->db->update($this->table);
    }

    public function delete()
    {
        $json = [];
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $book = $this->getBookId($dados['del_id']);

        if (!$book):
            $json['error'] = 'Oppss! você tentou remover um livro que não existe!';
            $json['type'] = "warning";

        elseif ($this->bookLeased_model->getBookId($dados['del_id'])):
            $json['error'] = 'Oppss! você tentou remover um livro que está em uso ou já foi reservado!';
            $json['type'] = "warning";

        else:
            $this->db->delete($this->table, array('book_id' => $dados['del_id']));
            if ($this->db->affected_rows()):
                unlink('./assets/uploads/book/' . $book['book_img']);
                $json['success'] = "Cliente deletado com sucesso!";
            else:
                $json['error'] = "Erro ao deletar o livro, entre em contato com suporte!";
                $json['type'] = 'warning';
            endif;
        endif;

        echo json_encode($json);
    }

    // SOMA +1 NA COLUNA book_amount
    public function setBookMoreAmount($id)
    {
        $this->db->set('book_amount', 'book_amount + 1', false);
        $this->db->where('book_id', $id);
        $this->db->update($this->table);
    }

    // SOMA +1 NA COLUNA book_read e -1 NA COLUNA book_amount
    public function setBookReadAmount($id)
    {
        $this->db->set('book_amount', 'book_amount - 1', false);
        $this->db->set('book_read', 'book_read + 1', false);
        $this->db->where('book_id', $id);
        $this->db->update($this->table);
    }

    public function search()
    {
        $dados_form = $this->input->post();

        $Where = array('1=1');
        if (!empty($dados_form["book_title"])):
            $Where[] = "(book_title LIKE '%{$dados_form["book_title"]}%')";
        endif;
        if (!empty($dados_form["book_author"])):
            $Where[] = "(book_author LIKE '%{$dados_form["book_author"]}%')";
        endif;
        if (!empty($dados_form["book_publishing"])):
            $Where[] = "(book_publishing LIKE '%{$dados_form["book_publishing"]}%')";
        endif;
        if (!empty($dados_form["book_launch"])):
            $Where[] = "(book_launch LIKE '%{$dados_form['book_launch']}%')";
        endif;
        if (!empty($dados_form["book_categories"])):
            $Where[] = "(CONCAT(',', book_categories, ',') LIKE '%,{$dados_form["book_categories"]},%')";
        endif;

        $_SESSION['filter'] = $this->db->select('*')
            ->where(implode(' AND ', $Where))
            ->order_by('book_title', 'ASC')
            ->from($this->table)
            ->get()
            ->result_array();

        $json = [];
        $json['success'] = 'success';
        $json['redirect'] = 'painel/livros/pesquisa';

        echo json_encode($json);
    }
}
