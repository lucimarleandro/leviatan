 <div class="modal hide" id="myModal">
	<div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal">×</button>
    	<h3>Justificativa da negação</h3>
  	</div>
  	<div class="modal-body">
    	<?php echo $this->Form->create('Justification');?>
    		<?php 
    		echo $this->Form->input('solicitation_item_id', array('type'=>'hidden', 'value'=>$solicitation_item_id));
			echo $this->Tinymce->input('Justification.description', 
				array(
					'label'=>false,
					'class'=>'span5',
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
  	<div class="modal-footer">
    		<a href="javascript:void(0)" class="btn" data-dismiss="modal">Fechar</a>
    		<?php echo $this->Form->button('Salvar', array('class'=>'btn btn-primary', 'id'=>'save-justification', 'type'=>'button'));?>
	   	<?php echo $this->Form->end();?>
  	</div>
</div>

<script>
$('#save-justification').click(function(){

	if($('#JustificationAddForm').valid() == false) {
		return false;
	}
	var solicitation_item_id = $('#JustificationSolicitationItemId').val();
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		data: $("#JustificationAddForm").serialize(),
		url: forUrl('/justifications/add'),
		success: function(result) {
			if(result['return']) {
				$('#myModal').modal('hide');
				$('#element-'+solicitation_item_id).html(
					'<a class="deny-visualization" value="'+solicitation_item_id+'" title="Não aceitar o item" href="javascript:void(0)">' +
						'<img alt="" src="/img/deny">' +
					'</a>'
				);
                $('.select[data-solicitation-item-id="'+solicitation_item_id+'"]').attr('disabled', true);
			}else {
				$('#alert-message').html('<div id="flashMessage" class="alert alert-error">Não foi possível concluir a operação. Por favor, entre em contato com o administrador do sistema</div>');
				return false;
			}
		}
	});	
});

$('#JustificationAddForm').validate({
	ignore: "",
	rules: {
		'data[Justification][description]': {
		    required: true
		}
	},
	messages: {
		'data[Justification][description]': {
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
		label.insertAfter(element);
	}
});
</script>