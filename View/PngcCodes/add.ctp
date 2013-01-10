<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('PNGC', array('controller'=>'pngc_codes', 'action'=>'index'));
$this->Html->addCrumb('Adicionar', array('controller'=>'pngc_codes', 'action'=>'add'));

echo $this->Html->link(
	$this->Html->image('back.png'),
	array('controller'=>'pngc_codes', 'action'=>'index'),
	array('escape'=>false)		
);
?>

<div class="well">
	<?php echo $this->Form->create('PngcCode', array('class'=>'form-horizontal')); ?>
		<fieldset>
			<legend>Adicionar PNGC</legend>
			<div class="control-group required">
				<label class="control-label" for="Código do PNGC">Código</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('keycode', 
						array(
							'label'=>false, 
							'class'=>'input-mini',
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Grupo de Gastos">Grupo de Gastos</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('expense_group_id', 
						array(
							'label'=>false, 
							'class'=>'input',
							'options'=>$expenseGroups
						)
					);
					?>
				</div>
			</div>			
			<div class="control-group required">
				<label class="control-label" for="Nome da unidade">Unidade de Medida</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('measure_type_id', 
						array(
							'label'=>false, 
							'class'=>'input',
							'options'=>$measureTypes
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Categoria">Categoria</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('input_category_id', 
						array(
							'label'=>false, 
							'class'=>'input',
							'options'=>$inputCategories
						)
					);
					?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="Subcategoria">Subcategoria</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('input_subcategory_id', 
						array(
							'label'=>false, 
							'class'=>'input',
							'options'=>array(''=>'Selecione uma categoria')
						)
					);
					?>
				</div>
			</div>
			<div class="form-actions">
				<?php echo $this->Form->button('Enviar', array('class'=>'btn btn-primary', 'type'=>'submit'));?>
      			<?php echo $this->Html->link('Cancelar', array('controller'=>'unities', 'action'=>'index'), array('class'=>'btn'));?>
    		</div>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
<script>
//-----------------
$('#PngcCodeInputCategoryId').change(function(){

	var category_id = $(this).val();

	if(category_id == '') {
		$('#PngcCodeInputSubcategoryId').html('<option value="">Selecione uma categoria</option>');
		return false;
	}
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		data: {category_id: category_id},
		url: forUrl('/input_subcategories/get_subcategories/'),
		success: function(result) {
			var options = "";    		
    		$.each(result, function(key, val) {
    			options += '<option value="' + key + '">' + val + '</option>';
    		});
    		
    		$('#PngcCodeInputSubcategoryId').html(options);
		}		
	});
}); 
$('#PngcCodeAddForm').validate({
	ignore: "",
	rules: {
		'data[PngcCode][keycode]': {
		    required: true
		},
		'data[PngcCode][measure_type_id]': {
		    required: true
		},
		'data[PngcCode][expense_group_id]': {
		    required: true
		},
		'data[PngcCode][input_category_id]': {
		    required: true
		}
	},
	messages: {
		'data[PngcCode][keycode]': {
		    required: "Campo obrigatório"
		},
		'data[PngcCode][measure_type_id]': {
		    required: "Campo obrigatório"
		},
		'data[PngcCode][expense_group_id]': {
		    required: "Campo obrigatório"
		},
		'data[PngcCode][input_category_id]': {
		    required: "Campo obrigatório"
		}
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