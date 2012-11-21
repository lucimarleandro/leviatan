<div class="box-content">
    <table id="table" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th><?php echo __('Nome'); ?></th>
                <th><?php echo __('Quantidade'); ?></th>
                <th><?php echo __('Ação'); ?></th>
            </tr>
        </thead>	
        <tbody>
            <?php foreach ($items AS $item): ?>
                <tr>
                    <td><?php echo $item['Item']['name']; ?></td>
                    <td>
                        <?php echo $this->Form->input('quantity', array('label' => false, 'div' => false, 'type' => 'text', 'class' => 'span1 input-quantity', 'maxLength' => '4', 'value' => $item['CartItem']['quantity'], 'id' => 'input-' . $item['CartItem']['id'])); ?>
                        <?php
                        echo $this->Html->link($this->Html->image('refresh'), 'javascript:void(0)', array('escape' => false, 'class' => 'edit-quantity', 'value' => $item['CartItem']['id'], 'title' => 'Editar quantidade do item'));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $this->Html->link(
                                $this->Html->image('delete'), 'javascript:void(0)', array('escape' => false, 'class' => 'remove-cart-item', 'value' => $item['CartItem']['id'], 'title' => 'Remover o item')
                        );
                        echo $this->Form->input('page', array('id' => 'page', 'type' => 'hidden', 'value' => $this->Paginator->current()));
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
<?php echo $this->Form->button('Finalizar solicitação', array('type' => 'button', 'class' => 'btn btn-primary', 'id' => 'submit-solicitation', 'title' => 'Finaliza a solicitação')); ?>

<script>
    //Permite que sejam digitados apenas números entre 0 e 9
    $(".input-quantity").keyup(function() {
        var valor = $(this).val().replace(/[^0-9]+/g,'');
        $(this).val(valor);
    });


    $('.remove-cart-item').die('click');
    $('.remove-cart-item').live('click', function(){
        var url = forUrl('/cart_items/delete');
        var cart_item_id =  $(this).attr('value');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data:{cart_item_id: cart_item_id},
            url: url,
            success: function(result) {
                if(result['return']){
                    var page = $('#page').val();
                    var url = forUrl('/cart_items/index/page:'+page);
                    $.ajax({
                        type: 'POST',
                        url: url,
                        success: function(result) {
                            try{
                                jQuery.parseJSON(result);
                                $(location).attr('href', forUrl('/solicitation_items/index'));
                            }catch(e) {
                                $('#items').html(result);
                            }						
                        }
                    });	
                }
            }					
        });
    });

    $('.edit-quantity').die('click');
    $('.edit-quantity').live('click', function(){
        var cart_item_id = $(this).attr('value');
        var quantity = $('#input-'+cart_item_id).val();
        var url = forUrl('/cart_items/edit');

        if(quantity == 0) {
            alert('Quantidade não permitida. Se não deseja solicitar o item, favor excluir');
            return false;
        }
    	
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data:{cart_item_id: cart_item_id, quantity: quantity},
            url: url,
            success: function(result) {
                if(!result['return']) {
                    $('#alert-message').html('<div id="flashMessage" class="alert alert-error">Não foi possível editar. Entre em contato com o administrador do sistema.</div>');
                }
            }
        });	
    });

    $('#submit-solicitation').die('click');
    $('#submit-solicitation').live('click', function(e){
        e.preventDefault();

        if(!$('#SolicitationIndexForm').valid()) {
            $('#myTab a:first').tab('show');	
            return;	
        }
	
        var url = forUrl('/cart_items/checkout');
        var memo_number = $('#SolicitationMemoNumber').val();
        var description = $('#SolicitationDescription').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data:{memo_number:memo_number, description:description},
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