<?php
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Unidades-Setores', '/unity_sectors/');
$this->Html->addCrumb('Adicionar', '/unity_sectors/add');
 
echo $this->Html->link(
	$this->Html->image('back'),
	array('controller'=>'unity_sectors', 'action'=>'index'),
	array('escape'=>false)		
);
?>

<div class="well">
	<?php echo $this->Form->create('UnitySector', array('class'=>'form-horizontal')); ?>
		<fieldset>
			<legend>Adicionar Unidade-Setor</legend>
			<div class="control-group required">
				<label class="control-label" for="Nome da Unidade">Unidade</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('unity_id', 
						array(
							'label'=>false, 
							'class'=>'input-xlarge',
							'optoins'=>$unities
						)
					);
					?>
				</div>
				<div id="error-unity">
				
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Nome do Setor">Setor</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('sector_id', 
						array(
							'label'=>false, 
							'class'=>'input-xlarge chosen-sector',
							'data-placeholder'=>"Selecione uma unidade",
							'multiple'=>true
						)
					);
					?>
				</div>
			</div>			

			<div class="form-actions">
				<?php echo $this->Form->button('Enviar', array('id'=>'submit-form','class'=>'btn btn-primary', 'type'=>'button'));?>
      			<?php echo $this->Html->link('Cancelar', array('controller'=>'unity_sectors', 'action'=>'index'), array('class'=>'btn'));?>
    		</div>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
<script>

$('#submit-form').click(function(){

	if($('#UnitySectorUnityId').val() == '') {
		alert('Selecione uma unidade');
		return false;
	}
	if($('#UnitySectorSectorId').val() == null) {
		alert('Selecione um setor');
		return false;
	}
	
	$("#UnitySectorAddForm").submit();
});

$("#UnitySectorSectorId").chosen();
$('#UnitySectorUnityId').change(function(){

	var unity_id = $(this).val();
	var left = true;
	
	if(unity_id == '') {
		$('#UnitySectorSectorId').html('<option value="">Selecione uma unidade</option>');
		return false;
	}
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		data: {unity_id: unity_id},
		url: forUrl('/sectors/get_sectors/'+left),
		success: function(result) {
			var options = "";    		
    		$.each(result, function(key, val) {
    			options += '<option value="' + key + '">' + val + '</option>';
    		});
    		
    		$('#UnitySectorSectorId').html(options);
    		$('#UnitySectorSectorId').trigger("liszt:updated");
		}		
	});
}); 					
</script>