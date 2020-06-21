<div class="container py-5">
	<h3 class="mb-3">Livros em locação</h3>
	<a href="<?php echo base_url('painel/livros-locado/novo'); ?>" class="btn btn-info btn-sm mb-3">Nova Locação</a>
    <?php if (empty($bookLeased)): ?>
        <div class="alert alert-warning" role="alert">
            Nenhum livro locado!
        </div>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Imagem</th>
                    <th scope="col">Título</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Dt. Entrega</th>
                    <th scope="col">Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookLeased as $l): ?>
                <tr>
                    <th><img class="img-fluid table_leased_img" src="<?php echo base_url('assets/uploads/book/'.$l['book_img']); ?>"></th>
                    <td><?php echo $l["book_title"] ?></td>
                    <td><?php echo $l["clt_name"] ?></td>
                    <td>
                        <?php echo date('d/m/Y', strtotime(implode('-', explode('/', $l['date_end'])))); ?>
                        <?php echo (($l['leased'] == 1 && $l['date_end'] < date('Y-m-d')) ? "<small class='text-danger'>atrasado</small>" : "" ) ?>
                    </td>
                    <td>
                        <span class="btn btn-sm btn-info width-60 button_action" rel="Devolver o livro?" callback="livros-locado" callback_action='update' id="<?php echo $l["id"] ?>" title="Devolver Livro">Devolver</span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>