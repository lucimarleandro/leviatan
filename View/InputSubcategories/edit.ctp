<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Subcategorias de Insumos', array('controller'=>'input_subcategories', 'action'=>'index'));
$this->Html->addCrumb('Editar', array('controller'=>'input_subcategories', 'action'=>'edit', $this->request->data['InputSubcategory']['id']));

echo $this->Html->link(
	$this->Html->image('back'),
	array('controller'=>'input_subcategories', 'action'=>'index'),
	array('escape'=>false)		
);
?>
<div class="well">
	<?php echo $this->Form->create('InputSubcategory', array('class'=>'form-horizontal')); ?>
		<?php echo $this->Form->input('id', array('type'=>'hidden'));?>
		<fieldset>
			<legend>Editar Subcategoria de Insumo</legend>
			<div class="control-group required">
				<label class="control-label" for="Nome da subcategoria de insumo">Nome</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('name', 
						array(
							'label'=>false, 
							'class'=>'input-xlarge',
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Descrição da subcategoria de insumo">Descrição</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('description', 
						array(
							'label'=>false, 
							'class'=>'input-xxlarge'							
						)
					);
					?>
				</div>
			</div>
			<div class="form-actions">
				<?php echo $this->Form->button('Enviar', array('class'=>'btn btn-primary', 'type'=>'submit'));?>
      			<?php echo $this->Html->link('Cancelar', array('controller'=>'input_subcategories', 'action'=>'index'), array('class'=>'btn'));?>
    		</div>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
<script>
$('#InputSubcategoryEditForm').validate({
	ignore: "",
	rules: {
		'data[InputSubcategory][name]': {
		    required: true
		},
		'data[InputSubcategory][description]': {
		    required: true
		}
	},
	messages: {
		'data[InputSubcategory][name]': {
		    required: 'Campo obrigatório'
		},
		'data[InputSubcategory][description]': {
		    required: 'Campo obrigatório'
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