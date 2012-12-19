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
                <tr class="test">
                    <td><?php echo $item['Item']['name']; ?></td>
                    <td style="white-space: nowrap">
                        <?php echo $this->Form->input('quantity', array('label' => false, 'div' => false, 'type' => 'text', 'class' => 'span1 input-quantity', 'maxLength' => '4', 'value' => $item['CartItem']['quantity'], 'id' => 'input-' . $item['CartItem']['id'])); ?>
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
<?php echo $this->Form->button('Próxima Etapa', array('class'=>'btn btn-primary', 'id'=>'next'));?>

<script>
 
//Permite que sejam digitados apenas números entre 0 e 9
$(".input-quantity").keyup(function() {
    var valor = $(this).val().replace(/[^0-9]+/g,'');
    $(this).val(valor);
});
//Edita a quantidade do item
$(".input-quantity").change(function() {
    
    noLoading = true;
    var quantity = $(this).val();
    var cart_item_id = $(this).attr('id').replace('input-', '');
    var url = forUrl('/cart_items/edit');

    if(quantity == 0) {
        alert('Quantidade não permitida. Se não deseja solicitar o item, favor excluir');
        $(this).attr('value', 1);
        return false;
    }
    
    $('#submit-solicitation').attr('disabled', true);

    $.ajax({
        type: 'POST',
        dataType: 'json',
        data:{cart_item_id: cart_item_id, quantity: quantity},
        url: url,
        success: function(result) {
            if(!result['return']) {
                $('#alert-message').html('<div id="flashMessage" class="alert alert-error">Não foi possível editar. Entre em contato com o administrador do sistema.</div>');
            }

            $('#submit-solicitation').attr('disabled', false);
        }
    });
});
//-------------------
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
            }else {
                $('#alert-message').html('<div id="flashMessage" class="alert alert-error">Não foi possível excluir o item. Entre em contato com o administrador do sistema.</div>');
            }
        }					
    });
});

//-------------------
$('#next').die('click');
$('#next').live('click', function(){
    var url = forUrl('/cart_items/finalize');
    
    if(!$('#SolicitationIndexForm').valid()) {
        $('#myTab a:first').tab('show');	
        return;	
    }
    
     $(location).attr('href', url);    
});

</script>