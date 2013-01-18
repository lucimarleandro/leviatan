<table id="table" class="table table-bordered table-hover">
    <caption>Itens que estão sendo solicitados na rede</caption>
    <thead>
        <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Quantidade</th>            
        </tr>
    </thead>
    <tbody>
        <?php if(empty($data)) { ?>
            <tr>
                <th colspan="3">Não há itens</th>
            </tr>
        <?php }else { ?>
            <?php foreach($data as $value): ?>
                <tr>
                    <td><?php echo $value['Item']['keycode']; ?></td>
                    <td>
                        <?php 
                        echo $this->Html->link(
                            $value['Item']['name'],
                            'javascript:void(0);',
                            array(
                                'id'=>'view',
                                'data-controller'=>'items',
                                'data-id'=>$value['Item']['id']
                            )
                        ); 
                        ?>
                    </td>
                    <td><?php echo $value[0]['sum']; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php } ?>
    </tbody>
</table>    