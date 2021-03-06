<?php
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Relação unidade-classe do item', array('controller'=>'head_orders', 'action'=>'index'));
?>

<div style="padding-bottom: 20px;">
    <?php 
    echo $this->Html->link('Adicionar', 
        array('controller'=>'head_orders', 'action'=>'add'), 
        array('class'=>'btn', 'escape'=>false)
    );
    ?>
</div>
<?php if(empty($headOrders)) {?>
    <h3><?php echo __('Não há relação de unidade com as classes dos itens');?></h3>
<?php } else {?>
    <div class="box-content">
        <table id="table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th><?php echo __('Unidade');?></th>
                    <th><?php echo __('Setor');?></th>
                    <th><?php echo __('Classe');?></th>
                    <th><?php echo __('Ação');?></th>
                </tr>
            </thead>	
                <tbody>
                    <?php foreach($headOrders AS $hd):?>
                    <tr>
                        <td><?php echo $hd['Unity']['name'];?></td>
                        <td><?php echo $hd['Sector']['name'];?></td>
                        <td><?php echo $hd['ItemClass']['keycode'].'-'.$hd['ItemClass']['name'];?></td>
                        <td class="acoes">
                            <?php 
                            echo $this->Form->postLink(
                                $this->Html->image('delete.png'),
                                array('controller'=>'head_orders', 'action'=>'delete', $hd['HeadOrder']['id']),
                                array(
                                    'escape'=>false, 
                                    'alt'=>'delete', 
                                    'title'=>'Deletar relação',
                                ),
                                __('Deseja, realmente, deletar a relação da unidade e a classe?')
                            );						
                            ?>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>	
            </table>
    </div>	
<?php 
    echo $this->element('pagination');        
}
?>
