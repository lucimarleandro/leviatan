<?php if (empty($solicitationItems)) { ?>
    <h3><?php echo __('Não há solicitações'); ?></h3>
<?php } else { ?>
    <div class="box-content well">
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
                        <td><?php echo $this->Form->checkbox('select'); ?></td>
                        <td>
                            <?php
                            echo $this->Html->link(
                                    $solicitationItem['Item']['name'], array('controller' => 'items', 'action' => 'view', $solicitationItem['Item']['id'])
                            );
                            ?>
                        </td>
                        <td><?php echo $solicitationItem['SolicitationItem']['quantity']; ?></td>
                        <td style="white-space: nowrap;" id="element-<?php echo $solicitationItem['SolicitationItem']['id'] ?>">
                            <?php
                            if ($solicitationItem['SolicitationItem']['status_id'] == PENDENTE) {
                                echo $this->Html->link(
                                        $this->Html->image('add'), 'javascript:void(0)', array('escape' => false, 'title' => 'Aceitar o item', 'class' => 'accept', 'value' => $solicitationItem['SolicitationItem']['id'])
                                );
                                echo $this->Html->link(
                                        $this->Html->image('stop'), 'javascript:void(0)', array('escape' => false, 'title' => 'Não aceitar o item', 'class' => 'deny', 'value' => $solicitationItem['SolicitationItem']['id'])
                                );
                            } else if ($solicitationItem['SolicitationItem']['status_id'] == APROVADO) {
                                echo $this->Html->image('check', array('title' => 'Solicitação aprovada'));
                            } else if ($solicitationItem['SolicitationItem']['status_id'] == NEGADO) {
                                echo $this->Html->link(
                                        $this->Html->image('deny'), 'javascript:void(0)', array(
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
    </div>	
    <?php
    echo $this->Paginator->options(
            array(
                'update' => '#ajax',
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
        var image = '<?php echo $this->Html->image('check', array('title' => 'Item aceito')) ?>';

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {solicitation_item_id: $(this).attr('value')},
            url: forUrl('/solicitation_items/accept'),
            success: function(result) {
                if(result['return']) {
                    element.parent().html(image);		
                }else {
                    $('#alert-message').html('<div id="flashMessage" class="alert alert-error">Não foi possível concluir a operação. Por favor, entre em contato com o administrador do sistema</div>');
                    return false;
                }
            }
        });
    });

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
</script>