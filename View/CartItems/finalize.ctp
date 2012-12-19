<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Solicitações', array('controller'=>'solicitations', 'action'=>'index'));
$this->Html->addCrumb('Finalizar', array('controller'=>'cart_items', 'action'=>'finalize'));
?>

<h3>Confirmar Solicitação</h3>
<div class="well">
    <p style="padding-bottom: 10px;">
    <b>Nº do Memorando:</b> <?php echo $solicitation[0]['SolicitationTemporary']['memo_number'];?>    
    </p>
    
    <p style="margin-top: 20px; font-weight: bold;">Descrição</p>
    <div style="margin-bottom: 30px;">
        <?php echo $solicitation[0]['SolicitationTemporary']['description'];?>
    </div>
    
    <p style="font-weight: bold; margin-top: 20px;">Itens</p>
    <table class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th>Código</th>
                <th>Item</th>
                <th>Quantidade</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($solicitation as $item):?>
            <tr>
                <td align="center" style="white-space: nowrap;"><?php echo $item['Item']['keycode'];?></td>
                <td><?php echo $item['Item']['name'];?></td>
                <td align="center" valign="middle"><?php echo $item['CartItem']['quantity'];?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    
    <?php if($solicitation[0]['SolicitationTemporary']['attachment']) {?>
        <div style="margin-top: 40px;">
             <p style="font-weight: bold;">Anexo</p>
            <?php echo $solicitation[0]['SolicitationTemporary']['attachment'];?>
        </div>
    <?php } ?>
        
        
    <div class="form-actions">
        <?php echo $this->Form->button('Confirmar', array('type' => 'button', 'class' => 'btn btn-primary', 'id'=>'submit-solicitation', 'title' => 'Salvar')); ?>
        <?php echo $this->Html->link('Cancelar', array('controller'=>'cart_items', 'action'=>'index'), array('class'=>'btn'))?>    
    </div>         
</div>

<script>
//----------------
$('#submit-solicitation').die('click');
$('#submit-solicitation').live('click', function(e){    
    e.preventDefault();    
    var url = forUrl('/cart_items/checkout');

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: url,
        success: function(result) {
            if(result['return']) {
                var url = forUrl('/solicitations/index');
                $(location).attr('href',url);		
            }else {
                $('#alert-message').html('<div id="flashMessage" class="alert alert-error">Não foi possível concluir a solicitação. Entre em contato com o administrador do sistema.</div>');
            }	
        }
    });    
});
</script>
