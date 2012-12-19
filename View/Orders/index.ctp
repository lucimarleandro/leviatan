<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Pedidos', array('controller'=>'orders', 'action'=>'index'));
?>
<?php if(empty($orders)) {?>
    <h3><?php echo __('Não há pedidos');?></h3>
<?php }else {?>
    <div class="box-content">
        <div>
            <table id="table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Ação</th>
                    </tr>
                </thead>	
                <tbody>
                        <?php foreach($orders AS $order):?>
                        <tr>
                            <td><?php echo $this->Time->format('d/m/Y', $order['Order']['created']);?></td>
                            <td>
                            <?php 
                            echo $this->Form->postLink(
                                $this->Html->image('preview'), 
                                array('controller'=>'orders','action'=>'view', $order['Order']['created']), 
                                array('escape'=>false, 'title'=>'Visualizar pedidos')
                            ); 
                            ?>
                            </td>
                        </tr>
                        <?php endforeach;?>
                </tbody>	
            </table>
        </div>
    </div>	
    <?php echo $this->element('pagination');?>
<?php }?>