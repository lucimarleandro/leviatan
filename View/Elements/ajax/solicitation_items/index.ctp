<?php if (empty($items)) { ?>
    <h3><?php echo __('Não há Itens'); ?></h3>
<?php } else { ?>
    <div class="box-content">
        <table id="table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th><?php echo __('Código'); ?></th>
                    <th><?php echo __('Nome'); ?></th>
                    <th><?php echo __('Ação'); ?></th>
                </tr>
            </thead>	
            <tbody>
                <?php foreach ($items AS $item): ?>
                    <tr>
                        <td><?php echo $item['Item']['keycode']; ?></td>
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
                        <td>
                            <?php
                            if (in_array($item['Item']['id'], $cart_items)) {
                                echo $this->Html->image('shopping-cart.png', array('title' => 'O item está na lista de solicitações'));
                            } else if (in_array($item['Item']['id'], $pending)) {
                                echo $this->Html->image('pending.png', array('title' => 'O item está em processo de análise'));
                            } else {
                                echo $this->Html->link(
                                        $this->Html->image('add.png'), 'javascript:void(0)', array('escape' => false, 'class' => 'request-item', 'value' => $item['Item']['id'], 'title' => 'Solicitar o item')
                                );
                            }
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
<?php } ?>