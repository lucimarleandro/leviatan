<table id="table" class="table table-bordered table-hover">
    <caption>Itens que estão sendo solicitados na rede</caption>
    <thead>
        <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Quantidade</th>           
            <th>Ação</th>
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
                    <td>
                        <?php
                        if (in_array($value['Item']['id'], $cart_items)) {
                            echo $this->Html->image('shopping-cart.png', array('title' => 'O item está na lista de solicitações'));
                        } else if (in_array($value['Item']['id'], $pending)) {
                            echo $this->Html->image('pending.png', array('title' => 'O item está em processo de análise'));
                        } else {
                            echo $this->Html->link(
                                $this->Html->image('add.png'), 'javascript:void(0)', array('escape'=>false, 'class'=>'request-item', 'value'=>$value['Item']['id'], 'title'=>'Solicitar o item')
                            );
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php } ?>
    </tbody>
</table>   

<script>
$('.request-item').die();
$('.request-item').live('click', function(e){
    e.preventDefault();

    var element = $(this).parent();	
    var item_id = $(this).attr('value');
    var url = forUrl('/cart_items/add');

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: url,
        data:{item_id: item_id},
        success: function(result){
            if(result['return']) {
                element.html('<?php echo $this->Html->image('shopping-cart.png', array('alt' => 'carrinho', 'title' => 'Item no carrinho de solicitações')) ?>');
            }
        }
    });	
});    
</script>