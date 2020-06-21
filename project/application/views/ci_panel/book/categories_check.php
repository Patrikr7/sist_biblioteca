<?php
foreach ($itens as $item) :
    ?>
    <div class="dash_categories_item">
        <div class="checkbox checkbox-css">
            <input type="checkbox" name="check[]" id="<?= $item["cat_title"] ?>-<?= $item["cat_id"] ?>" value="<?= $item["cat_id"] ?>" <?= (isset($checked) && (in_array($item["cat_id"], explode(',', $checked))) ? "checked='checked'" : '') ?> />
            <label for="<?= $item["cat_title"] ?>-<?= $item["cat_id"] ?>">
                <?php
                for ($i = 0; $i < $level; $i++) :
                    echo "-- ";
                endfor;
                echo $item["cat_title"];
                ?>
            </label>
        </div>
    </div>

    <?php
    if (count($item["subs"]) > 0) :
        $this->load->view("ci_panel/book/categories_check", $data = [
            "itens" => $item["subs"],
            "level" => $level + 1,
            "checked" => $checked
        ]);
    endif;
endforeach; ?>