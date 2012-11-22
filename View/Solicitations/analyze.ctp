<?php
$this->Html->addCrumb('Solicitações', '/solicitations/'); 
$this->Html->addCrumb('Analisar', '/solicitations/analyze/');
?>

<?php if(empty($solicitations)) {?>
    <h3><?php echo __('Não há Solicitações para análise');?></h3>
<?php }else {?>
    <div class="box-content">
        <table id="table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th><?php echo __('Nº da solicitação');?></th>
                    <th><?php echo __('Nº do memorando');?></th>
                    <th><?php echo __('Usuário');?></th>
                    <th><?php echo __('Unidade');?></th>
                    <th><?php echo __('Setor');?></th>
                    <th><?php echo __('Situação');?></th>
                </tr>
            </thead>	
            <tbody>
                    <?php foreach($solicitations AS $solicitation):?>
                    <?php echo $this->Form->input('solicitation_id', array('type'=>'hidden', 'value'=>$solicitation['Solicitation']['id'], 'class'=>'solicitation_id', 'id'=>false));?>
                    <tr>
                        <td>
                        <?php echo $solicitation['Solicitation']['keycode'];?>
                        <?php 
                        echo $this->Html->link(
                            $this->Html->image('next'), 
                            array('controller'=>'solicitation_items', 'action'=>'analyze', $solicitation['Solicitation']['id']),
                            array('escape'=>false, 'title'=>'Analisar itens da solicitação')
                        );
                        ?>
                        </td>
                        <td><?php echo $solicitation['Solicitation']['memo_number'];?></td>
                        <td><?php echo $solicitation['Employee']['name'];?></td>
                        <td><?php echo $solicitation['Unity']['name'];?></td>
                        <td><?php echo $solicitation['Sector']['name'];?></td>
                        <td>
                            <?php 
                            if(in_array($solicitation['Solicitation']['id'], $pending)) {
                                echo $this->Html->image('pending', array('title'=>'A solicitação possui algum item que não foi analisado'));
                            }else {
                                echo $this->Html->image('check', array('title'=>'A solicitação não possui itens a serem analisados'));
                            }							
                            ?>
                        </td>
                    </tr>
                    <?php endforeach;?>
            </tbody>	
        </table>
    </div>	
    <?php echo $this->element('pagination');?>
    <?php echo $this->Form->button('Gerar pedido', array('class'=>'btn', 'type'=>'button', 'id'=>'generate-request'));?>
<?php }?>

<script>
$('#generate-request').click(function(e){
    e.preventDefault();

    var elements = $('.solicitation_id');
    var solicitation_ids = new Array();

    $.each(elements, function(index, value) {
            solicitation_ids[index] = $(this).val();
    });

    $.ajax({
        type: 'POST',
        dataType: 'json',
        data:{solicitation_ids: solicitation_ids},
        url: forUrl('/solicitation_items/check'),
        success: function(result) {
            if(!result['return']) {
                $('#alert-message').html('<div id="flashMessage" class="alert alert-error">Não foi possível gerar o pedido. Alguma solicitação possui itens a serem analisados</div>');
                return false;
            }else {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: {solicitation_ids: solicitation_ids},
                    url: forUrl('/orders/add'),
                    success: function(restul) {
                        if(result['return']) {
                            $(location).attr('href', forUrl('/orders/index'));			
                        }else {
                            $('#alert-message').html('<div id="flashMessage" class="alert alert-error">Não foi possível gerar o pedido. Por favor entrar em contato com o administrador do sistema</div>');
                        }
                    }
                });
            }
        }	
    });
});
</script>
