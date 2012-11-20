<?php $this->Html->addCrumb('Itens', '/items'); ?>

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
</script>