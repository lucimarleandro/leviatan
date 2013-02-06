<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Pedidos', array('controller'=>'orders', 'action'=>'index'));
$this->Html->addCrumb('Visualizar', '');


echo $this->Html->link(
    $this->Html->image('back.png'),
    array('controller'=>'orders', 'action'=>'index'),
    array('escape'=>false, 'title'=>'Retornar')		
);
?>

<?php if(empty($orders)) {?>
    <h3><?php echo __('Não há pedidos');?></h3>
<?php }else {?>
    <div class="box-content">
        <div>
            <table id="table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nº do processo</th>
                        <th>Ação</th>
                    </tr>
                </thead>	
                <tbody>
                    <?php foreach($orders AS $order):?>
                    <tr>
                        <td><?php echo $order['Order']['keycode'];?></td>
                        <td>
                            <?php 
                            echo $this->Form->input(
                                'process_number', 
                                array(
                                    'label'=>false, 
                                    'div'=>false, 
                                    'class'=>'span2 process-number', 
                                    'type'=>'text',
                                    'data-id'=>$order['Order']['id'],
                                    'value'=>$order['Order']['process_number'],
                                    'readonly'=>true
                                )
                            );
                            ?>
                            <?php
                            echo $this->Html->link(
                                '<i class="font-unlock"></i>', 
                                'javascript:void(0)', 
                                array(
                                    'escape'=>false, 
                                    'class'=>'unlock',
                                )
                            );
                            ?>
                        </td>
                        <td>
                        <?php 
                        echo $this->Form->postLink(
                            $this->Html->image('print.png'), 
                            array('controller'=>'orders','action'=>'report', $order['Order']['id'], 'ext'=>'pdf'), 
                            array('escape'=>false)); 
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

<script>
$('.edit').live('click', function(){
    
    //Pega o botão de editar clicado
    var elementButton = $(this);
    //Pega o elemento input
    var elementInput = $(this).parent().children('.process-number');
    var id = elementInput.data('id');
    var value = elementInput.val();
    var url = forUrl('/orders/setNumberProcess');
    
    $.ajax({
        type: 'POST',
        dataType: 'json',
        data:{id:id, value:value},
        url: url,
        success: function(result) {
            if(!result['return']) {
                $('#alert-message').html(result['message']);
            }else {
                var button = '<?php echo $this->Html->link("<i class=font-unlock></i>", "javascript:void(0)", array("escape"=>false, "class"=>"unlock")); ?>';
                elementInput.attr('readonly', true);
                elementButton.replaceWith(button);
            }
        }
    });
});

$('.unlock').live('click', function(){    
    var button = '<?php echo $this->Html->link("<i class=font-edit></i>", "javascript:void(0)", array("escape"=>false, "class"=>"edit"))?>';    
    
    $(this).parent().children().attr('readonly', false);
    $(this).replaceWith(button);
});
</script> 
        