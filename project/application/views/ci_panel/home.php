<div class="container py-4">
	<div class="row">
		<div class="col-md-4 mt-4 mb-4">
			<div class="card text-center">
				<div class="card-body">
					<h5 class="card-title">
						<b>
							<?php echo $countClient; ?>
						</b> Clientes Cadastrados</h5>
					<a href="<?php echo base_url('painel/clientes'); ?>" class="btn btn-primary">Visualizar</a>
				</div>
			</div>
		</div>
		<div class="col-md-4 mt-4 mb-4">
			<div class="card text-center">
				<div class="card-body">
					<h5 class="card-title">
						<b>
							<?php echo $countBook; ?>
						</b> Livros Cadastrados</h5>
					<a href="<?php echo base_url('painel/livros'); ?>" class="btn btn-primary">Visualizar</a>
				</div>
			</div>
		</div>
		<div class="col-md-4 mt-4 mb-4">
			<div class="card text-center">
				<div class="card-body">
					<h5 class="card-title">
						<b>
							<?php echo $countBookLeased; ?>
						</b> Livros Locados</h5>
					<a href="<?php echo base_url('painel/livros-locado'); ?>" class="btn btn-primary">Visualizar</a>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					Livros mais lidos
				</div>
				<div class="card-body">
					<?php if (empty($booksRead)) : ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-warning mb-0">
                                    <p class="mb-0">Nenhum livro foi alugado no momento.</p>
                                </div>
                            </div>
                        </div>
                        <?php else : foreach ($booksRead as $lista) : ?>
							<article class="py-3 pr-3 pl-3 mb-3 border-top border-right border-bottom border-left article_books">
                                <div class="row">
                                    <div class="col-md-3 align-self-center">
									<a href="<?php base_url('painel/livros/update/'.$lista["book_url"]) ?>" title="<?php echo $lista['book_title']; ?>"><img class="img-fluid rounded" src="<?php echo ($lista["book_img"] !== null) ? base_url('/assets/uploads/book/' . $lista['book_img']) : base_url('assets/img/book.png'); ?>" alt="<?php echo $lista['book_title']; ?>" title="<?php echo $lista['book_title'] ?>"></a>
                                    </div>
                                    <div class="col-md-9 align-self-center">
										<div class="box-content">
                                            <header class="box-header">
                                                <h5><a href="<?php echo base_url('/painel/livros/update/'.$lista['book_url']); ?>" title="<?php echo $lista['book_title'] ?>"><?php echo $lista['book_title'] ?></a></h5>
                                            </header>
                                            <div class="box-text">
												<p class="mb-0"><i class="fa fa-calendar"></i> <b>Lançamento:</b> <?php echo $lista['book_launch']; ?></p>
                                                <p class="mb-0"><i class="fas fa-sort-numeric-up"></i> <b>Quantidade:</b> <?php echo $lista['book_amount'] ?></p>
												<p class="mb-0"><i class="fa fa-font"></i> <b>Editora:</b> <?php echo $lista['book_publishing'] ?></p>
                                                <p class="mb-0"><i class="fa fa-user-tie"></i> <b>Autor:</b> <?php echo $lista['book_author'] ?></p>
                                                <p class="mb-0"><i class="fas fa-book-open"></i> <b>Lidos por:</b> <?php echo $lista['book_read'] ?>x</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                    <?php endforeach;
                    endif; ?>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					Últimos livros cadastrados
				</div>
				<div class="card-body">
					<?php if (empty($books)) : ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-warning mb-0">
                                    <p class="mb-0">Nenhum livro cadastrado.</p>
                                </div>
                            </div>
                        </div>
                        <?php else : foreach ($books as $Book) : ?>
                            <article class="py-3 pr-3 pl-3 mb-3 border-top border-right border-bottom border-left article_books">
                                <div class="row">
                                    <div class="col-md-3 align-self-center">
                                        <a href="<?php echo base_url('painel/livros/update/'.$Book["book_url"]) ?>" title="<?php echo $Book['book_title']; ?>"><img class="img-fluid rounded" src="<?php echo ($Book["book_img"] !== null) ? base_url('/assets/uploads/book/' . $Book['book_img']) : base_url('assets/img/book.png'); ?>" alt="<?php echo $Book['book_title']; ?>" title="<?php echo $Book['book_title'] ?>"></a>
                                    </div>
                                    <div class="col-md-9 align-self-center">
                                        <div class="box-content">
                                            <header class="box-header">
                                                <h5><a href="<?php echo base_url('/painel/livros/update/'.$Book['book_url']); ?>" title="<?php echo $Book['book_title'] ?>"><?php echo $Book['book_title'] ?></a></h5>
                                            </header>
                                            <div class="box-text">
												<p class="mb-0"><i class="fa fa-calendar"></i> <b>Lançamento:</b> <?php echo $Book['book_launch']; ?></p>
                                                <p class="mb-0"><i class="fas fa-sort-numeric-up"></i> <b>Quantidade:</b> <?php echo $Book['book_amount'] ?></p>
												<p class="mb-0"><i class="fa fa-font"></i> <b>Editora:</b> <?php echo $Book['book_publishing'] ?></p>
                                                <p class="mb-0"><i class="fa fa-user-tie"></i> <b>Autor:</b> <?php echo $Book['book_author'] ?></p>
                                                <p class="mb-0"><i class="fas fa-book-open"></i> <b>Lidos por:</b> <?php echo $Book['book_read'] ?>x</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                    <?php endforeach;
                    endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>