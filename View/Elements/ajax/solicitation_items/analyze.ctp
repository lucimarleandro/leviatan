<?php if (empty($solicitationItems)) { ?>
    <h3><?php echo __('Não há solicitações'); ?></h3>
<?php } else { ?>
    <div class="box-content">
        <table id="table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th><?php echo $this->Form->checkbox('select-all'); ?></th>
                    <th><?php echo __('Item'); ?></th>
                    <th><?php echo __('Quantidade'); ?></th>
                    <th><?php echo __('Ações'); ?></th>
                </tr>
            </thead>	
            <tbody>
                <?php foreach ($solicitationItems AS $solicitationItem): ?>
                    <tr>
                        <td>
                            <?php echo $this->Form->checkbox('select', array('class'=>'select', 'data-solicitation-item-id'=>$solicitationItem['SolicitationItem']['id'], 'disabled'=>$solicitationItem['SolicitationItem']['status_id'] != PENDENTE)); ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Html->link(
                                $solicitationItem['Item']['name'], 
                                'javascript:void(0);',
                                array(
                                    'id'=>'view',
                                    'data-controller'=>'items',
                                    'data-id'=>$solicitationItem['Item']['id']
                                )
                            );
                            ?>
                        </td>
                        <td><?php echo $solicitationItem['SolicitationItem']['quantity']; ?></td>
                        <td class="acoes" id="element-<?php echo $solicitationItem['SolicitationItem']['id'] ?>">
                            <?php
                            if ($solicitationItem['SolicitationItem']['status_id'] == PENDENTE) {
                                echo $this->Html->link(
                                        $this->Html->image('add.png'), 'javascript:void(0)', array('escape' => false, 'title' => 'Aceitar o item', 'class' => 'accept', 'value' => $solicitationItem['SolicitationItem']['id'])
                                );
                                echo $this->Html->link(
                                        $this->Html->image('stop.png'), 'javascript:void(0)', array('escape' => false, 'title' => 'Não aceitar o item', 'class' => 'deny', 'value' => $solicitationItem['SolicitationItem']['id'])
                                );
                            } else if ($solicitationItem['SolicitationItem']['status_id'] == APROVADO) {
                                echo $this->Html->image('check.png', array('title' => 'Solicitação aprovada'));
                            } else if ($solicitationItem['SolicitationItem']['status_id'] == NEGADO) {
                                echo $this->Html->link(
                                        $this->Html->image('deny.png'), 'javascript:void(0)', array(
                                    'escape' => false,
                                    'class' => 'deny-visualization',
                                    'value' => $solicitationItem['SolicitationItem']['id'],
                                    'title' => 'Solicitação não aprovada'
                                        )
                                );
                            }
                            ?>
                        </td>
                    </tr>					
                <?php endforeach; ?>
            </tbody>	
        </table>
        <?php echo $this->Form->button('Aprovar selecionados', array('id'=>'approve-selected', 'class'=>'btn btn-primary')); ?>
    </div>	
    <?php
    echo $this->Paginator->options(
            array(
                'update' => '#items',
                'evalScript' => true
            )
    );
    echo $this->element('pagination');
    ?>
<?php } ?>

<div id="modal"></div>

<script>
    $('.accept').die('click');
    $('.accept').live('click', function(e) {
        e.preventDefault();
        var element = $(this);
        var image = '<?php echo $this->Html->image('check.png', array('title' => 'Item aceito')) ?>';
        var solicitationItemId = $(this).attr('value');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {solicitation_item_id: solicitationItemId},
            url: forUrl('/solicitation_items/accept'),
            success: function(result) {
                if(result['return']) {
                    element.parent().html(image);		
                    $('.select[data-solicitation-item-id="'+solicitationItemId+'"]').attr('disabled', true);
                    
                    var amountDisabled = $('.select:disabled').length;
                    var amount = $('.select').length;
        
                    $('#select-all').attr('disabled', amountDisabled == amount).attr('checked', false);
                }else {
                    $('#alert-message').html('<div id="flashMessage" class="alert alert-error">Não foi possível concluir a operação. Por favor, entre em contato com o administrador do sistema</div>');
                    return false;
                }
            }
        });
    });
    
    //
    $('.deny').die('click');
    $('.deny').live('click', function(e) {	
        e.preventDefault();
        var solicitation_item_id = $(this).attr('value');

        $.ajax({
            type: 'POST',
            url: forUrl('/justifications/add/'+solicitation_item_id),
            success: function(result) {
                $('#modal').html(result);
                $('#myModal').modal();
            }
        });	
    });
    
    //
    $('.deny-visualization').die('click');
    $('.deny-visualization').live('click', function(e) {
        e.preventDefault();
        var solicitation_item_id = $(this).attr('value');

        $.ajax({
            type: 'POST',
            url: forUrl('/justifications/view/'+solicitation_item_id),
            success: function(result) {
                $('#modal').html(result);
                $('#myModal').modal();
            }
        })	
    });
    
    //
    $('#select-all').die('click');
    $('#select-all').live('click', function(e) {
        $('.select:enabled').attr('checked', $(this).is(':checked'));
    });
    
    //
    $('.select').die('click');
    $('.select').live('click', function(e){
        
        var amountSelected = $('.select:enabled').length;
        var amount = $('.select:checked').length;
        
        $('#select-all').attr('checked', amountSelected == amount);
    });    
    
    //
    $('#approve-selected').die('click');
    $('#approve-selected').live('click', function(e){
        e.preventDefault();       
        
        var image = '<?php echo $this->Html->image('check.png', array('title' => 'Item aceito')) ?>';
        var solicitationItemIds = new Array();
        
        var i = 0
        $('.select').each(function(index) {
            if($(this).attr('checked') == 'checked') {
                solicitationItemIds[i] = $(this).data('solicitation-item-id');
                i++;
            }
        });
        
        if(solicitationItemIds.length == 0) {
            return;
        }
        
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {solicitationItemIds: solicitationItemIds},
            url: forUrl('/solicitation_items/approveSelected'),
            success: function(result) {
                if(result['return']) {
                    for(var i = 0; i < solicitationItemIds.length; i++) {
                        $('#element-'+solicitationItemIds[i]).html(image);
                    }	
                    
                    $('.select:checked').attr('checked', false).attr('disabled', true);
                    
                    var amountDisabled = $('.select:disabled').length;
                    var amount = $('.select').length;
        
                    $('#select-all').attr('disabled', amountDisabled == amount).attr('checked', false);
                }else {
                    $('#alert-message').html('<div id="flashMessage" class="alert alert-error">Não foi possível concluir a operação. Por favor, entre em contato com o administrador do sistema</div>');
                    return false;
                }
            }
        });
        
    });
</script>