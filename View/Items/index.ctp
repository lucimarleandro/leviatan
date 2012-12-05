<?php $this->Html->addCrumb('Itens', array('controller'=>'items', 'action'=>'index')); ?>

<?php if(!$ajax) {?>
<div class="box">
    <?php echo $this->element('box_search');?>
    <?php echo $this->Form->input('url', array('type'=>'hidden', 'id'=>'url', 'value'=>'/items/index'));?>

    <div style="padding-bottom: 20px;">
        <?php 
        echo $this->Html->link('Adicionar', 
            array('controller'=>'items', 'action'=>'add'), 
            array('class'=>'btn', 'escape'=>false)
        );
        ?>
    </div>

    <div id="items">
        <?php echo $this->element('ajax/items/index');?>
    </div>
</div>
<?php }else {
    echo $this->element('ajax/items/index');
}?>

<script>
$('.changeStatus').die('click');
$('.changeStatus').live('click', function(){
	
    var url = forUrl('/items/changeStatus');
    var item_id = $(this).val();
    var status_id = '2'; //Item inativo

    if($(this).is(':checked')) {
        status_id = '1'; //Item ativo
    }
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: url,
        data: {
            status_id: status_id,
            item_id: item_id
        },
        success: function(result){
            if(!result['result']) {
                    alert('Não foi possível alterar o status do item');
            }
        }
    });
});

$('#ItemItemGroupId').change(function(){
    var item_group_id = $(this).val();

    if(item_group_id == ''){
        $('#ItemItemClassId').html('<option value="">Selecione um grupo</option>');
        return false;
    }

    var url = forUrl('/item_classes/get_item_classes_by_sectors/'+true);
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: {'item_group_id':item_group_id},
        url:url,
        success: function(result){
            var options = "";    		
            $.each(result, function(key, val) {
                if(key == '') {
                    options = '<option value="' + key + '">' + val + '</option>' + options;
                }else {
                    options += '<option value="' + key + '">' + val + '</option>';
                }                
            });

            $('#ItemItemClassId').html(options);
        }
    })
});
</script>