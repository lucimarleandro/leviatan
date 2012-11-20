<?php
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Grupos', '/groups/');
$this->Html->addCrumb('Adicionar', '/groups/add');

echo $this->Html->link(
	$this->Html->image('back'),
	array('controller'=>'groups', 'action'=>'index'),
	array('escape'=>false)		
);
?>
<div class="well">
	<?php echo $this->Form->create('Group', array('class'=>'form-horizontal')); ?>
		<fieldset>
			<legend>Adicionar grupo</legend>
			<div class="control-group required">
				<label class="control-label" for="Unidade">Nome</label>
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
      			<?php echo $this->Html->link('Cancelar', array('controller'=>'groups', 'action'=>'index'), array('class'=>'btn'));?>
    		</div>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
<script>
					
$('#GroupAddForm').validate({
	ignore: "",
	rules: {
		'data[User][name]': {
		    required: true
		},
	},
	messages: {
		'data[Group][name]': {
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