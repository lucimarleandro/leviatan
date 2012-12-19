<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'index'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Categorias de Insumos', array('controller'=>'input_categories', 'action'=>'index'));
$this->Html->addCrumb('Editar', array('controller'=>'input_categories', 'action'=>'edit', $this->request->data['InputCategory']['id']));

echo $this->Html->link(
	$this->Html->image('back'),
	array('controller'=>'input_categories', 'action'=>'index'),
	array('escape'=>false)		
);
?>
<div class="well">
	<?php echo $this->Form->create('InputCategory', array('class'=>'form-horizontal')); ?>
		<?php echo $this->Form->input('id', array('type'=>'hidden'));?>
		<fieldset>
			<legend>Editar Categoria de Insumo</legend>
			<div class="control-group required">
				<label class="control-label" for="Nome da categoria de insumo">Nome</label>
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
				<label class="control-label" for="Descrição do da categoria de insumo">Descrição</label>
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
      			<?php echo $this->Html->link('Cancelar', array('controller'=>'input_categories', 'action'=>'index'), array('class'=>'btn'));?>
    		</div>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
<script>
$('#InputCategoryEditForm').validate({
	ignore: "",
	rules: {
		'data[InputCategory][name]': {
		    required: true
		},
		'data[InputCategory][description]': {
		    required: true
		}
	},
	messages: {
		'data[InputCategory][name]': {
		    required: 'Campo obrigatório'
		},
		'data[InputCategory][description]': {
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