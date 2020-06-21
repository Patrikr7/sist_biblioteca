<div class="container py-5">
    <h3 class="mb-4">Atualizar categoria</h3>
    <?php 
	if($msg = get_msg()):
		echo $msg;
	endif; 
	?>
    <?php echo form_open('painel/categorias/update', 'class="form-horizontal" id="form"'); ?>
		<div class="row">
			<div class="form-group col-md-6">
				<label for="">Nome*</label>
				<input type="text" class="form-control" name="cat_title" id="cat_title"  value="<?php echo $categorie['cat_title']; ?>">
				<input type="hidden" class="form-control" name="cat_id" id="cat_id"  value="<?php echo $categorie['cat_id']; ?>">
			</div>
			<div class="form-group col-md-6">
				<label for="">Categoria Pai*</label>
				<select type="text" class="form-control" name="cat_parent" id="cat_parent">
				<option value="">-Selecione uma Categoria-</option>   
				<?php 
					$this->load->view('ci_panel/book-categories/categories_option', $data = [
						'itens' => $categories, 
                        'level' => 0,
                        "selected" => $categorie['cat_parent']
                    ]);
				?>
            </select>
			</div>
			<div class="form-group col-md-12">
				<button type="submit" class="btn btn-info btn-sm">Atualizar</button>
			</div>
		</div>
	</form>
</div>