<article>
	<header>
		<h4>Pesquisar livro:</h4>
	</header>
	<?php echo form_open_multipart('painel/livros/filter', 'class="form-horizontal border-bottom-1 mb-3" id="form_filter"'); ?>
		<div class="row">
			<div class="col-md-4 mb-3">
				<input type="text" class="form-control" id="book_title" name="book_title" placeholder="Título">
			</div>
			<div class="col-md-4 mb-3">
				<input type="text" class="form-control" id="book_author" name="book_author" placeholder="Autor">
			</div>
			<div class="col-md-4 mb-3">
				<input type="text" class="form-control" id="book_publishing" name="book_publishing" placeholder="Editora">
			</div>
			<div class="col-md-4 mb-3">
				<input type="text" class="form-control" id="book_launch" name="book_launch" placeholder="Ano de lançamento" maxlength="4">
			</div>
			<div class="col-md-4 form-group mb-3">
				<select class="form-control" id="book_categories" name="book_categories">
					<option value="0">-- Selecione uma Categoria --</option>
					<?php
					$this->load->view('ci_panel/book-categories/categories_option', $data = [
						'itens' => $categories, 
						'level' => 0
					]);
					?>
				</select>
			</div>
			<div class="col-md-4 form-group">
				<button type="submit" class="btn btn-success w-100">Pesquisar <i class="fa fa-spinner fa-spin fa-fw form_load" style="display:none;"></i></button>
			</div>
		</div>
	</form>
</article>