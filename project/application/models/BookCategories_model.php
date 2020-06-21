<?php

class BookCategories_model extends CI_Model
{
    protected $table = 'tb_book_categories';

    public function __construct()
    {
        parent::__construct();
    }

    public function getBookCategories($uri = false)
    {
        if ($uri === false):
            $query = $this->db->get($this->table);
            return $query->result_array();
        else:
            $query = $this->db->get_where($this->table, array('cat_url' => $uri));
            return $query->row_array();
        endif;
    }

    //BUSCA CATEGORIA PELO TITLE
    public function getCategorieTitle($title)
    {
        return $this->db->get_where($this->table, array('cat_title' => $title));
    }

    //BUSCA CATEGORIA PELO ID
    public function getCategorieId($id)
    {
        return $this->db->get_where($this->table, array('cat_id' => $id))->row_array();
    }

    //BUSCA ID DA CATEGORIA NA COLUNA CAT_PARENT - PARA SABER SE A CATEGORIA ESTÁ SENDO USADO COMO PAI
    public function getCategorieParent($id)
    {
        return $this->db->get_where($this->table, array('cat_parent' => $id))->row_array();
    }

    //BUSCA SE A CATEGORIA ESTÁ CADASTRA EM ALGUM LIVRO
    public function getCategorieBook($id)
    {
        return $this->db->query('SELECT * FROM tb_books WHERE CONCAT(",", book_categories, ",") LIKE "%,' . $id . ',%"')->result_array();
    }

    public function getCategorieUrl($title, $id)
    {
        $url = slug($title);
        $array = [
            'cat_url' => $url,
            'cat_id !=' => $id,
        ];

        $query = $this->db->where($array)->get($this->table)->num_rows();

        if ($query > 0):
            return $url . '-' . $id;
        else:
            return $url;
        endif;
    }

    // LISTAR CATEGORIES
    public function ListCategories()
    {
        $list = array();
        $this->db->select('*')
            ->order_by('cat_parent', 'DESC')
            ->from($this->table);
        $query = $this->db->get()->result_array();

        if ($query):
            foreach ($query as $categorie):
                $categorie["subs"] = array();
                $list[$categorie["cat_id"]] = $categorie;
            endforeach;

            while (self::stillNeed($list)):
                self::organizeCategory($list);
            endwhile;
        endif;

        return $list;
    }

    private function organizeCategory(&$array)
    {
        foreach ($array as $key => $item) {
            if (!empty($item["cat_parent"])):
                $array[$item["cat_parent"]]["subs"][$item["cat_id"]] = $item;
                unset($array[$key]);
                break;
            endif;
        }
    }

    private function stillNeed($array)
    {
        foreach ($array as $item):
            if (!empty($item["cat_parent"])):
                return true;
            endif;
        endforeach;
        return false;
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
        $this->db->where('cat_id', $data['cat_id']);
        unset($data['cat_id']);
        $this->db->update($this->table, $data);
        
        if ($this->db->affected_rows() === 0 || $this->db->affected_rows() > 0):
            return true;
        else:
            return false;
        endif;
    }

    public function deleteCategorie()
    {
        $json = [];
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!$this->getCategorieId($dados['del_id'])):
            $json['error'] = 'Oppss! você tentou remover uma categoria que não existe!';
            $json['type'] = "warning";

        elseif ($this->getCategorieParent($dados['del_id'])):
            $json['error'] = 'Oppss! você tentou remover uma categoria que contém categorias filhas!';
            $json['type'] = "warning";

        elseif ($this->getCategorieBook($dados['del_id'])):
            $json['error'] = 'Oppss! você tentou remover uma categoria que está cadastrada nos livros!';
            $json['type'] = "warning";
            
        else:
            $this->db->delete($this->table, array('cat_id' => $dados['del_id']));
            if ($this->db->affected_rows()):
                $json['success'] = "Categoria deletada com sucesso!";
            else:
                $json['error'] = "Erro ao deletar a categoria, entre em contato com suporte!";
                $json['type'] = 'warning';
            endif;
        endif;

        echo json_encode($json);
    }
}
