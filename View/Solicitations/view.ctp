<?php
echo $this->Html->link(
    $this->Html->image('back.png'),
    'javascript:window.history.go(-1)',
    array('escape'=>false)
);
?>
<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a title="Descrição da solicitação" href="#text"><?php echo __('Descrição')?></a></li>
    <li><a title="Itens da solicitação" href="#items"><?php echo __('Itens')?></a></li>
    <li><a title="Anexo da solicitação" href="#attachment"><?php echo __('Anexo')?></a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="text">
        <?php echo $this->Form->create('Solicitation', array('class'=>'form-horizontal')); ?>
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="Nº do memorando">Nº do memorando</label>
                    <div class="controls">
                        <?php echo $solicitation['Solicitation']['memo_number']; ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="Decrição da solicitação">Texto</label>
                    <div class="controls">
                        <?php echo $solicitation['Solicitation']['description'];?>
                    </div>
                </div>
            </fieldset>
        <?php echo $this->Form->end();?>
    </div>
    <div class="tab-pane" id="items">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nº do processo</th>
                    <th>Unidade-Setor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($items as $key=>$value):?>
                    <tr>
                        <td>
                            <div class="accordion">
                                <h3><?php echo $key; ?></h3>
                                <div>
                                    <ul>
                                        <?php foreach($value as $data): ?>
                                            <?php 
                                            $name = $data['Item']['name'];
                                            $quantity = $data['SolicitationItem']['quantity'];
                                            $status = $data['SolicitationItem']['status_id'];
                                            $icon = '';

                                            if($status == APROVADO) {
                                                $icon = $this->Html->image('check.png', array('title' => 'O item foi aprovado'));
                                            }elseif($status == PENDENTE) {
                                                $icon = $this->Html->image('pending.png', array('title' => 'O item está em processo de análise'));
                                            }elseif($status == NEGADO) {
                                                $icon = $this->Html->link(
                                                    $this->Html->image('deny.png'), 
                                                    'javascript:void(0)', 
                                                    array(
                                                        'escape' => false,
                                                        'class' => 'deny-visualization',
                                                        'value' => $data['SolicitationItem']['id'],
                                                        'title' => 'O item não foi aprovado. Clique para ver a justificativa.',
                                                        'style'=>'display:inline;'
                                                    )
                                                );
                                            }
                                            ?>
                                            <li>
                                                <?php echo $name.'('.$quantity.')'.' '.$icon?>
                                            </li>
                                        <?php endforeach;?>
                                    </ul>
                                </div>
                            </div>                    
                        </td>
                        <td><?php echo $value['0']['Order']['process_number']; ?></td>
                        <td><?php echo $value[0]['Unity']['name'].' - '.$value[0]['Sector']['name']; ?></td>
                    </tr>        
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <div class="tab-pane" id="attachment">
        <?php 
        if($solicitation['Solicitation']['attachment']) {
            echo $solicitation['Solicitation']['attachment'];
        }else {
            echo '<b>Não existe anexo</b>';
        }
        ?>
    </div>
</div>
<div id="modal"></div>

<script>
$('#myTab a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
});
$( ".accordion" ).accordion({
    collapsible: true,
    active: false,
    heightStyle: 'content'
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
