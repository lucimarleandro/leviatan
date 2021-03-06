<?php
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Solicitações', array('controller'=>'solicitations', 'action'=>'analyze')); 
?>

<?php if(empty($solicitations)) {?>
    <h3><?php echo __('Não há Solicitações para análise');?></h3>
<?php }else {?>
    <div class="box-content">
        <div class="control-group required">
            <h4 style="font-weight: bold;">Parecer do Pedido</h4>
            <div class="controls">
                <?php 
                echo $this->Tinymce->input('Order.opinion', 
                    array(
                        'label'=>false,
                        'class'=>'span9',
                        'rows'=>10,
                    ),array(
                        'language'=>'pt',
                        'onchange_callback'=>'onChangeOpinion'
                    ),
                    'basic'
                );
                ?>
            </div>
        </div>
        <label class="error" style="display: none;">Campo Obrigatório</label>
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
                        <td class="acoes">
                        <?php echo $solicitation['Solicitation']['keycode'];?>
                        <?php 
                        echo $this->Html->link(
                            $this->Html->image('next.png'), 
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
                                echo $this->Html->image('pending.png', array('title'=>'A solicitação possui algum item que não foi analisado'));
                            }else {
                                echo $this->Html->image('check.png', array('title'=>'A solicitação não possui itens a serem analisados'));
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

function onChangeOpinion(editor) {
    tinyMCE.triggerSave();
    
    if(editor.getContent() == '') {
        $('.error').fadeIn();
    }else {
        $('.error').fadeOut();
    }    
}

$('#generate-request').click(function(e){
    
    if($('#OrderOpinion').val() == '') {
        $('.error').fadeIn();
        return;
    }else {
         $('.error').fadeOut();
    }
    
    
    e.preventDefault();

    var elements = $('.solicitation_id');
    var solicitation_ids = new Array();
    var opinion = $('#OrderOpinion').val();

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
                    data: {solicitation_ids: solicitation_ids, opinion:opinion},
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
