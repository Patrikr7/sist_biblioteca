<div class="container py-5">
	<h3 class="mb-4 text-center">Cadastro Cliente</h3>
	
	<?php echo form_open_multipart('painel/clientes/create', 'class="form-horizontal" id="form"'); ?>
	<div class="row">
		<div class="col-md-8">
			<div class="card border-secondary">
				<div class="card-body">
					<div class="row">
						<div class="form-group col-md-6">
							<label for="">Nome*</label>
							<input type="text" class="form-control" name="clt_name" id="clt_name">
						</div>
						<div class="form-group col-md-6">
							<label for="">Email*</label>
							<input type="text" class="form-control" name="clt_email" id="clt_email" value="<?php echo set_value('clt_email'); ?>">
						</div>
						<div class="form-group col-md-4">
							<label for="">CPF*</label>
							<input type="text" class="form-control" name="clt_cpf" id="clt_cpf">
						</div>
						<div class="form-group col-md-4">
							<label for="">RG*</label>
							<input type="text" class="form-control" name="clt_rg" id="clt_rg">
						</div>
						<div class="form-group col-md-4">
							<label for="">Dt. Nascimento*</label>
							<input type="text" class="form-control" name="clt_nasc" id="clt_nasc">
						</div>
						<div class="form-group col-md-4">
							<label for="">Tel/Cel*</label>
							<input type="text" class="form-control" name="clt_tel_cel" id="clt_tel_cel">
						</div>
						<div class="form-group col-md-4">
							<label for="">Celular*</label>
							<input type="text" class="form-control" name="clt_cel" id="clt_cel">
						</div>
						<div class="form-group col-md-4">
							<label class="control-label">Gênero *</label>
							<select class="form-control" id="clt_genero" name="clt_genero">
								<option value="">Selecione o Gênero</option>
								<option value="F">Feminino</option>
								<option value="M">Masculino</option>
							</select>
						</div>
						<div class="col-md-3 form-group">
							<label class="control-label">CEP</label>
							<input type="text" class="form-control" id="addr_zipcode" name="addr_zipcode">
						</div>

						<div class="col-md-7 form-group">
							<label class="control-label">Endereço *</label>
							<input type="text" class="form-control" id="addr_street" name="addr_street">
						</div>

						<div class="col-md-2 form-group">
							<label class="control-label">Número *</label>
							<input type="text" class="form-control" id="addr_number" name="addr_number">
						</div>

						<div class="col-md-12 form-group">
							<label class="control-label">Complemento *</label>
							<input type="text" class="form-control" id="addr_comp" name="addr_comp">
						</div>

						<div class="col-md-6 form-group">
							<label class="control-label">Bairro *</label>
							<input type="text" class="form-control" id="addr_district" name="addr_district">
						</div>

						<div class="col-md-6 form-group">
							<label class="control-label">Cidade *</label>
							<input type="text" class="form-control" id="addr_city" name="addr_city">
						</div>

						<div class="col-md-6 form-group">
							<label class="control-label">Estado *</label>
							<input type="text" class="form-control" id="addr_state" name="addr_state">
						</div>

						<div class="col-md-6 form-group">
							<label class="control-label">País *</label>
							<input type="text" class="form-control" id="addr_country" name="addr_country" value="Brasil">
						</div>

						<div class="col-md-12 form-group">
							<label class="control-label">Observação</label>
							<textarea class="form-control" id="clt_obs" name="clt_obs" rows="8"></textarea>
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
				<img class="img-fluid" id="previewing" src="<?php echo base_url('assets/img/avatar.jpg') ?>">
				<div class="card-body">
					<div class="form-group mb-0">
						<label class="control-label">FOTO (500X500PX, JPG OU PNG):</label>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="img" name="clt_img">
								<label class="custom-file-label" for="img">Procurar foto</label>
							</div>
						</div>
					</div>
					<div class="form-group mb-0">
						<label class="control-label">Status *</label>
						<select class="form-control" id="clt_status" name="clt_status">
							<option value="">- Selecione o Status -</option>
							<?php
                            foreach ($status as $Status):
                                echo "<option value=\"{$Status['st_id']}\">{$Status['st_title']}</option>";
                            endforeach;
                            ?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	</form>
</div>