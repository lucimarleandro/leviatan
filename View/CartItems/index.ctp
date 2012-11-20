<?php 
$this->Html->addCrumb('Solicitações', '/solicitations/');
$this->Html->addCrumb('Finalizar', '/cart_items/');
?>
<div>
	<?php if(empty($items)) {?>
		<h3><?php echo __('Não há Itens');?></h3>
	<?php }else {?>
		<?php if(!$ajax) {?>
		<ul class="nav nav-tabs" id="myTab">
			<li class="active"><a title="Descrição da solicitação" href="#text"><?php echo __('Descrição')?></a></li>
			<li><a title="Itens da solicitação" href="#items"><?php echo __('Itens')?></a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active well" id="text">	
				<div id="validation"></div>
				<?php echo $this->Form->create('Solicitation', array('class'=>'form-horizontal')); ?>
				<fieldset>
					<div class="control-group required">
						<label class="control-label" for="grupo do item">Nº do memorando</label>
						<div class="controls">
							<?php 
							echo $this->Form->input('memo_number', 
								array(
									'label'=>false, 
									'class'=>'input-mini',
								)
							);
							?>
						</div>
					</div>
					<div class="control-group required">
						<label class="control-label" for="nome do item">Descrição</label>
						<div class="controls">
							<?php 
							echo $this->Tinymce->input('Solicitation.description', 
								array(
									'label'=>false,
									'class'=>'span6',
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
				</fieldset>
				<?php echo $this->Form->end();?>
			</div>
			<div class="tab-pane well" id="items">
				<?php echo $this->element('ajax/cart_items/index');?>
			</div>		
		</div>
	<?php }else {	
		echo $this->element('ajax/cart_items/index');
	}
}?>
</div>

<script>
$('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
});
$('#SolicitationIndexForm').validate({
	ignore: "",
	rules: {
		'data[Solicitation][memo_number]': {
		    required: true
		},
		'data[Solicitation][description]': {
		    required: true
		}
	},
	messages: {
		'data[Solicitation][memo_number]': {
		    required: 'Campo obrigatório'
		},
		'data[Solicitation][description]': {
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