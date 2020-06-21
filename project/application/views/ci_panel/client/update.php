<div class="container py-5">
	<h3 class="mb-4 text-center">Atualizar Cliente</h3>
	<?php
if ($msg = get_msg()):
    echo $msg;
endif;
?>
	<?php echo form_open_multipart('painel/clientes/update', 'class="form-horizontal" id="form"'); ?>
	<div class="row">
		<div class="col-md-8">
			<div class="card border-secondary">
				<div class="card-body">
					<div class="row">
						<div class="form-group col-md-6">
							<label for="">Nome*</label>
							<input type="text" class="form-control" name="clt_name" id="clt_name" value="<?php echo $client->clt_name; ?>">
							<input type="hidden" class="form-control" name="clt_id" id="clt_id" value="<?php echo $client->clt_id; ?>">
						</div>
						<div class="form-group col-md-6">
							<label for="">Email*</label>
							<input type="text" class="form-control" name="clt_email" id="clt_email" value="<?php echo $client->clt_email; ?>">
						</div>
						<div class="form-group col-md-4">
							<label for="">CPF*</label>
							<input type="text" class="form-control" name="clt_cpf" id="clt_cpf" value="<?php echo $client->clt_cpf; ?>">
						</div>
						<div class="form-group col-md-4">
							<label for="">RG*</label>
							<input type="text" class="form-control" name="clt_rg" id="clt_rg" value="<?php echo $client->clt_rg; ?>">
						</div>
						<div class="form-group col-md-4">
							<label for="">Dt. Nascimento*</label>
							<input type="text" class="form-control" name="clt_nasc" id="clt_nasc" value="<?php echo date('d/m/Y', strtotime(implode('-', explode('/', $client->clt_nasc)))); ?>">
						</div>
						<div class="form-group col-md-4">
							<label for="">Tel/Cel*</label>
							<input type="text" class="form-control" name="clt_tel_cel" id="clt_tel_cel" value="<?php echo $client->clt_tel_cel; ?>">
						</div>
						<div class="form-group col-md-4">
							<label for="">Celular*</label>
							<input type="text" class="form-control" name="clt_cel" id="clt_cel" value="<?php echo $client->clt_cel; ?>">
						</div>
						<div class="form-group col-md-4">
							<label class="control-label">Gênero *</label>
							<select class="form-control" id="clt_genero" name="clt_genero">
								<option value="0">Selecione o Gênero</option>
								<option value="F" <?php echo ($client->clt_genero=="F" ) ? "selected='selected'" : "" ?>>Feminino</option>
								<option value="M" <?php echo ($client->clt_genero=="M" ) ? "selected='selected'" : "" ?>>Masculino</option>
							</select>
						</div>
						<div class="col-md-3 form-group">
							<label class="control-label">CEP</label>
							<input type="text" class="form-control" id="addr_zipcode" name="addr_zipcode" value="<?php echo $client->addr_zipcode; ?>">
						</div>

						<div class="col-md-7 form-group">
							<label class="control-label">Endereço *</label>
							<input type="text" class="form-control" id="addr_street" name="addr_street" value="<?php echo $client->addr_street; ?>">
						</div>

						<div class="col-md-2 form-group">
							<label class="control-label">Número *</label>
							<input type="text" class="form-control" id="addr_number" name="addr_number" value="<?php echo $client->addr_number; ?>">
						</div>

						<div class="col-md-12 form-group">
							<label class="control-label">Complemento *</label>
							<input type="text" class="form-control" id="addr_comp" name="addr_comp" value="<?php echo $client->addr_comp; ?>">
						</div>

						<div class="col-md-6 form-group">
							<label class="control-label">Bairro *</label>
							<input type="text" class="form-control" id="addr_district" name="addr_district" value="<?php echo $client->addr_district; ?>">
						</div>

						<div class="col-md-6 form-group">
							<label class="control-label">Cidade *</label>
							<input type="text" class="form-control" id="addr_city" name="addr_city" value="<?php echo $client->addr_city; ?>">
						</div>

						<div class="col-md-6 form-group">
							<label class="control-label">Estado *</label>
							<input type="text" class="form-control" id="addr_state" name="addr_state" value="<?php echo $client->addr_state; ?>">
						</div>

						<div class="col-md-6 form-group">
							<label class="control-label">País *</label>
							<input type="text" class="form-control" id="addr_country" name="addr_country" value="Brasil" value="<?php echo $client->addr_country; ?>">
						</div>

						<div class="col-md-12 form-group">
							<label class="control-label">Observação</label>
							<textarea class="form-control" id="clt_obs" name="clt_obs" rows="8"><?php echo (empty($client->clt_obs) ? "" : $client->clt_obs) ?></textarea>
						</div>
						<div class="form-group col-md-12 mb-0">
							<button type="submit" class="btn btn-primary btn-sm">Atualizar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card border-secondary">
				<img class="img-fluid" id="previewing" src="<?php echo ($client->clt_img !== null) ? base_url('/assets/uploads/client/' . $client->clt_img) : base_url('/assets/img/avatar.jpg') ?>">
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
					<div class="form-group">
						<label class="control-label">Status *</label>
						<select class="form-control" id="clt_status" name="clt_status">
							<option value="0">- Selecione o Status -</option>
							<?php
                            foreach ($status as $Status):
                                echo "<option value=\"{$Status['st_id']}\" ";
                                if ($Status['st_id'] == $client->clt_status) {
                                    echo "selected='selected'";
                                }
                                echo ">{$Status['st_title']}</option>";
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