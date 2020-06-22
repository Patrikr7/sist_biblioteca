<div class="container py-5">
	<div class="row mb-3">
		<div class="col-md-6">
			<h3 class="mb-0">Lista de Livros</h3>
		</div>
		<div class="col-md-6 text-right">
			<a href="<?php echo base_url('painel/livros/novo'); ?>" class="btn btn-info btn-sm mb-0">Novo Livro</a>
		</div>
	</div>
	<?php if (empty($books)): ?>
	<div class="alert alert-warning" role="alert">
		Nenhum livro cadastrado no momento!
	</div>
	<?php else: ?>
	<div class="row">
		<div class="col-md-12">
			<?php $this->load->view('ci_panel/book/filter');?>
		</div>
	</div>

	<div class="row" id="result-filter">
		<?php foreach ($books as $book): ?>
		<div class="col-md-3">
			<div class="card mb-4">
				<img class="card-img-top" src="<?php echo base_url('assets/uploads/book/' . $book['book_img']) ?>"
				alt="">
				<div class="card-body text-center">
					<h5 class="card-title">
						<a href="<?php echo base_url('painel/livros/update/' . $book['book_url']) ?>">
							<?php echo $book['book_title']; ?>
						</a>
					</h5>
					<div class="content mb-3">
						<span class="text-secondary d-block">
							<b>Autor:</b>
							<?php echo $book['book_author']; ?>
						</span>
						<span class="text-secondary d-block">
							<b>Editora:</b>
							<?php echo $book['book_publishing']; ?>
						</span>
						<span class="text-secondary d-block">
							<b>Lançamento:</b>
							<?php echo $book['book_launch']; ?>
						</span>
						<span class="text-secondary d-block">
							<b>Quant:</b>
							<?php echo $book['book_amount']; ?>
						</span>
					</div>
					<a href="<?php echo base_url('painel/livros/update/' . $book['book_url']) ?>"
					class="btn badge badge-primary">Editar</a>
					<span class="btn badge badge-danger button_action" rel="Deseja excluir?" callback="livros" callback_action='delete' id="<?php echo $book['book_id']; ?>"
					title="Excluir Livro">Excluir</span>
				</div>
			</div>
		</div>
		<?php endforeach;?>
	</div>

	<?php endif;?>
</div>