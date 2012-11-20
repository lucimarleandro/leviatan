<?php 
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Tipos de Unidades', '/unity_types/');
$this->Html->addCrumb('Editar', '/unity_types/edit/'.$this->request->data['UnityType']['id']);

echo $this->Html->link(
	$this->Html->image('back'),
	array('controller'=>'unity_types', 'action'=>'index'),
	array('escape'=>false)		
);
?>
<div class="well">
	<?php echo $this->Form->create('UnityType', array('class'=>'form-horizontal')); ?>
		<?php echo $this->Form->input('id', array('type'=>'hidden'));?>
		<fieldset>
			<legend>Adicionar Setor</legend>
			<div class="control-group required">
				<label class="control-label" for="Nome do tipo da unidade">Nome</label>
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
			<div class="form-actions">
				<?php echo $this->Form->button('Enviar', array('class'=>'btn btn-primary', 'type'=>'submit'));?>
      			<?php echo $this->Html->link('Cancelar', array('controller'=>'unity_types', 'action'=>'index'), array('class'=>'btn'));?>
    		</div>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
<script>
$('#UnityTypeEditForm').validate({
	ignore: "",
	rules: {
		'data[UnityType][name]': {
		    required: true
		}
	},
	messages: {
		'data[UnityType][name]': {
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