<div class="box-content">
    <table id="table" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th><?php echo __('Código'); ?></th>
                <th><?php echo __('Nome'); ?></th>
                <th><?php echo __('Quantidade'); ?></th>
                <th><?php echo __('Ação'); ?></th>
            </tr>
        </thead>	
        <tbody>
            <?php foreach ($items AS $item): ?>
                <tr>
                    <td>
                        <?php echo $item['Item']['keycode']; ?>
                    </td>
                    <td>
                        <?php 
                        echo $this->Html->link(
                            $item['Item']['name'],
                            'javascript:void(0);',
                            array(
                                'id'=>'view',
                                'data-controller'=>'items',
                                'data-id'=>$item['Item']['id']
                            )
                        ); 
                        ?>
                    </td>
                    <td class="acoes">
                        <?php echo $this->Form->input('quantity', array('label' => false, 'div' => false, 'type' => 'text', 'class' => 'span1 input-quantity', 'maxLength' => '4', 'value' => $item['CartItem']['quantity'], 'id' => 'input-' . $item['CartItem']['id'])); ?>
                    </td>
                    <td class="acoes">
                        <?php
                        echo $this->Html->link(
                            $this->Html->image('delete.png'), 'javascript:void(0)', array('escape' => false, 'class' => 'remove-cart-item', 'value' => $item['CartItem']['id'], 'title' => 'Remover o item')
                        );
                        echo $this->Form->input('page', array('id' => 'page', 'type' => 'hidden', 'value' => $this->Paginator->current()));
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>	
    </table>
</div>	
<?php
echo $this->Paginator->options(array(
        'update' => '#items',
        'evalScript' => true
    )
);
?>
<?php echo $this->element('pagination'); ?>
<?php echo $this->Form->button('Próxima Etapa', array('class'=>'btn btn-primary', 'id'=>'next'));?>

