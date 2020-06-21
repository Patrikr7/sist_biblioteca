<div class="container py-5">
	<h3 class="mb-3">Lista de Clientes</h3>
	<a href="<?php echo base_url('painel/clientes/novo'); ?>" class="btn btn-info btn-sm mb-3">Novo Cliente</a>
	<?php if (empty($clients)): ?>
	<div class="alert alert-warning" role="alert">
		Nenhum cliente cadastrado no momento!
	</div>
	<?php else: ?>
	<table class="table">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Nome</th>
				<th scope="col">Email</th>
				<th scope="col">Status</th>
				<th scope="col">Ação</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($clients as $c): ?>
			<tr>
				<th scope="row">
					<?php echo $c["clt_id"] ?>
				</th>
				<td>
					<?php echo $c["clt_name"] ?>
				</td>
				<td>
					<?php echo $c["clt_email"] ?>
				</td>
				<td>
					<?php echo ($c["clt_status"] == 1 ? "Ativo" : "Inativo"); ?>
				</td>
				<td>
					<a href="<?php echo base_url('painel/clientes/update/'.$c['clt_url']); ?>" class="btn btn-info btn-sm">Editar</a>
                     
					<?php if($c['clt_status'] == 1): ?>
					    <span class="btn btn-sm btn-warning width-60 button_action" rel="Deseja inativar?" callback="clientes" callback_action="status" id="<?php echo $c['clt_id']; ?>" title="Inativar Cliente">Inativar</span>
					<?php else: ?>
					    <span class="btn btn-sm btn-primary width-60 button_action" rel="Deseja ativar?" callback="clientes" callback_action='status' id="<?php echo $c['clt_id']; ?>" title="Ativar Cliente">Ativar</span>
                    <?php endif; ?>
                    
					<span class="btn btn-sm btn-danger width-60 button_action" rel="Deseja excluir?" callback="clientes" callback_action='delete'
					 id="<?php echo $c['clt_id']; ?>" title="Excluir Cliente">Excluir</span>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>
</div>