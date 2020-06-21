<?php
foreach ($itens as $item) :
    ?>
    <option value="<?= $item["cat_id"] ?>" <?= (isset($selected) && $item["cat_id"] == $selected ? "selected='selected'" : "") ?>>
        <?php
        for ($i = 0; $i < $level; $i++) :
            echo "- ";
        endfor;
        echo $item["cat_title"];
        ?>
    </option>
    
    <?php
    if (count($subs) > 0) :
        $this->load->view("ci_panel/book-categories/categoriesoption", $data = [
            'itens' => $item["subs"], 
            'level' => $level + 1, 
            'selected' => $selected]
        );
    endif;
endforeach; ?>

