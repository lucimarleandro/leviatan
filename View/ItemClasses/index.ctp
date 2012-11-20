<?php 
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Classes dos Itens', '/item_classes/');
?>
<?php if(!$ajax) {?>
	<div class="box-search">
		<?php echo $this->Form->create('ItemClass', array('class'=>'well'));?>
			<?php echo $this->Form->input('item_group_id', array('div'=>false, 'label'=>'Grupo', 'type'=>'select', 'class'=>'span6', 'options'=>$groups));?>
			<?php echo $this->Form->input('name', array('label'=>'Nome', 'type'=>'text', 'class'=>'span6'));?>
			<?php echo $this->Form->button('Filtrar', array('type'=>'button', 'class'=>'btn btn-primary', 'id'=>'filter-item-classes'));?>
		<?php echo $this->Form->end();?>
	</div>
	<div style="padding-bottom: 20px;">
		<?php 
		echo $this->Html->link('Adicionar', 
			array('controller'=>'item_classes', 'action'=>'add'), 
			array('class'=>'btn', 'escape'=>false)
		);
		?>
	</div>
	<div id="items">
		<?php echo $this->element('ajax/item_classes/index');?>
	</div>
<?php }else {
	echo $this->element('ajax/item_classes/index');
}
?>
<script>
$('#ItemClassName').autocomplete({
    source: function( request, response ) {

    	noLoading = true;
    	var url = forUrl('/item_classes/autocomplete');
    	
        $.ajax({
        	type: 'POST',
            url: url,
            dataType: "json",
            data: {
                item_group_id: $('#ItemClassItemGroupId').val(),
                item_class_name: request.term
            },
            success: function(data) {
            	response(data);
            }
        });
    },
    minLength: 2
});

$('#filter-item-classes').unbind();
$('#filter-item-classes').click(function(){	
	
	var url = forUrl('/item_classes/index');
	
	var item_group_id = $('#ItemClassItemGroupId').val();
	var item_class_name = $('#ItemClassName').val();
	
	$('#items').load(
		url, 
		{'item_group_id': item_group_id, 'item_class_name': item_class_name}
	);		
});
</script>

