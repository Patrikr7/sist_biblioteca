<div class="container py-5">
	<h3 class="mb-4 text-center">Novo Livro</h3>

	<?php echo form_open_multipart('painel/livros/create', 'class="form-horizontal" id="form"'); ?>
	<div class="row">
		<div class="col-md-8">
			<div class="card border-secondary">
				<div class="card-body">
					<div class="row">
						<div class="col-md-12 form-group">
							<label class="control-label">Título *</label>
							<input type="text" class="form-control" id="book_title" name="book_title" minlenght="5">
						</div>
						<div class="col-md-12 form-group">
							<label class="control-label">Autor *</label>
							<input type="text" class="form-control" id="book_author" name="book_author">
						</div>
						<div class="col-md-12 form-group">
							<label class="control-label">Editora *</label>
							<input type="text" class="form-control" id="book_publishing" name="book_publishing">
						</div>
						<div class="col-md-6 form-group">
							<label class="control-label">Ano de lançamento *</label>
							<input type="text" class="form-control" id="book_launch" name="book_launch" placeholder="____" maxlength="4">
						</div>
						<div class="col-md-6 form-group">
							<label class="control-label">Quantidade *</label>
							<input type="number" class="form-control" id="book_amount" name="book_amount" maxlength="3">
						</div>
						<div class="col-md-12 form-group">
							<label class="control-label">Descrição</label>
							<textarea class="form-control tiny_content" id="book_description" name="book_description" rows="8"></textarea>
						</div>
						<div class="form-group col-md-12 mb-0">
							<button type="submit" class="btn btn-success btn-sm">Cadastrar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card border-secondary">
				<figure class="text-center">
					<img class="img-fluid" id="previewing" src="<?php echo base_url('assets/img/book.png'); ?>">
				</figure>
				<div class="card-body">
					<div class="form-group mb-0">
						<label class="control-label">IMAGEM (800X800PX, JPG OU PNG):</label>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="img" name="book_img">
								<label class="custom-file-label" for="img">Procurar imagem</label>
							</div>
						</div>
					</div>
					<div class="col-md-12 form-group mb-0">
                        <div class="dash_group_categories">
                            <label class="control-label">Categorias *</label>
                            <?php
                                $this->load->view('ci_panel/book/categories_check', $data = [
                                    'itens' => $categories, 
                                    'level' => 0,
                                    'checked' => null
                                ]);
                            ?>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
	</form>
</div>