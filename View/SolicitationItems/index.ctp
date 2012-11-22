<?php 
$this->Html->addCrumb('Itens', '/items/');
$this->Html->addCrumb('Solicitar', '/solicitation_items/');
?>
<?php if(!$ajax) {?>
<div class="box">
	<?php echo $this->element('box_search');?>
	<?php echo $this->Form->input('url', array('type'=>'hidden', 'id'=>'url', 'value'=>'/solicitation_items/index'));?>
	<div id="items">
		<?php echo $this->element('ajax/solicitation_items/index');?>
	</div>
</div>
<?php }else {
	echo $this->element('ajax/solicitation_items/index');
}?>
<script>
$('#ItemItemGroupId').change(function(){
    var item_group_id = $(this).val();

    if(item_group_id == ''){
        $('#ItemItemClassId').html('<option value="">Selecione um grupo</option>');
        return false;
    }

    var url = forUrl('/item_classes/get_item_classes/');
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        data: {'item_group_id':item_group_id},
        url:url,
        success: function(result){
            var options = "";    		
            $.each(result, function(key, val) {
                options += '<option value="' + key + '">' + val + '</option>';
            });

            $('#ItemItemClassId').html(options);
        }
    })
});    
</script>