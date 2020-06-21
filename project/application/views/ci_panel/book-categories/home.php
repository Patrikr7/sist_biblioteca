<div class="container py-5">
	<h3 class="mb-3">Lista de Categorias</h3>
    <a href="<?php echo base_url('painel/categorias/novo'); ?>" class="btn btn-info btn-sm mb-3">Nova Categoria</a>
    <?php 
	if($msg = get_msg()):
		echo $msg;
	endif; 
	?>
	<?php if (empty($categories)): ?>
	<div class="alert alert-warning" role="alert">
		Nenhuma categoria cadastrada no momento!
	</div>
	<?php else: ?>
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Nome da Categoria</th>
				<th scope="col">Ação</th>
			</tr>
		</thead>
		<tbody>
			<?php

            $this->load->view('ci_panel/book-categories/categories_item', $data = [
                'itens' => $categories,
                'sinal' => '<i class=\"fas fa-circle\"></i>',
                'level' => 0
            ]);

            ?>
		</tbody>
	</table>
	<?php endif;?>
</div>