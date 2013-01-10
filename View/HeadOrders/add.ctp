<?php
$this->Html->addCruumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Relação unidade-classe do item', array('controller'=>'head_orders', 'action'=>'index'));
$this->Html->addCrumb('Adicionar', array('controller'=>'head_orders', 'action'=>'add'));
 
echo $this->Html->link(
	$this->Html->image('back.png'),
	array('controller'=>'head_orders', 'action'=>'index'),
	array('escape'=>false)		
);
?>

<div class="well">
    <?php echo $this->Form->create('HeadOrder', array('class'=>'form-horizontal')); ?>
        <fieldset>
            <legend>Adicionar Unidade-Classe</legend>
            <div class="control-group required">
                <label class="control-label" for="Nome da Unidade-setor">Unidade-Setor</label>
                <div class="controls">
                    <?php 
                    echo $this->Form->input('unity_sector_id', 
                        array(
                            'label'=>false, 
                            'class'=>'input-xxlarge',
                            'options'=>$unitySectors
                        )
                    );
                    ?>
                </div>
                <div id="error-unity">

                </div>
            </div>
            <div class="control-group required">
                <label class="control-label" for="Nome da Classe">Classe</label>
                <div class="controls">
                    <?php 
                    echo $this->Form->input('item_class_id', 
                        array(
                            'label'=>false, 
                            'class'=>'input-xlarge',
                            'multiple'=>true,
                            'data-placeHolder'=>'Selecione uma unidade-setor'
                        )
                    );
                    ?>
                </div>
            </div>			

            <div class="form-actions">
                <?php echo $this->Form->button('Enviar', array('id'=>'submit-form','class'=>'btn btn-primary', 'type'=>'button'));?>
                <?php echo $this->Html->link('Cancelar', array('controller'=>'head_orders', 'action'=>'index'), array('class'=>'btn'));?>
            </div>
        </fieldset>
    <?php echo $this->Form->end(); ?>
</div>
<script>

$('#submit-form').click(function(){

    if($('#HeadOrderUnitySectorId').val() == '') {
        alert('Selecione uma unidade-setor');
        return false;
    }
    if($('#HeadOrderItemClassId').val() == null) {
        alert('Selecione uma classe');
        return false;
    }

    $("#HeadOrderAddForm").submit();
});

$("#HeadOrderItemClassId").chosen();
$('#HeadOrderUnitySectorId').change(function(){

    var unity_sector_id = $(this).val();

    if(unity_sector_id == '') {
        $('#HeadOrderUnityItemClassId').html('<option value="">Selecione uma unidade-setor</option>');
        return false;
    }

    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {unity_sector_id: unity_sector_id},
        url: forUrl('/head_orders/get_item_classes/'),
        success: function(result) {
            var options = "";    		
            $.each(result, function(key, val) {
                options += '<option value="' + key + '">' + val + '</option>';
            });
            $('#HeadOrderItemClassId').html(options);
            $('#HeadOrderItemClassId').trigger("liszt:updated");
        }		
    });
}); 					
</script>