<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Setores', array('controller'=>'sectors', 'action'=>'index'));
$this->Html->addCrumb('Adicionar', array('controller'=>'sectors', 'action'=>'add'));

echo $this->Html->link(
	$this->Html->image('back.png'),
	array('controller'=>'sectors', 'action'=>'index'),
	array('escape'=>false)		
);
?>
<div class="well">
	<?php echo $this->Form->create('Sector', array('class'=>'form-horizontal')); ?>
		<fieldset>
			<legend>Adicionar Setor</legend>
			<div class="control-group required">
				<label class="control-label" for="Nome do setor">Nome</label>
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
      			<?php echo $this->Html->link('Cancelar', array('controller'=>'sectors', 'action'=>'index'), array('class'=>'btn'));?>
    		</div>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
<script>
$('#SectorAddForm').validate({
	ignore: "",
	rules: {
		'data[Sector][name]': {
		    required: true
		}
	},
	messages: {
		'data[Sector][name]': {
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