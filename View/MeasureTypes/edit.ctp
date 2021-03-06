<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Unidades de Medidas', array('controller'=>'measure_types', 'action'=>'index'));
$this->Html->addCrumb('editar', array('controller'=>'measure_types', 'action'=>'edit', $this->request->data['MeasureType']['id']));

echo $this->Html->link(
	$this->Html->image('back.png'),
	array('controller'=>'measure_types', 'action'=>'index'),
	array('escape'=>false)		
);
?>
<div class="well">
	<?php echo $this->Form->create('MeasureType', array('class'=>'form-horizontal')); ?>
		<fieldset>
			<legend>Adicionar Unidade de Medida</legend>
			<div class="control-group required">
				<label class="control-label" for="Nome da unidade de medida">Nome</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('name', 
						array(
							'label'=>false, 
							'class'=>'input',
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Descrição da unidade de medida">Descrição</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('description', 
						array(
							'label'=>false, 
							'class'=>'input',
						)
					);
					?>
				</div>
			</div>
			<div class="form-actions">
				<?php echo $this->Form->button('Enviar', array('class'=>'btn btn-primary', 'type'=>'submit'));?>
      			<?php echo $this->Html->link('Cancelar', array('controller'=>'measure_types', 'action'=>'index'), array('class'=>'btn'));?>
    		</div>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
<script>
$('#MeasureTypeEditForm').validate({
	ignore: "",
	rules: {
		'data[MeasureType][name]': {
		    required: true
		},
		'data[MeasureType][description]': {
		    required: true
		}
	},
	messages: {
		'data[MeasureType][name]': {
		    required: 'Campo obrigatório'
		},
		'data[MeasureType][description]': {
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