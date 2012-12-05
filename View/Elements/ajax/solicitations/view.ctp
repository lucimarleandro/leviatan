<div class="box-content">
    <table id="table" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th><?php echo __('Código') ?></th>
                <th><?php echo __('Nome'); ?></th>
                <th><?php echo __('Unidade') ?></th>
                <th><?php echo __('Setor') ?></th>
                <th><?php echo __('Quantidade'); ?></th>
                <th><?php echo __('Situação'); ?></th>
            </tr>
        </thead>	
        <tbody>
            <?php foreach($solicitation AS $item): ?>
                <tr>
                    
                    <td style="white-space: nowrap"><?php echo $item['Item']['keycode']; ?></td>
                    <td>
                        <?php
                        echo $this->Html->link(
                                $item['Item']['name'], array('controller' => 'items', 'action' => 'view', 'id'=>$item['Item']['id'])
                        );
                        ?>
                    </td>
                    <td><?php echo $item['Unity']['name']; ?></td>
                    <td><?php echo $item['Sector']['name']; ?></td>
                    <td><?php echo $item['SolicitationItem']['quantity'] ?></td>
                    <td>
                        <?php
                        if($item['SolicitationItem']['status_id'] == APROVADO) {
                            echo $this->Html->image('check', array('title' => 'O item foi aprovado'));
                        }elseif($item['SolicitationItem']['status_id'] == PENDENTE) {
                            echo $this->Html->image('pending', array('title' => 'O item está em processo de análise'));
                        }elseif($item['SolicitationItem']['status_id'] == NEGADO) {
                            echo $this->Html->link(
                                    $this->Html->image('deny'), 'javascript:void(0)', array(
                                'escape' => false,
                                'class' => 'deny-visualization',
                                'value' => $item['SolicitationItem']['id'],
                                'title' => 'O item não foi aprovado. Clique para ver a justificativa.'
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
echo $this->Paginator->options(array(
    'update' => '#items',
    'evalScript' => true
        )
);
?>
<?php echo $this->element('pagination'); ?>

<div id="modal"></div>

<script>
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