<?php 
$this->Html->addCrumb('Home', array('controller'=>'items', 'action'=>'home'));
$this->Html->addCrumb('Gerência', array('controller'=>'manager', 'action'=>'index'));
$this->Html->addCrumb('Unidades de Medidas', array('controller'=>'expense_groups', 'action'=>'index'));
$this->Html->addCrumb('Editar', array('controller'=>'expense_groups', 'action'=>'exit', $this->request->data['ExpenseGroup']['id']));

echo $this->Html->link(
	$this->Html->image('back.png'),
	array('controller'=>'expense_groups', 'action'=>'index'),
	array('escape'=>false)		
);
?>
<div class="well">
	<?php echo $this->Form->create('ExpenseGroup', array('class'=>'form-horizontal')); ?>
		<?php echo $this->Form->input('id', array('type'=>'hidden'));?>
		<fieldset>
			<legend>Editar Grupo de Gasto</legend>
			<div class="control-group required">
				<label class="control-label" for="Nome do grupo de gasto">Nome</label>
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
				<label class="control-label" for="Descrição do grupo de gasto">Descrição</label>
				<div class="controls">
					<?php 
                    echo $this->Tinymce->input('ExpenseGroup.description', 
                        array(
                            'label'=>false,
                            'class'=>'span9',
                            'rows'=>10
                        ),array(
                            'language'=>'pt',
                            'onchange_callback'=>'function(editor) {
                                tinyMCE.triggerSave();
                                $("#" + editor.id).valid();
                            }'
                        ),
                        'basic'
                    );
                    ?>
				</div>
			</div>
			<div class="form-actions">
				<?php echo $this->Form->button('Enviar', array('class'=>'btn btn-primary', 'type'=>'submit'));?>
      			<?php echo $this->Html->link('Cancelar', array('controller'=>'expense_groups', 'action'=>'index'), array('class'=>'btn'));?>
    		</div>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
<script>
$('#ExpenseGroupEditForm').validate({
	ignore: "",
	rules: {
		'data[ExpenseGroup][name]': {
		    required: true
		},
		'data[ExpenseGroup][description]': {
		    required: true
		}
	},
	messages: {
		'data[ExpenseGroup][name]': {
		    required: 'Campo obrigatório'
		},
		'data[ExpenseGroup][description]': {
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