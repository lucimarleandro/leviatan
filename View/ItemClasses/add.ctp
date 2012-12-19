<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Classes dos Itens', array('controller'=>'item_classes', 'action'=>'index'));
$this->Html->addCrumb('Adicionar', array('controller'=>'item_classes', 'action'=>'add'));

echo $this->Html->link(
	$this->Html->image('back'),
	array('controller'=>'item_classes', 'action'=>'index'),
	array('escape'=>false)		
);
?>
<div class="well">
	<?php echo $this->Form->create('ItemClass', array('class'=>'form-horizontal')); ?>
		<fieldset>
			<legend>Adicionar Classe do Item</legend>
			<div class="control-group required">
				<label class="control-label" for="grupo do Item">Grupo do Item</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('item_group_id', 
						array(
							'label'=>false, 
							'class'=>'input-xxlarge',
							'options'=>$groups
						)
					);
					?>
				</div>
			</div>
			<div class="control-group required">
				<label class="control-label" for="Código da classe">Código</label>
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
				<label class="control-label" for="Nome da classe do item">Nome</label>
				<div class="controls">
					<?php 
					echo $this->Form->input('name', 
						array(
							'label'=>false, 
							'class'=>'input-xxlarge',
						)
					);
					?>
				</div>
			</div>
			<div class="form-actions">
				<?php echo $this->Form->button('Enviar', array('class'=>'btn btn-primary', 'type'=>'submit'));?>
      			<?php echo $this->Html->link('Cancelar', array('controller'=>'item_classes', 'action'=>'index'), array('class'=>'btn'));?>
    		</div>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
<script>
$('#ItemClassAddForm').validate({
	ignore: "",
	rules: {
		'data[ItemClass][item_group_id]': {
		    required: true
		},
		'data[ItemClass][keycode]': {
		    required: true
		},
		'data[ItemClass][name]': {
		    required: true
		}
	},
	messages: {
		'data[ItemClass][item_group_id]': {
			required: 'Campo obrigatório'
		},
		'data[ItemClass][keycode]': {
			required: 'Campo obrigatório'
		},
		'data[ItemClass][name]': {
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