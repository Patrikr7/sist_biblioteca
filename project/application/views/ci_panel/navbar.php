<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample08" aria-controls="navbarsExample08"
	 aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample08">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url('painel'); ?>">Início</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url('painel/clientes'); ?>">Clientes</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="dropdown08" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Livros</a>
				<div class="dropdown-menu" aria-labelledby="dropdown08">
					<a class="dropdown-item" href="<?php echo base_url('painel/livros'); ?>">Visualizar</a>
					<a class="dropdown-item" href="<?php echo base_url('painel/livros/novo'); ?>">Novo livro</a>
					<a class="dropdown-item" href="<?php echo base_url('painel/categorias'); ?>">Categorias</a>
				</div>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url('painel/livros-locado'); ?>">Locação</a>
			</li>
		</ul>
	</div>
</nav>