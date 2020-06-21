<?php
//extract($data);
foreach ($itens as $item) :
    ?>
    <tr>
        <td>
            <?php
            if (empty($item["cat_parent"])) :
                echo "<i class=\"fas fa-circle\"></i> ";
            endif;
            
            for ($i = 0; $i < $level; $i++) :
                echo "<i class=\"fas fa-angle-double-right\"></i> ";
            endfor;
            echo $item["cat_title"];
            ?>
        </td>
        <td  class="with-btn-group">
            <a class="btn btn-sm btn-primary width-60 m-r-2" href="<?php echo base_url('painel/categorias/update/'.$item["cat_url"]); ?>">Editar</a>

            <span class="btn btn-sm btn-danger width-60 button_action" rel="Deseja excluir?" callback="categorias" callback_action='delete' id="<?= $item["cat_id"] ?>" title="Excluir Categoria">Excluir</span>
        </td>
    </tr>
    <?php
    if (count($item["subs"]) > 0) :
        $this->load->view("ci_panel/book-categories/categories_item", $data = [
            "itens" => $item["subs"],
            "level" => $level + 1
        ]);
    endif;
endforeach; ?>