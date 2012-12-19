<?php
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Insumos', array('controller'=>'inputs', 'action'=>'index'));
$this->Html->addCrumb('Adicionar', array('controller'=>'inputs', 'action'=>'add'));
 
echo $this->Html->link(
	$this->Html->image('back'),
	array('controller'=>'inputs', 'action'=>'index'),
	array('escape'=>false)		
);
?>

<div class="well">
	<?php echo $this->Form->create('Input', array('class'=>'form-horizontal')); ?>
		<fieldset>
			<legend>Adicionar Insumo</legend>
			<div class="control-group required">
				<label class="control-label" for="Categoria de Insumo">Categoria</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('input_category_id', 
						array(
							'label'=>false, 
							'class'=>'input-xlarge',
							'options'=>$categories
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Subcategoria de Insumo">Subcategoria</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('input_subcategory_id', 
						array(
							'label'=>false, 
							'class'=>'input-xlarge subcategory-chzn',
							'data-placeholder'=>"Selecione uma categoria",
							'multiple'=>true
						)
					);
					?>
				</div>
			</div>			

			<div class="form-actions">
				<?php echo $this->Form->button('Enviar', array('class'=>'btn btn-primary', 'type'=>'submit'));?>
      			<?php echo $this->Html->link('Cancelar', array('controller'=>'inputs', 'action'=>'index'), array('class'=>'btn'));?>
    		</div>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
<script>
$("#InputInputSubcategoryId").chosen();
$('#InputInputCategoryId').change(function(){

	var category_id = $(this).val();
	var left = true;

	if(category_id == '') {
		$('#InputInputSubcategoryId').html('<option value="">Selecione uma categoria</option>');
		return false;
	}
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		data: {category_id: category_id},
		url: forUrl('/input_subcategories/get_subcategories/'+left),
		success: function(result) {
			var options = "";    		
    		$.each(result, function(key, val) {
    			options += '<option value="' + key + '">' + val + '</option>';
    		});
    		
    		$('#InputInputSubcategoryId').html(options);
    		$('#InputInputSubcategoryId').trigger("liszt:updated");
		}		
	});
}); 
					
$('#InputAddForm').validate({
	ignore: "",
	rules: {
		'data[Input][input_category_id]': {
		    required: true
		}
	},
	messages: {
		'data[Input][input_category_id]': {
		    required: "Campo obrigatório"
		},
	},
	highlight: function(label) {
		$(label).closest('.control-group').addClass('error');
	},
	success: function(label) {
		label
		.text('OK!').addClass('valid')
		.closest('.control-group').addClass('success');
	},
	errorPlacement: function(label, element) {
		// position error label after generated textarea
		if (element.is("textarea")) {
			label.insertAfter(element.next());
		} else {
			label.insertAfter(element)
		}
	}
});
</script>