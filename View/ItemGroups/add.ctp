<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Grupos dos itens', array('controller'=>'item_groups', 'action'=>'index'));
$this->Html->addCrumb('Adicionar', array('controller'=>'item_groups', 'action'=>'add'));

echo $this->Html->link(
	$this->Html->image('back.png'),
	array('controller'=>'item_groups', 'action'=>'index'),
	array('escape'=>false)		
);
?>
<div class="well">
	<?php echo $this->Form->create('ItemGroup', array('class'=>'form-horizontal')); ?>
		<fieldset>
			<legend>Adicionar Grupo do Item</legend>
			<div class="control-group required">
				<label class="control-label" for="Tipo do grupo">Tipo do Grupo</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('group_type_id', 
						array(
							'label'=>false, 
							'class'=>'input',
							'options'=>$types
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Código do grupo">Código</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('keycode', 
						array(
							'label'=>false, 
							'class'=>'input',
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Nome do grupo do item">Nome</label>
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
      			<?php echo $this->Html->link('Cancelar', array('controller'=>'item_groups', 'action'=>'index'), array('class'=>'btn'));?>
    		</div>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
<script>
$('#ItemGroupAddForm').validate({
	ignore: "",
	rules: {
		'data[ItemGroup][group_type_id]': {
		    required: true
		},
		'data[ItemGroup][keycode]': {
		    required: true
		},
		'data[ItemGroup][name]': {
		    required: true
		}
	},
	messages: {
		'data[ItemGroup][group_type_id]': {
			required: 'Campo obrigatório'
		},
		'data[ItemGroup][keycode]': {
			required: 'Campo obrigatório'
		},
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