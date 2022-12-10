<table class="table">
    <?php foreach ($listaExtrato as $item): ?>
        <tr>
            <td><?=$item->id;?></td>
            <td><?=$item->valor;?></td>
            <td><?=$item->movimentacao;?></td>
            <td><?=$item->dataRegistro;?></td>
        </tr>
    <?php endforeach; ?>
</table>