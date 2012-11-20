<?php
$this->Html->addCrumb('Gerência', '/manager/');
$this->Html->addCrumb('Usuários', '/users/');
$this->Html->addCrumb('Adicionar', '/users/add');

echo $this->Html->link(
	$this->Html->image('back'),
	array('controller'=>'users', 'action'=>'index'),
	array('escape'=>false)		
);
?>
<div class="well">
	<?php echo $this->Form->create('User', array('class'=>'form-horizontal')); ?>
		<fieldset>
			<legend>Adicionar usuário</legend>
			<div class="control-group required">
				<label class="control-label" for="Unidade">Grupo</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('group_id', 
						array(
							'label'=>false, 
							'class'=>'input',
							'options'=>$groups
						)
					);
					?>
				</div>
			</div>			
			<div class="control-group required">
				<label class="control-label" for="Setor">Funcionário</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('employee_id', 
						array(
							'label'=>false, 
							'class'=>'input',
							'options'=>$employees
						)
					);
					?>
				</div>
			</div>
			
			<div class="form-actions">
				<?php echo $this->Form->button('Enviar', array('class'=>'btn btn-primary', 'type'=>'submit'));?>
      			<?php echo $this->Html->link('Cancelar', array('controller'=>'users', 'action'=>'index'), array('class'=>'btn'));?>
    		</div>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
<script>
					
$('#UserAddForm').validate({
	ignore: "",
	rules: {
		'data[User][group_id]': {
		    required: true
		},
		'data[User][employee_id]': {
		    required: true
		},
	},
	messages: {
		'data[User][group_id]': {
		    required: "Campo obrigatório"
		},
		'data[User][employee_id]': {
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