<div class="container py-5">
	<h3 class="mb-4 text-center">Cadastrar locação</h3>

	<?php echo form_open_multipart('painel/livros-locado/create', 'class="form-horizontal" id="form"'); ?>
	<div class="row">
		<div class="card border-secondary">
			<div class="card-body">
				<div class="row">
					<div class="form-group col-md-6">
						<label class="control-label">Cliente *</label>
						<select class="form-control" id="id_client" name="id_client">
							<option value="">Selecione um Cliente</option>
							<?php
                            foreach ($client as $c):
                                echo "<option value=\"{$c['clt_id']}\">{$c['clt_name']}</option>";
                            endforeach;
                            ?>
						</select>
					</div>
					<div class="form-group col-md-6">
						<label class="control-label">Livro *</label>
						<select class="form-control" id="id_book" name="id_book">
							<option value="">Selecione um Livro</option>
							<?php
                            foreach ($book as $b):
                                echo "<option value=\"{$b['book_id']}\">{$b['book_title']}</option>";
                            endforeach;
                            ?>
						</select>
					</div>
					<div class="form-group col-md-6">
						<label for="">Data Início*</label>
						<input type="text" class="form-control" name="date_start" id="date_start" value="<?php echo date('d/m/Y'); ?>">
					</div>
					<div class="form-group col-md-6">
						<label for="">Data Entrega*</label>
						<input type="text" class="form-control" name="date_end" id="date_end">
					</div>
					<div class="col-md-12 form-group">
						<label class="control-label">Observação</label>
						<textarea class="form-control" id="description" name="description" rows="8"></textarea>
					</div>
					<div class="form-group col-md-12 mb-0">
						<button type="submit" class="btn btn-success btn-sm">Cadastrar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	</form>
</div>